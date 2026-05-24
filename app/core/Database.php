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
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function query(string $sql, array $params = []): mixed
    {
        $stmt = mysqli_prepare($this->connection, $sql);
        if ($params) {
            $types = str_repeat('s', count($params)); // default buat semua string
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }

    public function fetchAll(string $sql, array $params = []): array
    {
        $result = $this->query($sql, $params);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function fetchOne(string $sql, array $params = []): ?array
    {
        $result = $this->query($sql, $params);
        $row = mysqli_fetch_assoc($result);
        return $row ?: null;
    }

    public function execute(string $sql, array $params = []): bool
    {
        $stmt = mysqli_prepare($this->connection, $sql);
        if ($params) {
            $types = str_repeat('s', count($params));
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }
        return mysqli_stmt_execute($stmt);
    }
}
?>