<?php

use Application\Core\Router;
use Application\Controllers\ProductController;

$router = new Router();

$router->get('/product', [new ProductController(), 'index']);
$router->get('/product/[0-9]+', [new ProductController(), 'show']);
$router->get('/product/[0-9]+/[0-9]+', [new ProductController(), 'getProductAndServiceAction']);
$router->post('/product/create', [new ProductController(), 'postCreateProductAction']);

$router->run();