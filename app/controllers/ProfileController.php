<?php
namespace App\Controllers;

require_once '../app/config/app.php';
require_once '../app/core/Database.php';

class ProfileController
{
    private \App\Core\Database $db;

    public function __construct()
    {
        $this->db = new \App\Core\Database();
    }

    public function index()
    {
        if (empty($_SESSION['user'])) { header('Location: ' . BASE_URL . '/'); exit; }

        $userId = $_SESSION['user']['id'];

        $user = $this->db->fetchOne(
            "SELECT u.*, COALESCE(s.current_streak, 0) AS streak
             FROM usr_users u
             LEFT JOIN usr_streaks s ON s.user_id = u.id
             WHERE u.id = ?",
            [$userId]
        );

        // Total XP
        $xpRow = $this->db->fetchOne(
            "SELECT COALESCE(SUM(xp_in_level), 0) AS total_xp FROM usr_language_levels WHERE user_id = ?",
            [$userId]
        );
        $totalXp = $xpRow['total_xp'] ?? 0;

        // Languages being learned
        $languages = $this->db->fetchAll(
            "SELECT l.name, l.icon_url, ull.level_num, ull.xp_in_level
             FROM usr_language_levels ull
             JOIN cnt_languages l ON l.id = ull.language_id
             WHERE ull.user_id = ?",
            [$userId]
        );

        // Stats
        $statsRow = $this->db->fetchOne(
            "SELECT 
                COUNT(*) AS lessons_done
             FROM prg_lesson_progress
             WHERE user_id = ? AND status = 'completed'",
            [$userId]
        );
        $lessonsDone = $statsRow['lessons_done'] ?? 0;

        $_SESSION['user'] = $user;

        require_once '../app/views/Profile/profile.php';
    }

    public function edit()
    {
        if (empty($_SESSION['user'])) { header('Location: ' . BASE_URL . '/'); exit; }

        $userId   = $_SESSION['user']['id'];
        $username = trim($_POST['username'] ?? '');
        $bio      = trim($_POST['bio'] ?? '');
        $avatar   = $_SESSION['user']['avatar_url'];
        $banner   = $_SESSION['user']['banner_url'] ?? '';

        // Handle avatar upload
        if (!empty($_FILES['avatar']['tmp_name'])) {
            $ext    = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $fname  = 'avatar_' . $userId . '.' . $ext;
            $dest   = __DIR__ . '/../../public/uploads/' . $fname;
            move_uploaded_file($_FILES['avatar']['tmp_name'], $dest);
            $avatar = BASE_URL . '/uploads/' . $fname;
        }

        // Handle banner upload
        if (!empty($_FILES['banner']['tmp_name'])) {
            $ext    = pathinfo($_FILES['banner']['name'], PATHINFO_EXTENSION);
            $fname  = 'banner_' . $userId . '.' . $ext;
            $dest   = __DIR__ . '/../../public/uploads/' . $fname;
            move_uploaded_file($_FILES['banner']['tmp_name'], $dest);
            $banner = BASE_URL . '/uploads/' . $fname;
        }

        $this->db->execute(
            "UPDATE usr_users SET username = ?, bio = ?, avatar_url = ?, banner_url = ? WHERE id = ?",
            [$username ?: $_SESSION['user']['username'], $bio, $avatar, $banner, $userId]
        );

        // Refresh session
        $_SESSION['user'] = $this->db->fetchOne("SELECT * FROM usr_users WHERE id = ?", [$userId]);

        header('Location: ' . BASE_URL . '/profile');
        exit;
    }
}
