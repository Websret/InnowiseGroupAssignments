<?php

namespace Application\Core;

abstract class Controller
{
    public array $route;

    public mixed $model;

    public function __construct()
    {
        $this->route = $this->explodePath(get_class($this));
        $this->model = $this->loadModel(array_shift($this->route));
    }

    private function explodePath(string $path): array
    {
        $arrayPath = explode("\\", $path);
        $path = end($arrayPath);
        preg_match_all('/[A-Z]*?[^A-Z]*?/U', $path, $result);
        return $result[0];
    }

    public function loadModel(string $name): mixed
    {
        $path = 'Application\Models\\' . ucfirst($name);
        if (class_exists($path)) {
            return new $path;
        }
    }

    public function json($data): void
    {
        header("Content-type: application/json; charset=utf-8");
        echo json_encode($data);
    }

    public function jsonGet(): array
    {
        $data = file_get_contents('php://input');
        return json_decode($data, true);
    }
}
