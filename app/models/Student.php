<?php
namespace App\models;
require_once '../app/core/Database.php';
use App\Core\Database;
class Student extends Database
{
protected $table = 'students';
public function getStudents()
{
    $students = [];
    $query = "SELECT * FROM $this->table";
    $stmt = $this->connection->prepare($query);
    $stmt->execute();

    $result = $stmt->get_result();

    while($student = $result->fetch_assoc()) {
        $students[] = $student;
    }

    return $students;
}
//menampilkan detail siswa
public function getStudent(int $id)
{
    $query = "select * from {$this->table} where id = ?";
    $stmt = $this-> connection->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    return $student;    
}
    Public function insert(array $data)
    {
        $name = htmlspecialchars($data['name']);
        $nis = htmlspecialchars($data['nis']);
        $class = htmlspecialchars($data['class']);
        $phoneNumber = htmlspecialchars($data['phone_number']);

        $query = "INSERT INTO {$this->table} (name, nis, class, phone_number) VALUES (?, ?, ?, ?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('ssss', $name, $nis, $class, $phoneNumber);
        $stmt->execute();

        if($stmt->affected_rows > 0) {
            header('Location: /students');
            exit();
    } else {
        echo "Gagal menambahkan data siswa.";
    }
}

//menupdate data siswa
public function update(array $data, int $id)
{
    $name = htmlspecialchars($data['name']);
    $nis = htmlspecialchars($data['nis']);
    $class = htmlspecialchars($data['class']); 
    $phoneNumber = htmlspecialchars($data['phone_number']);

    $query = "UPDATE {$this->table} SET name= ?, nis= ?, class= ?, phone_number= ? WHERE id= ?";
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param('ssssi', $name, $nis, $class, $phoneNumber, $id);
        $stmt->execute();

        if($stmt->affected_rows > 0) {
            header('Location: /students');
            exit();
    } else {
        echo "Gagal update data siswa.";
    }
}

//delet data siswa
Public function delete(int $id)
    {
        $query = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        if($stmt->affected_rows > 0) {
            header('Location: /students');
            exit();
    } else {
        echo "Gagal delet data siswa.";
    }
}
}
?>