<?php

namespace Application\Core;

trait Json
{
    public function printJson($data): void
    {
        echo json_encode($data);
    }
}
