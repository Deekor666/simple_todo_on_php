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

    public function isAuthenticated(): bool
    {
        // Проверка наличия сессии пользователя
        return isset($_SESSION['user_username']);
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
}