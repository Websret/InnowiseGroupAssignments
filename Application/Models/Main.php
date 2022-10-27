<?php

namespace Application\Models;

use Application\Core\Model;
use PDO;

class Main extends Model
{
    public function addUser(array $params = []): void
    {
        $this->db->dbo
            ->prepare('INSERT INTO users (email, first_name, last_name, password, created_date)
                                        VALUES (:email, :firstName, :lastName, :password, :data)')
            ->execute($params);
    }

    public function getUsersEmail(array $params = []): array
    {
        $stmt = $this->db->dbo
            ->prepare('SELECT count(*) as total FROM users WHERE email = :email');
        $stmt->execute($params);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result[0];
    }
}
