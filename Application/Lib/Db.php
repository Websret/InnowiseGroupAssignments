<?php

namespace Application\Lib;

use PDO;

class Db
{
    public PDO $dbo;

    public function __construct()
    {
        $this->dbo = new PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
    }
}
