<?php

namespace App\Controllers;

require_once '../app/config/app.php';
require_once '../app/core/Database.php';

class LevelController
{
    private \App\Core\Database $db;

    public function __construct()
    {
        $this->db = new \App\Core\Database();
    }

    public function index()
    {
        if (empty($_SESSION['user'])) {
            header('Location: /');
            exit;
        }

        $user   = $_SESSION['user'];
        $userId = $user['id'];
        $slug   = $_GET['lang'] ?? null;

        if (!$slug) {
            header('Location: /learn');
            exit;
        }

        $language = $this->db->fetchOne(
            "SELECT * FROM cnt_languages WHERE slug = ?",
            [$slug]
        );

        if (!$language) {
            http_response_code(404);
            echo '<h1>Language not found</h1>';
            exit;
        }

        $tracks = $this->db->fetchAll(
            "SELECT 
                t.id,
                t.title,
                t.order_index AS position,
                COALESCE(
                    ROUND(
                        (SELECT COUNT(*) 
                         FROM prg_lesson_progress plp 
                         WHERE plp.lesson_id IN (
                             SELECT id FROM cnt_lessons WHERE track_id = t.id
                         )
                         AND plp.user_id = ?
                         AND plp.status = 'completed')
                        /
                        NULLIF(t.total_lessons, 0)
                        * 100
                    ), 0
                ) AS completion_pct
            FROM cnt_tracks t
            WHERE t.language_id = ?
            ORDER BY t.order_index ASC",
            [$userId, $language['id']]
        );

        $user = $this->db->fetchOne(
            "SELECT u.*, COALESCE(s.current_streak, 0) AS streak
             FROM usr_users u
             LEFT JOIN usr_streaks s ON s.user_id = u.id
             WHERE u.id = ?",
            [$userId]
        );

        $_SESSION['user'] = $user;

        require_once '../app/views/level/levels.php';
    }
}
?>