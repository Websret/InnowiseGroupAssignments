<?php

namespace Application\Models;

use Application\Core\Model;

class ServiceModel extends Model
{
    public function table(): string
    {
        return 'products';
    }
}
