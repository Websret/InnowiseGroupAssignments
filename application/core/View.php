<?php

namespace application\core;

use JetBrains\PhpStorm\NoReturn;

class View
{
    public string $path;
    public array $route;
    public string $layout = 'default';

    public function __construct(array $route)
    {
        $this->route = $route;
        $this->path = $route['controller'] . '/' . $route['action'];
    }

    public function render($title, $vars = []): void
    {
        extract($vars);
        $path = 'application/views/' . $this->path . '.php';
        if (file_exists($path)) {
            ob_start();
            require $path;
            $content = ob_get_clean();
            require 'application/views/layots/' . $this->layout . '.php';
        }
    }

    #[NoReturn] public static function errorCode($code, $title = 'Page 404'): void
    {
        http_response_code($code);
        $path = 'application/views/errors/' . $code . '.php';
        if (file_exists($path)) {
            ob_start();
            require $path;
        }
        exit;
    }

    #[NoReturn] public function redirect($url): void
    {
        header('location: ' . $url);
        exit;
    }
}
