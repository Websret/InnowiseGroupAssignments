<?php

namespace Application\Models;

use Application\Core\Model;

class Main extends Model
{
    public function checkAuthorization(): array
    {
        return $this->db->checkAuthorization();
    }

    public function checkUsers(array $params = []): array
    {
        return $this->db->loginUser($params);
    }

    public function logoutAccount(): string
    {
        return $this->db->logoutAccount();
    }
}
