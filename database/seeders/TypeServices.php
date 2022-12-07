<?php

namespace Database\Seeders;

use App\Models\ProductType;
use App\Models\Service;
use App\Models\TypeService;
use Illuminate\Database\Seeder;

class TypeServices extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productTypeIds = ProductType::select('id')->get()->pluck('id');
        $serviceTypeIds = Service::select('id')->get()->pluck('id');
        for ($i = 0; $i < 10; $i++) {
            TypeService::insert([
                ['product_type_id' => fake()->randomElement($productTypeIds), 'service_type_id' => fake()->randomElement($serviceTypeIds)],
            ]);
        }
    }
}
