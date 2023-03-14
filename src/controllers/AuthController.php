<?php

namespace App\controllers;


use App\App;
use App\Database;
use App\models\User;
use App\View;
use PDO;

class AuthController
{
    private View $view;
    private User $user;

    public function __construct(View $view, User $user)
    {
        $this->view = $view;
        $this->user = $user;
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            $user = $this->user->getUserByUsername($username);
            if ($user) {
                $error = 'Такой пользователь уже зарегистрирован.';
                $this->view->render('/auth/login', ['errors' => [$error]]);
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $this->user->createUser($hashedPassword, $username);

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

            $user = $this->user->getUserByUsername($username);
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
}