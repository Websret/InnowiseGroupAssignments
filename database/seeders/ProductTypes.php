<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductType::insert([
            ['type_name' => 'TV-sets'],
            ['type_name' => 'Laptops'],
            ['type_name' => 'Mobile phones'],
            ['type_name' => 'Fridges'],
        ]);
    }
}
