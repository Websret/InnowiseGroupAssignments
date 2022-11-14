<?php

namespace Application\Models;

use Application\Core\Model;
use PDO;

class User extends Model
{
    public function addUser(array $params = []): void
    {
        try {
            $this->db->dbo->beginTransaction();
            $this->db->dbo
                ->prepare('INSERT INTO users (email, first_name, last_name, password, created_date)
                                        VALUES (:email, :firstName, :lastName, :password, :data)')
                ->execute($params);
            $this->db->dbo->commit();
        } catch (\Exception $e) {
            $this->db->dbo->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }

    public function getUsersEmail(array $params = []): array
    {
        $stmt = $this->db->dbo
            ->prepare('SELECT count(*) as total FROM users WHERE email = :email');
        $stmt->execute($params);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result[0];
    }

    public function getUsersData(array $params = []): array
    {
        $stmt = $this->db->dbo
            ->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addAttackers(array $params = []): void
    {
        $this->db->dbo
            ->prepare('INSERT INTO attackers (ip_address, email, startTime, numberAttack, endTime)
                            VALUES (:ip, :email, :startTime, :numberAttack, :endTime)')
            ->execute($params);
    }

    public function updateAttackers(array $params = []): void
    {
        $this->db->dbo
            ->prepare('UPDATE attackers SET startTime = :startTime, numberAttack = :numberAttack, endTime = :endTime WHERE ip_address = :ip')
            ->execute($params);
    }

    public function getAttackers(array $params = []): array
    {
        $stmt = $this->db->dbo
            ->prepare('SELECT * FROM attackers WHERE ip_address = :ip');
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteAttackers(array $params = []): void
    {
        $this->db->dbo
            ->prepare('DELETE FROM attackers WHERE ip_address = :ip')
            ->execute($params);
    }
}
