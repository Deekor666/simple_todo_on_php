<?php

use App\Database;

require_once __DIR__ . '/src/Database.php';


$database = new Database();

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
$database->connect->query($sqlUsers);
$database->connect->query($sqlTasks);