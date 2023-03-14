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
        $host = getenv('DB_HOST');
        $dbname = getenv('DB_NAME');
        $user = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');

        $this->connect = null;
        try {
            $this->connect = new PDO("mysql:host=" . $host . ";dbname=" . $dbname, $user, $password);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "connection failed: " . $e->getMessage();
        }
    }

    private static function loadEnv()
    {
        $dotenv = fopen(__DIR__ . '/../.env', 'r');
        var_dump(__DIR__ . '/../.env');
        while ($line = fgets($dotenv)) {
            putenv(trim($line));
        }
        fclose($dotenv);
    }
}