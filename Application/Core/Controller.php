<?php

namespace Application\Core;

abstract class Controller
{
    public array $route;
    public View $view;
    public mixed $model;

    public function __construct(array $route)
    {
        $this->route = $route;
        $this->view = new View($route);
        $this->model = $this->loadModel(array_shift($this->route));
    }

    public function loadModel(string $name): mixed
    {
        $path = 'Application\Models\\' . ucfirst($name);
        if (class_exists($path)) {
            return new $path;
        }
    }
}
