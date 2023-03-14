<?php

namespace App;

use PDO;
use PDOException;

class Database
{
    private bool $createdMigrate = false;
    public ?PDO $connect;

    public function __construct()
    {
        self::loadEnv();
        $host = getenv('DB_HOST');
        $dbname = getenv('DB_NAME');
        $user = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');

        if (!$this->createdMigrate) {
            $this->migrate();
        }

        $this->connect = null;
        try {
            $this->connect = new PDO("mysql:host=" . $host . ";dbname=" . $dbname, $user, $password);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "connection failed: " . $e->getMessage();
        }
    }

    public static function loadEnv()
    {
        $dotenv = fopen(PROJECT_DIR . '/.env', 'r');
        while ($line = fgets($dotenv)) {
            putenv(trim($line));
        }
        fclose($dotenv);
    }

    private function migrate()
    {
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

        try {
            $this->connect->query($sqlUsers);
            $this->connect->query($sqlTasks);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
        $this->createdMigrate = true;
    }
}