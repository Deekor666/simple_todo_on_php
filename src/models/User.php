<?php

namespace App\models;

use App\App;
use PDO;

class User
{
    public int $id;
    private ?PDO $db;

    public function __construct()
    {
        $this->db = App::$db->connect;
    }

    public function login($username, $password): bool
    {
        // Поиск пользователя с заданным именем пользователя
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Проверка пароля
        if ($user && password_verify($password, $user['password'])) {
            // Установка сессии пользователя
            $_SESSION['user_username'] = $user['username'];
            return true;
        } else {
            return false;
        }
    }

    public static function isAdmin(): bool
    {
        if (!isset($_SESSION['user_username'])) {
            return false;
        }
        if ($_SESSION['user_username'] !== 'admin') {
            return false;
        }
        return true;
    }

    public function getUserByUsername($username)
    {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($hashedPassword, $username)
    {
        $stmt = $this->db->prepare("INSERT INTO users (password, username) VALUES (?, ?)");
        $stmt->execute([$hashedPassword, $username]);
        return $this->db->lastInsertId();
    }

}