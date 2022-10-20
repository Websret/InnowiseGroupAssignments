<?php

namespace Application\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    public string $path;

    public array $route;

    public string $layout = 'default';

    public function __construct(array $route)
    {
        $this->route = $route;
        $this->path = array_shift($route) . '/' . array_shift($route);
    }

    public function render($vars = []): void
    {
        $loader = new FilesystemLoader('Application/Views');
        $twig = new Environment($loader);
        echo $twig->render($this->path . '.twig', $vars);
    }

    public static function errorCode($code, $title = 'Page 404'): void
    {
        http_response_code($code);
        $path = 'Application/Views/errors/' . $code . '.php';
        if (file_exists($path)) {
            ob_start();
            require $path;
        }
        exit;
    }

    public function redirect($url): void
    {
        header('location: ' . $url);
        exit;
    }
}
