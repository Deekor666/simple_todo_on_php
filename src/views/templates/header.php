<?php
use App\models\User;

$userIsAdmin = User::isAdmin();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">Task Manager</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <?php if ($userIsAdmin): ?>
                <li class="nav-item">
                    <span class="nav-link text-danger">ADMIN</span>
                </li>
            <?php endif; ?>

            <?php if (!empty($_SESSION['user_username']) && !$userIsAdmin): ?>
                <li class="nav-item">
                    <span class="nav-link text-danger"><?= $_SESSION['user_username'] ?></span>
                </li>
            <?php endif; ?>

            <li class="nav-item">
                <a class="nav-link" href="/tasks/create">Create Task</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/auth/login">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/auth/register">Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/auth/logout">Logout</a>
            </li>
        </ul>
    </div>
</nav>