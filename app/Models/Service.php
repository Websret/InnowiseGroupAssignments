<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_name',
        'deadline',
        'service_cost',
    ];

    public function productType(): BelongsToMany
    {
        return $this->belongsToMany(ProductType::class, 'product_type_services', 'service_type_id', 'product_type_id', 'id', 'id');
    }
}
