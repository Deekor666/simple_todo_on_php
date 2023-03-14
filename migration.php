<?php

use App\Database;

require_once __DIR__ . '/src/Database.php';

Database::loadEnv();
$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $username, $password, $options);

$sqlTasks = "create table myapp.tasks
(
    id       int auto_increment
        primary key,
    text     text                 null,
    username mediumtext           null,
    status   tinyint(1) default 0 null
);";

$sqlUsers = "create table myapp.users
(
    id       int auto_increment
        primary key,
    password mediumtext null,
    username mediumtext null
);";

// Выполняем SQL запрос
$pdo->query($sqlUsers);
$pdo->query($sqlTasks);