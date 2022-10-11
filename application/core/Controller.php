<?php

namespace application\core;

abstract class Controller
{
    public array $route;
    public View $view;
    public mixed $model;

    public function __construct(array $route)
    {
        $this->route = $route;
        $this->view = new View($route);
        $this->model = $this->loadModel($route['controller']);
    }

    public function loadModel(string $name): mixed
    {
        $path = 'application\models\\' . ucfirst($name);
        if (class_exists($path)) {
            return new $path;
        }
    }

    protected function getQueryParams(): array
    {
        $rawParams = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
        parse_str($rawParams, $queryParams);
        return $queryParams;
    }
}
