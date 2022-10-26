<?php

namespace Application\Core;

use Application\Lib\Auth;

abstract class Model
{
    public Auth $db;

    public function __construct()
    {
        $this->db = new Auth;
    }
}
