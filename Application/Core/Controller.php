<?php

namespace Application\Core;

abstract class Controller
{
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
