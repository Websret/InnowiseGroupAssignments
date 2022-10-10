<?php

namespace application\models;

use application\core\Model;

class Main extends Model
{
    public function getUsers()
    {
        return $this->db->row('SELECT * FROM users');
    }
}
