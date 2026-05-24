<?php

namespace App\Controllers;

require_once '../app/config/app.php';
require_once '../app/core/Database.php';

class CodeController
{
    private \App\Core\Database $db;

    public function __construct()
    {
        $this->db = new \App\Core\Database();
    }

    public function index()
    {
        if (empty($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/');
            exit;
        }

        $user   = $_SESSION['user'];
        $userId = $user['id'];

        $history = $this->db->fetchAll(
            "SELECT 
                l.title AS lesson_title,
                l.type,
                l.xp_reward,
                l.gem_reward,
                t.title AS track_title,
                t.difficulty,
                lang.name AS language_name,
                lang.icon_url AS language_icon,
                lang.slug AS language_slug,
                plp.status,
                plp.score,
                plp.attempts,
                plp.completed_at
            FROM prg_lesson_progress plp
            JOIN cnt_lessons l ON l.id = plp.lesson_id
            JOIN cnt_tracks t ON t.id = l.track_id
            JOIN cnt_languages lang ON lang.id = t.language_id
            WHERE plp.user_id = ?
            ORDER BY plp.completed_at DESC",
            [$userId]
        );

        $user = $this->db->fetchOne(
            "SELECT u.*, COALESCE(s.current_streak, 0) AS streak
             FROM usr_users u
             LEFT JOIN usr_streaks s ON s.user_id = u.id
             WHERE u.id = ?",
            [$userId]
        );

        $_SESSION['user'] = $user;

        require_once '../app/views/History/history.php';
    }
}
?>