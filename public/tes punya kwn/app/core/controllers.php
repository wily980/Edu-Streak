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

    public function index()
    {
        $students = $this->db->fetchAll("SELECT * FROM usr_users");
        require_once '../app/views/students/index.php';
    }
}
?>