<?php

use Application\Core\Router;
use Application\Controllers\MainController;

$router = new Router();

$router->get('', [new MainController(), 'index']);

$router->run();
