<?php

namespace Application\Models;

use Application\Core\Model;

class Main extends Model
{
    public function getUsers(): bool|array
    {
        return $this->link->getRequest();
    }
}
