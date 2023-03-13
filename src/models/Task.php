<?php

namespace App\models;

use App\App;
use PDO;

class Task
{
    private PDO $db;

    public function __construct()
    {
        $this->db = App::$db->connect;
    }

    public function getAllTasks($currentPage, $limit, $sort, $order)
    {
        $offset = ($currentPage - 1) * $limit;
        $sql = "SELECT * FROM tasks ORDER BY ${sort} ${order} LIMIT $offset, $limit";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalTasks()
    {
        $query = "SELECT COUNT(*) as total FROM tasks";
        $result = $this->db->query($query);
        $data = $result->fetch(PDO::FETCH_ASSOC);
        return $data['total'];
    }

    public function getTaskById($id)
    {
        $sql = "SELECT * FROM tasks WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createTask($text, $username): bool
    {
        $sql = "INSERT INTO tasks (text, username) VALUES (:text, :username)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':text', $text, PDO::PARAM_STR);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updateTask($id, $text, $username, $status): bool
    {
        $sql = "UPDATE tasks SET text = :text, status = :status, username = :username WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':text', $text);
        $stmt->bindValue(':status', $status, PDO::PARAM_INT);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}