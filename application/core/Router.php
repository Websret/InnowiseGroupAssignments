<?php

namespace application\core;

use application\core\View;

class Router{

    protected $routes = [];
    protected $params = [];

    public function __construct(){
        $arr = require 'application/config/routes.php';
        foreach ($arr as $key => $val){
            $this->add($key, $val);
        }
    }

    public function add($route, $params){
        $route = '#^'.$route.'$#';
        $this->routes[$route] = $params;
    }

    public function match(){
        $urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = trim($urlPath, '/');
        foreach ($this->routes as $route => $params){
            if (preg_match($route, $url, $matches)){
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function run(){

        if ($this->match()){
            $path = 'application\controllers\\'.ucfirst($this->params['controller']).'Controller';
//            $controller = 'application\controllers\\'.ucfirst($this->params['controller']).'Controller';
//            $controllerObj = new $controller();
//            $controllerObj->{$this->params['action']}();  Rasul's call code
//            call_user_func_array([UserController::class, 'views'], []); -?
            if (class_exists($path)){
                $action = $this->params['action'].'Action';
                if (method_exists($path, $action)){
                    $controller = new $path($this->params);
                    $controller->$action();
                }else{
                    //echo "Controller method not found: ".$action;
                    View::errorCode(404);
                }
            }else{
//                echo "Controller class not found: ".$path;
                View::errorCode(404);
            }
        }else{
//            echo 'Not found';
            View::errorCode(404);
        }
    }
}