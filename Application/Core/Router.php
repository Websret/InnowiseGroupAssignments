<?php

namespace Application\Core;

class Router
{
    private array $routes = [];

    private const ROUTES_PATH = 'Application/Config/routes.php';

    public function __construct()
    {
        $this->routes = include(self::ROUTES_PATH);
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

    public function checkPages(string $internalRoute): array
    {
        $uri = $internalRoute == "main/index" ? $internalRoute : $this->getURI();
        return explode('/', $uri);
    }

    public function getParams(array $segments, object $controllerObject, string $actionName): void
    {
        empty($segments) ? $controllerObject->$actionName() : $controllerObject->$actionName($segments);
    }

    public function run(): void
    {
        $uri = $this->getURI();
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                $segments = $this->checkPages($internalRoute);
                $parameters = $segments;
                $controllerName = ucfirst(array_shift($segments)) . 'Controller';
                $actionName = array_shift($segments) . 'Action';

                $controllerFile = 'Application\Controllers\\' . $controllerName;
                $this->errorPage($controllerFile, $actionName);

                if (file_exists('Application/Controllers/' . $controllerName . '.php')) {
                    $controllerObject = new $controllerFile($parameters);
                    $this->getParams($segments, $controllerObject, $actionName);
                    break;
                }
            }
        }
    }
}
