<?php

namespace application\lib;

use PDO;

class Db {

    protected PDO $db;

    public function __construct()
    {
        $config = require 'application/config/db.php';
        $this->db = new PDO('mysql:host='.$config['host'].';dbname='.$config['dbname'].'', $config['user'], $config['password']);
    }

    public function query($sql, $params = [])
    {
        $statment = $this->db->prepare($sql);
        if (empty($params)) {
            foreach ($params as $key => $val){
                $statment->bindValue(':'.$key, $val);
            }
        }
        $statment->execute();
        return $statment;
    }

    public function row($sql, $params = [])
    {
        $result = $this->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function column($sql, $params = []){
        $result = $this->query($sql);
        return $result->fetchColumn();
    }
}
