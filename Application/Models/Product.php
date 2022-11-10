<?php

namespace Application\Models;

use Application\Core\Model;

class Product extends Model
{
    public function table(): string
    {
        return 'products';
    }
}
