<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeServices extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_type_services')->insert([
            ['product_type_id' => 1, 'service_type_id' => 1],
            ['product_type_id' => 1, 'service_type_id' => 2],
            ['product_type_id' => 1, 'service_type_id' => 3],
            ['product_type_id' => 1, 'service_type_id' => 4],
            ['product_type_id' => 2, 'service_type_id' => 1],
            ['product_type_id' => 2, 'service_type_id' => 2],
            ['product_type_id' => 3, 'service_type_id' => 1],
            ['product_type_id' => 3, 'service_type_id' => 2],
            ['product_type_id' => 4, 'service_type_id' => 1],
            ['product_type_id' => 4, 'service_type_id' => 2],
            ['product_type_id' => 4, 'service_type_id' => 3],
        ]);
    }
}
