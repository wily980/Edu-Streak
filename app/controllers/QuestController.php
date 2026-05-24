<?php
// app/controllers/QuestController.php

namespace App\Controllers;

require_once '../app/config/app.php';
require_once '../app/core/Database.php';

class QuestController
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
        $user   = $_SESSION['user'];

        // ── Daily quests ──────────────────────────────────────────────
        // Quest 1: Complete 3 lessons today
        $lessonsToday = $this->db->fetchOne(
            "SELECT COUNT(*) AS cnt FROM prg_lesson_progress
             WHERE user_id = ? AND DATE(completed_at) = CURDATE()",
            [$userId]
        )['cnt'] ?? 0;

        // Quest 2: Current streak
        $streakRow = $this->db->fetchOne(
            "SELECT current_streak FROM usr_streaks WHERE user_id = ?",
            [$userId]
        );
        $currentStreak = (int)($streakRow['current_streak'] ?? 0);

        $dailyQuests = [
            [
                'id'         => 'daily_lessons',
                'icon'       => 'petir',
                'title'      => 'Complete 3 lessons today',
                'progress'   => min($lessonsToday, 3),
                'goal'       => 3,
                'xp_reward'  => 30,
                'gem_reward' => 5,
                'done'       => $lessonsToday >= 3,
            ],
            [
                'id'         => 'daily_streak',
                'icon'       => 'streak-black',
                'title'      => 'Keep up your streak today',
                'progress'   => min($currentStreak, 1),
                'goal'       => 1,
                'xp_reward'  => 20,
                'gem_reward' => 3,
                'done'       => $currentStreak >= 1,
            ],
        ];

        // ── Monthly quests ────────────────────────────────────────────
        $monthlyQuests = [
            [
                'id'         => 'monthly_streak_20',
                'icon'       => 'petir',
                'title'      => 'Keep up with your streak 20 times',
                'progress'   => min($currentStreak, 20),
                'goal'       => 20,
                'xp_reward'  => 200,
                'gem_reward' => 30,
                'done'       => $currentStreak >= 20,
            ],
        ];

        // ── User stats for topbar ─────────────────────────────────────
        $streak = $currentStreak;
        $gems   = (int)($user['gems']   ?? 0);
        $hearts = (int)($user['hearts'] ?? 5);

        // ── Render view ───────────────────────────────────────────────
        require_once '../app/views/Quest/quest.php';
    }
}