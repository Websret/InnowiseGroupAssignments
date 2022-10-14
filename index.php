<?php

use Application\Core\Router;
use Application\Lib\DotEnv;

include 'vendor/autoload.php';

spl_autoload_register(function ($class) {
    $path = str_replace('\\', '/', $class . '.php');
    if (file_exists($path)) {
        require $path;
    }
});

(new DotEnv(__DIR__ . '/.env'))->load();

session_start();

$router = new Router();
$router->run();
