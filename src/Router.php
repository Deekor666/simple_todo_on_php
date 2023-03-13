<?php

namespace App;

class Router
{
    private array $routes = [];
    private string $namespace = "App\\controllers\\";

    public function setRoutes()
    {
        $this->addRoute('GET', '/', 'TaskController@index');
        $this->addRoute('GET', '/\bsort=(\w+)\b/', 'TaskController@index', true);
        $this->addRoute('GET', '/tasks/create', 'TaskController@create');
        $this->addRoute('GET', '/^\/tasks\/edit\/(\d+)$/', 'TaskController@edit', true);
        $this->addRoute('GET', '/tasks', 'TaskController@index');
        $this->addRoute('GET', '/\/tasks\?page=(\d+)/', 'TaskController@index', true);
        $this->addRoute('POST', '/', 'TaskController@index');
        $this->addRoute('POST', '/tasks/create', 'TaskController@create');
        $this->addRoute('POST', '/^\/tasks\/update\/(\d+)$/', 'TaskController@update', true);

        $this->addRoute('GET', '/auth/register', 'AuthController@register');
        $this->addRoute('POST', '/auth/register', 'AuthController@register');

        $this->addRoute('GET', '/auth/login', 'AuthController@login');
        $this->addRoute('POST', '/auth/login', 'AuthController@login');

        $this->addRoute('GET', '/auth/logout', 'AuthController@logout');
    }

    public function addRoute($method, $url, $action, $regex = false)
    {
        $this->routes[] = [
            'method' => $method,
            'url' => $url,
            'action' => $action,
            'regex' => $regex,
        ];
    }

    public function dispatch()
    {
        $uri = $this->getUri();
        $method = $this->getRequestMethod();
        $routeFound = false;
        foreach ($this->routes as $route) {
            if (!$route['regex'] && ($method == $route['method'] && $uri == $route['url'])) {
                $routeFound = true;
                $controller = explode('@', $route['action'])[0];

                $className = $this->namespace . $controller;
                try {
                    $controller = App::$container->get($className);
                } catch (\Exception $e) {

                }
                $action = explode('@', $route['action'])[1];
                $controller->$action();
                return;
            }
            if ($route['regex'] && (preg_match($route['url'], $uri, $matches))) {
                $routeFound = true;
                $className = $this->namespace . explode('@', $route['action'])[0];
                $actionName = explode('@', $route['action'])[1];
                try {
                    $controller = App::$container->get($className);
                } catch (\Exception $e) {

                }
                if ($route['action'] === 'TaskController@edit' || $route['action'] === 'TaskController@update') {
                    $id = $matches[1];
                    $controller->$actionName(['id' => $id]);
                } else {
                    $controller->$actionName();
                }
                return;
            }
        }
        if (empty($routeFound)) {
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found";
        }
    }

    public function getUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}