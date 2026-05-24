<?php
namespace App\Controllers;

require_once '../app/config/app.php';
require_once '../app/core/Database.php';

class LeaderboardController
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

        $userId = $_SESSION['user']['id'];

        // Top 10 users by total XP across all languages
        $topUsers = $this->db->fetchAll(
            "SELECT 
                u.id,
                u.name,
                u.username,
                u.avatar_url,
                COALESCE(SUM(ull.xp_in_level), 0) AS total_xp,
                COALESCE(MAX(ull.level_num), 1) AS level,
                COALESCE(s.current_streak, 0) AS streak
            FROM usr_users u
            LEFT JOIN usr_language_levels ull ON ull.user_id = u.id
            LEFT JOIN usr_streaks s ON s.user_id = u.id
            GROUP BY u.id, u.name, u.username, u.avatar_url, s.current_streak
            ORDER BY total_xp DESC
            LIMIT 10",
            []
        );

        // Current user's rank
        $myRank = $this->db->fetchOne(
            "SELECT rank_pos FROM (
                SELECT 
                    u.id,
                    RANK() OVER (ORDER BY COALESCE(SUM(ull.xp_in_level), 0) DESC) AS rank_pos
                FROM usr_users u
                LEFT JOIN usr_language_levels ull ON ull.user_id = u.id
                GROUP BY u.id
            ) ranked
            WHERE id = ?",
            [$userId]
        );

        $user    = $_SESSION['user'];
        $myRank  = $myRank['rank_pos'] ?? '-';

        require_once '../app/views/leaderboard/leaderboard.php';
    }
}
