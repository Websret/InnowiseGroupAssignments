<?php

namespace application\models;

use application\core\Model;

class User extends Model
{
    public function addUser($params = [])
    {
        $this->db->column("INSERT INTO task.users (email, name, gender, status) VALUES ('".$params['email']."', '".$params['name']."', '".$params['gender']."', '".$params['status']."')");
    }

    public function getUserParam($params = [])
    {
        return $this->db->row("SELECT * FROM users WHERE email = '".$params['email']."'");
    }

    public function updateUser($params = [])
    {
        $this->db->column("UPDATE users SET email = '".$params['email']."', name = '".$params['name']."', gender = '".$params['gender']."', status = '".$params['status']."' WHERE email = '".$params['emailOld']."'");
    }

    public function deleteUser($params = [])
    {
        $this->db->column("DELETE FROM users WHERE email='".$params['email']."'");
    }

    public function getUserEmail($params = [])
    {
        return $this->db->query("SELECT count(*) as count FROM users WHERE email = '".$params["email"]."'");
    }
}
