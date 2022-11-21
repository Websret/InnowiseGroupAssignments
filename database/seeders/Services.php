<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Services extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->insert([
            ['service_name' => 'Warranty', 'deadline' => '1 year', 'service_cost' => '100'],
            ['service_name' => 'Delivery', 'deadline' => '1 week', 'service_cost' => '10'],
            ['service_name' => 'Install', 'deadline' => '1 day', 'service_cost' => '10'],
            ['service_name' => 'Configure', 'deadline' => '1 day', 'service_cost' => '10'],
        ]);
    }
}
