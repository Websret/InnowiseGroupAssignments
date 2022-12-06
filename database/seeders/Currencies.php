<?php

namespace Database\Seeders;

use App\Helpers\GetXMLData;
use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Currencies extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $xmlData = new GetXMLData();
        $currencies = $xmlData->getCurrency('https://bankdabrabyt.by/export_courses.php');

        foreach ($currencies as $currency => $value) {
            Currency::insert([
                ['name' => $currency, 'cost' => $value]
            ]);
        }
    }
}
