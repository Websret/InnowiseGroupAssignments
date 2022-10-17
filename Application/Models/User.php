<?php

namespace Application\Models;

use Application\Core\Model;
use Application\Core\View;
use Application\Enums\RequestMethods;

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

    public function getUsers(): bool|array
    {
        return $this->link->request(RequestMethods::GET);
    }

    public function addUser(array $params = []): void
    {
        $this->link->request(RequestMethods::POST, $params);
    }

    public function getUserParam(array $params = []): array
    {
        $result = $this->link->request(RequestMethods::GET, $params);

        if (!$result) {
            View::errorCode(404);
        }

        return $result;
    }

    public function updateUser(array $params = []): void
    {
        $this->link->request(RequestMethods::PATCH, $params);
    }

    public function deleteUser(array $params = []): void
    {
        $this->link->request(RequestMethods::DELETE ,$params);
    }
}
