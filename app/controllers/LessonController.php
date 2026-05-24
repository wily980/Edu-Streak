<?php
namespace App\Controllers;

require_once '../app/config/app.php';
require_once '../app/core/Database.php';

class LessonController
{
    private \App\Core\Database $db;

    public function __construct()
    {
        $this->db = new \App\Core\Database();
    }

    // GET /lesson?track_id=xxx
    public function index()
    {
        if (empty($_SESSION['user'])) { header('Location: ' . BASE_URL . '/'); exit; }

        $userId  = $_SESSION['user']['id'];
        $trackId = $_GET['track_id'] ?? null;

        if (!$trackId) { header('Location: ' . BASE_URL . '/learn'); exit; }

        // Get track info
        $track = $this->db->fetchOne(
            "SELECT t.*, l.name AS lang_name, l.slug AS lang_slug, l.icon_url AS lang_icon
             FROM cnt_tracks t
             JOIN cnt_languages l ON l.id = t.language_id
             WHERE t.id = ?",
            [$trackId]
        );

        if (!$track) { http_response_code(404); echo '<h1>Track not found</h1>'; exit; }

        // Get lessons for this track
        $lessons = $this->db->fetchAll(
            "SELECT l.*,
                COALESCE(plp.status, 'not_started') AS status
             FROM cnt_lessons l
             LEFT JOIN prg_lesson_progress plp 
                ON plp.lesson_id = l.id AND plp.user_id = ?
             WHERE l.track_id = ?
             ORDER BY l.order_index ASC",
            [$userId, $trackId]
        );

        // Find current lesson — first not completed
        $currentLesson = null;
        $currentIndex  = 0;
        foreach ($lessons as $i => $lesson) {
            if ($lesson['status'] !== 'completed') {
                $currentLesson = $lesson;
                $currentIndex  = $i;
                break;
            }
        }

        // If all done, show last lesson
        if (!$currentLesson && !empty($lessons)) {
            $currentLesson = end($lessons);
            $currentIndex  = count($lessons) - 1;
        }

        // Get questions for current lesson
        $questions = [];
        if ($currentLesson) {
            $questions = $this->db->fetchAll(
                "SELECT q.*, 
                    GROUP_CONCAT(
                        JSON_OBJECT('id', o.id, 'text', o.option_text, 'is_correct', o.is_correct)
                        ORDER BY o.order_index SEPARATOR '||'
                    ) AS options_raw
                 FROM cnt_questions q
                 LEFT JOIN cnt_question_options o ON o.question_id = q.id
                 WHERE q.lesson_id = ?
                 GROUP BY q.id
                 ORDER BY q.order_index ASC",
                [$currentLesson['id']]
            );

            // Parse options
            foreach ($questions as &$q) {
                $q['options'] = [];
                if (!empty($q['options_raw'])) {
                    foreach (explode('||', $q['options_raw']) as $opt) {
                        $q['options'][] = json_decode($opt, true);
                    }
                }
                unset($q['options_raw']);
            }
        }

        $user   = $_SESSION['user'];
        $streak = (int)($user['streak'] ?? 0);
        $hearts = (int)($user['hearts'] ?? 5);
        $gems   = (int)($user['gems'] ?? 0);

        require_once '../app/views/Code/lesson.php';
    }

    // POST /lesson/submit
    public function submit()
    {
        if (empty($_SESSION['user'])) { header('Location: ' . BASE_URL . '/'); exit; }

        $userId   = $_SESSION['user']['id'];
        $lessonId = $_POST['lesson_id'] ?? null;
        $trackId  = $_POST['track_id']  ?? null;
        $score    = (int)($_POST['score'] ?? 0);
        $total    = (int)($_POST['total'] ?? 1);

        if (!$lessonId) { header('Location: ' . BASE_URL . '/learn'); exit; }

        $passed = ($score / $total) >= 0.6; // 60% to pass

        // Mark lesson complete
        $this->db->execute(
            "INSERT INTO prg_lesson_progress (id, user_id, lesson_id, status, score, completed_at)
             VALUES (UUID(), ?, ?, ?, ?, NOW())
             ON DUPLICATE KEY UPDATE 
                status = IF(? = 1, 'completed', status),
                score  = GREATEST(score, ?),
                completed_at = IF(? = 1, NOW(), completed_at)",
            [
                $userId, $lessonId,
                $passed ? 'completed' : 'in_progress',
                $score,
                $passed ? 1 : 0,
                $score,
                $passed ? 1 : 0
            ]
        );

        // Award XP if passed
        if ($passed) {
            $xpEarned = 10 + ($score * 5);

            // Get language_id for this lesson
            $row = $this->db->fetchOne(
                "SELECT t.language_id FROM cnt_lessons l
                 JOIN cnt_tracks t ON t.id = l.track_id
                 WHERE l.id = ?",
                [$lessonId]
            );

            if ($row) {
                $this->db->execute(
                    "UPDATE usr_language_levels 
                     SET xp_in_level = xp_in_level + ?
                     WHERE user_id = ? AND language_id = ?",
                    [$xpEarned, $userId, $row['language_id']]
                );
            }
        }

        // Redirect back to level map
        $lang = $_POST['lang_slug'] ?? 'html';
        header('Location: ' . BASE_URL . '/level?lang=' . $lang . '&result=' . ($passed ? 'pass' : 'fail'));
        exit;
    }
}
