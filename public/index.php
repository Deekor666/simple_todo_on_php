<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/App.php';
require_once __DIR__ . '/../src/View.php';

$container = new DI\Container();
try {
    $app = $container->get('App\App');
    $view = $container->get('App\View');

    $app->start();
} catch (Exception $e) {
    if (empty($view)) {
        var_dump($e->getMessage());exit;
    }
    $view->render('errors/404', [
        'errors' => [$e->getMessage()]
    ]);
}