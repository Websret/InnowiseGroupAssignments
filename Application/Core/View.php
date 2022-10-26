<?php

namespace Application\Core;

use Application\Lib\TwigImplementer;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    public string $path;

    private const PATH_VIEWS = 'Application/Views';

    public array $route;

    public string $layout = 'default';

    public function __construct(array $route)
    {
        $this->route = $route;
        $this->path = array_shift($route) . '/' . array_shift($route);
    }

    public function render($vars = []): void
    {
        $loader = new FilesystemLoader(self::PATH_VIEWS);
        $twig = new Environment($loader);
        $this->additionalFunctions($twig);

        echo $twig->render($this->path . '.twig', $vars);
    }

    private function additionalFunctions(&$twig): void
    {
        $services = require 'Application/Config/services.php';

        foreach ($services as $service) {
            $service = new $service;
            if ($service instanceof TwigImplementer) {
                $service->addFunctions($twig);
            }
        }
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
