<?php

namespace App;

use DI\Container;
use Exception;

class App
{
    public static Database $db;
    public Router $router;
    public static Container $container;

    public function __construct(Database $db, Router $router, Container $container)
    {
        session_start();
        self::$db = $db;
        self::$container = $container;
        $this->router = $router;
    }

    /**
     * @throws Exception
     */
    public function start()
    {
        $this->router->setRoutes();
        try {
            $this->router->dispatch();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function getBaseUrl(): string
    {
        $protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
        $domain = $_SERVER['SERVER_NAME'];
        return "${protocol}://${domain}:6789";
    }
}