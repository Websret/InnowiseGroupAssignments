<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeService extends Model
{
    use HasFactory;

    protected $table = 'product_type_services';

    protected $fillable = [
        'product_type_id',
        'service_type_id',
    ];
}
