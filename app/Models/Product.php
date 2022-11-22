<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'manufacture',
        'release_date',
        'cost',
        'description',
        'product_type',
    ];

    public function type(): HasOne
    {
        return $this->hasOne(ProductType::class, 'id', 'product_type');
    }
}
