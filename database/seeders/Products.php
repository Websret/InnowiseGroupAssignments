<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Products extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            ['name' => 'IPhone 13', 'manufacture' => 'Apple', 'release_date' => '2021-11-01', 'cost' => '1100', 'description' => 'This is description', 'product_type' => '3'],
            ['name' => 'Samsung FR3', 'manufacture' => 'Samsung', 'release_date' => '2020-07-24', 'cost' => '1200', 'description' => 'This is description', 'product_type' => '1'],
            ['name' => 'L310', 'manufacture' => 'HP', 'release_date' => '2022-02-28', 'cost' => '900', 'description' => 'This is description', 'product_type' => '2'],
            ['name' => 'TV514', 'manufacture' => 'Samsung', 'release_date' => '2018-07-28', 'cost' => '900', 'description' => 'This is description', 'product_type' => '4'],
            ['name' => 'Nova 5T', 'manufacture' => 'Huawei', 'release_date' => '2020-02-24', 'cost' => '800', 'description' => 'This is description', 'product_type' => '3'],
        ]);
    }
}
