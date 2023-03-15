<?php

namespace App;

use PDO;
use PDOException;

class Database
{
    public ?PDO $connect;

    public function __construct()
    {
        self::loadEnv();
        $host = getenv('MYSQL_HOST');
        $dbname = getenv('MYSQL_DATABASE');
        $user = getenv('MYSQL_USER');
        $password = getenv('MYSQL_PASSWORD');

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
}