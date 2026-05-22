<?php
namespace App\Controllers;

require_once '../app/core/Database.php';

class PreferenceController
{
    private \App\Core\Database $db;

    public function __construct()
    {
        $this->db = new \App\Core\Database();
    }

    public function index()
    {
        if (empty($_SESSION['user'])) { header('Location: /'); exit; }
        
        // Get language from query string passed from /learn
        $slug = $_GET['lang'] ?? null;
        if (!$slug) { header('Location: /learn'); exit; }

        $language = $this->db->fetchOne(
            "SELECT * FROM cnt_languages WHERE slug = ?", [$slug]
        );

        require_once '../app/views/Preference/preferences.php';
    }

    public function store()
{
    if (empty($_SESSION['user'])) { header('Location: /'); exit; }

    $level  = $_POST['level'] ?? null;
    $slug   = $_POST['lang']  ?? null;
    $userId = $_SESSION['user']['id'];

    if ($level && $slug) {
        // Get language id from slug
        $language = $this->db->fetchOne(
            "SELECT * FROM cnt_languages WHERE slug = ?", [$slug]
        );

        if ($language) {
            $this->db->execute(
                "INSERT INTO usr_language_levels 
                    (id, user_id, language_id, knowledge_level, level, level_num, xp_in_level, xp_to_next_level, last_activity_at)
                 VALUES (UUID(), ?, ?, ?, 'beginner', 1, 0, 200, NOW())
                 ON DUPLICATE KEY UPDATE knowledge_level = ?",
                [$userId, $language['id'], $level, $level]
            );
        }
    }

    header('Location: /level?lang=' . $slug);
    exit;
}
}