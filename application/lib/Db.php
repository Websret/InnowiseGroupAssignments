<?php

namespace application\lib;

use PDO;

class Db
{
    public PDO $dbo;

    public function __construct()
    {
        $config = require 'application/config/db.php';
        $this->dbo = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['user'], $config['password']);
    }

    public function query(string $sql, array $params = []): bool|\PDOStatement
    {
        $statment = $this->dbo->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $statment->bindValue(':' . $key, $val);
            }
        }
        $statment->execute();
        return $statment;
    }

    public function row(string $sql, array $params = []): bool|array
    {
        $result = $this->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function column(string $sql, array $params = []): bool|array
    {
        $result = $this->query($sql);
        return $result->fetchColumn();
    }
}
