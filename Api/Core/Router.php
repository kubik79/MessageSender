<?php

declare(strict_types=1);

namespace Core;

use Core\Exception\ControllerNotFoundException;
use Core\Exception\RouteNotFoundException;

class Router
{
    private array $routes = [
        '/main' => [
            'GET' => 'Controller\\MainPageController',
        ],
        '/upload-clients' => [
            'POST' => 'Controller\\UploadClientsController',
        ],
    ];

    public function __construct()
    {
        $currentRoute = $this->getRoute();
        $method = $this->getMethod();

        if (isset($this->routes[$currentRoute][$method])) {
            $this->callController($this->routes[$currentRoute][$method]);
        } else {
            throw new RouteNotFoundException();
        }
    }

    public function getRoute(): string
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        return rtrim($uri, '/');
    }

    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    private function callController(string $controllerClass): void
    {
        if (class_exists($controllerClass)) {
            $controllerInstance = new $controllerClass();
            $controllerInstance();
        } else {
            throw new ControllerNotFoundException();
        }
    }
}
