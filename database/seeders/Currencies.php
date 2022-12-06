<?php

namespace Database\Seeders;

use App\Helpers\EmploymentWithCurrencyData;
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
        $xmlData = new EmploymentWithCurrencyData();
        $currencies = $xmlData->getCurrency(env('CURRENCY_XML_FILE'));

        foreach ($currencies as $currency => $value) {
            Currency::insert([
                ['name' => $currency, 'cost' => $value]
            ]);
        }
    }
}
