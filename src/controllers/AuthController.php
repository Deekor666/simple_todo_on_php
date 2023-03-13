<?php

namespace App\controllers;


use App\App;
use App\Database;
use App\View;
use PDO;

class AuthController
{
    private Database $db;
    private View $view;

    public function __construct(View $view)
    {
        $this->db = App::$db;
        $this->view = $view;
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            $user = $this->getUserByUsername($username);
            if ($user) {
                $error = 'Такой пользователь уже зарегистрирован.';
                $this->view->render('/auth/login', ['errors' => [$error]]);
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $this->createUser($hashedPassword, $username);

                $_SESSION['user_username'] = $username;

                header("Location: /");
            }
        }

        $this->view->render('/auth/register');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            $user = $this->getUserByUsername($username);
            if ($user && password_verify($password, $user['password'])) {

                $_SESSION['user_username'] = $user['username'];

                header("Location: /");
                exit();
            } else {
                $error = 'Неверный username или пароль.';
                $this->view->render('/auth/login', ['errors' => [$error]]);
            }
            exit;
        }

        $this->view->render('/auth/login');
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_username']);

        $this->view->render('/auth/logout');
        exit;
    }

    public function getUserByUsername($username)
    {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->db->connect->prepare($query);
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($hashedPassword, $username)
    {
        $stmt = $this->db->connect->prepare("INSERT INTO users (password, username) VALUES (?, ?)");
        $stmt->execute([$hashedPassword, $username]);
        return $this->db->connect->lastInsertId();
    }

}