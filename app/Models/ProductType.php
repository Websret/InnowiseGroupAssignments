<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductType extends Model
{
    use HasFactory;

    public function service(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'product_type_services', 'product_type_id', 'service_type_id', 'id', 'id');
    }
}
