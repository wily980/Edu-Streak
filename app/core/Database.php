<?php
namespace App\Core;
require_once '../app/config/app.php';
class Database
{
    protected $connection;

    public function __construct()
    {
        $this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$this->connection) {
            die("Connection failed: ");
        }
    }

}

?>