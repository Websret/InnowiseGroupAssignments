<?php

namespace Application\Core;

class Router
{
    private array $routes = [];

    public function __construct()
    {
        $routesPath = 'Application/Config/routes.php';
        $this->routes = include($routesPath);
    }

    public function getURI(): string|bool
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function errorPage(string $path, string $action): void
    {
        if (!method_exists($path, $action)) {
            View::errorCode(404);
        }
    }

    public function run(): void
    {
        $uri = $this->getURI();
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                $segments = explode('/', $internalRoute);
                $parameters = $segments;
                $controllerName = ucfirst(array_shift($segments)) . 'Controller';
                $actionName = array_shift($segments) . 'Action';

                $controllerFile = 'Application\Controllers\\' . $controllerName;
                $this->errorPage($controllerFile, $actionName);

                if (file_exists('Application/Controllers/' . $controllerName . '.php')) {
                    $controllerObject = new $controllerFile($parameters);
                    $controllerObject->$actionName();
                    break;
                }
            }
        }
    }
}
