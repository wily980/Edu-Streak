<?php
namespace App\Controllers;

require_once '../app/core/Database.php';
use App\Core\Database;

class LanguageController
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function index()
    {
        $languages = $this->db->fetchAll("SELECT * FROM cnt_languages");
        require_once '../app/views/learn/index.php';
    }

    public function store()
{
    $languageId = $_POST['language_id'] ?? null;
    $userId = $_SESSION['user']['id'] ?? null;

    if (!$languageId || !$userId) {
        header('Location: /learn');
        exit;
    }

    $this->db->execute(
        "INSERT INTO usr_language_levels (id, user_id, language_id) VALUES (UUID(), ?, ?) 
         ON DUPLICATE KEY UPDATE language_id = language_id",
        [$userId, $languageId]
    );

    //  maling the language so we can get its slug
    $language = $this->db->fetchOne(
        "SELECT * FROM cnt_languages WHERE id = ?",
        [$languageId]
    );

    if (!$language) {
        header('Location: /learn');
        exit;
    }

    header('Location: /preference?lang=' . $language['slug']);
    exit;
}
}