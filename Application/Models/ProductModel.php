<?php

namespace Application\Models;

use Application\Core\Model;

class ProductModel extends Model
{
    public function table(): string
    {
        return 'products';
    }
}
