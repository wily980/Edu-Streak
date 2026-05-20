<?php
namespace App\Controllers;

require_once '../app/core/Database.php';
use App\Core\Database;

class StudentController
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // GET /students — language picker home page
    public function index()
    {
        if (empty($_SESSION['user'])) {
            header('Location: /');
            exit;
        }

        // Fresh user data
        $user = $this->db->fetchOne(
            "SELECT id, name, email, avatar_url, gems, hearts, xp_total FROM usr_users WHERE id = ?",
            [$_SESSION['user']['id']]
        );

        if (!$user) {
            session_destroy();
            header('Location: /');
            exit;
        }

        $_SESSION['user'] = array_merge($_SESSION['user'], $user);

        // Streak
        $streak = $this->db->fetchOne(
            "SELECT current_streak FROM usr_streaks WHERE user_id = ?",
            [$user['id']]
        );
        $user['streak'] = $streak['current_streak'] ?? 0;

        // All languages with user progress (% completion per language)
        $languages = $this->db->fetchAll(
            "SELECT 
                l.id, l.name, l.slug, l.icon_url, l.color_hex,
                COUNT(DISTINCT t.id) AS total_tracks,
                COALESCE(ROUND(AVG(ut.completion_pct), 0), 0) AS progress_pct
             FROM cnt_languages l
             LEFT JOIN cnt_tracks t ON t.language_id = l.id
             LEFT JOIN prg_user_tracks ut ON ut.track_id = t.id AND ut.user_id = ?
             GROUP BY l.id
             ORDER BY l.name ASC",
            [$user['id']]
        );

        require_once '../app/views/students/index.php';
    }

    // GET /students/{slug}/levels — stage map for a language
    public function levels($slug)
    {
        if (empty($_SESSION['user'])) {
            header('Location: /');
            exit;
        }

        $user = $this->db->fetchOne(
            "SELECT id, name, email, avatar_url, gems, hearts, xp_total FROM usr_users WHERE id = ?",
            [$_SESSION['user']['id']]
        );

        if (!$user) {
            session_destroy();
            header('Location: /');
            exit;
        }

        $_SESSION['user'] = array_merge($_SESSION['user'], $user);

        $streak = $this->db->fetchOne(
            "SELECT current_streak FROM usr_streaks WHERE user_id = ?",
            [$user['id']]
        );
        $user['streak'] = $streak['current_streak'] ?? 0;

        // Language info
        $language = $this->db->fetchOne(
            "SELECT * FROM cnt_languages WHERE slug = ?",
            [$slug]
        );

        if (!$language) {
            header('Location: /students');
            exit;
        }

        // Tracks (levels) for this language with user progress
        $tracks = $this->db->fetchAll(
            "SELECT 
                t.id, t.title, t.difficulty, t.order_index, t.total_lessons,
                COALESCE(ut.completion_pct, 0) AS completion_pct,
                COALESCE(ut.xp_earned, 0) AS xp_earned
             FROM cnt_tracks t
             LEFT JOIN prg_user_tracks ut ON ut.track_id = t.id AND ut.user_id = ?
             WHERE t.language_id = ?
             ORDER BY t.order_index ASC",
            [$user['id'], $language['id']]
        );

        require_once '../app/views/level/levels.php';
    }

    public function create() {}
    public function show($id) {}
    public function edit($id) {}
    public function store() {}
    public function update($id) {}
    public function destroy($id) {}
}
?>