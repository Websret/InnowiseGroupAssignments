<?php

namespace application\models;

use application\core\Model;
use application\core\View;
use PDO;

class User extends Model
{
    public const GENDERS = [
        'male' => 'Male',
        'female' => 'Female',
    ];

    public const STATUSES = [
        'active' => 'Active',
        'inactive' => 'Inactive',
    ];

    public function addUser(array $params = []): void
    {
        $this->db->dbo
            ->prepare('INSERT INTO task.users (email, name, gender, status) VALUES (:email, :name, :gender, :status)')
            ->execute($params);
    }

    public function getUserParam(array $params = []): bool|array
    {
        $stmt = $this->db->dbo
            ->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute($params);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$result) {
            View::errorCode(404);
        }

        return $result;
    }

    public function updateUser(array $params = []): void
    {
        $this->db->dbo
            ->prepare('UPDATE users SET email = :email, name = :name, gender = :gender, status = :status WHERE email = :emailOld')
            ->execute($params);
    }

    public function deleteUser(array $params = []): void
    {
        $this->db->dbo->prepare('DELETE FROM users WHERE email = :email')->execute($params);
    }

    public function getUserEmail(array $params = []): bool|array
    {
        $stmt = $this->db->dbo
            ->prepare('SELECT count(*) as count FROM users WHERE email = :email');
        $stmt->execute($params);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$result) {
            View::errorCode(404);
        }
        return $result;
    }
}
