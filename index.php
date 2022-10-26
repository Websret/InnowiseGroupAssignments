<?php

use Application\Core\Router;

include 'vendor/autoload.php';

session_start();

$router = new Router();
$router->run();
