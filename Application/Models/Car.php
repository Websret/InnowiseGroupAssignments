<?php

namespace Application\Models;

use Application\Core\Model;

class Car extends Model
{
    public function table(): string
    {
        return 'showroom_cars';
    }
}
