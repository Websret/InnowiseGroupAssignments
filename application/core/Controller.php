<?php

namespace application\core;

use application\core\View;

abstract class Controller{

    public $route;
    public $view;
    public $model;

    public function __construct($route)
    {
        $this->route = $route;
        $this->view = new View($route);
        $this->model = $this->loadModel($route['controller']);
    }

    public function loadModel($name){
        $path = 'application\models\\'.ucfirst($name);
        if (class_exists($path)){
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
