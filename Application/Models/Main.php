<?php

namespace Application\Models;

use Application\Core\Model;
use Application\Enums\RequestMethods;

class Main extends Model
{
    public function getUsers(): bool|array
    {
        return $this->link->request(RequestMethods::GET);
    }
}
