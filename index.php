<?php

use Application\Core\Router;
use Application\Lib\DotEnv;

include 'vendor/autoload.php';

(new DotEnv(__DIR__ . '/.env'))->load();

session_start();

$router = new Router();
$router->run();
