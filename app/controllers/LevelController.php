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
            // Only use session if it's a valid programming language slug
            $validSlugs = ['cpp','csharp','css','html','java','javascript','php','python'];

            if (!empty($_SESSION['last_lang']) && in_array($_SESSION['last_lang'], $validSlugs)) {
                $slug = $_SESSION['last_lang'];
            } else {
                // Clear bad session value (e.g. 'english')
                unset($_SESSION['last_lang']);

                // Get last language from DB progress
                $lastProgress = $this->db->fetchOne(
                    "SELECT l.slug FROM cnt_languages l
                     JOIN cnt_tracks t ON t.language_id = l.id
                     JOIN cnt_lessons ls ON ls.track_id = t.id
                     JOIN prg_lesson_progress plp ON plp.lesson_id = ls.id
                     WHERE plp.user_id = ?
                     ORDER BY plp.completed_at DESC
                     LIMIT 1",
                    [$userId]
                );

                $slug = $lastProgress['slug'] ?? null;
            }

            // No progress yet, default to cpp
            if (!$slug) {
                $slug = 'cpp';
            }
        }

        // Save valid slug to session
        $_SESSION['last_lang'] = $slug;

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