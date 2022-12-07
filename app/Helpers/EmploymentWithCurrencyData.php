<?php

namespace App\Helpers;

use App\Models\Currency;

class EmploymentWithCurrencyData
{
    public function getCurrency(string $file): bool|array
    {
        if (!empty($file)) {

            $xml = simplexml_load_file($file);

            return [
                'USD' => (float) $xml->filials->filial[0]->rates->value[0]['sale'],
                'EUR' => (float) $xml->filials->filial[0]->rates->value[1]['sale'],
                'RUB' => (float) $xml->filials->filial[0]->rates->value[2]['sale'],
            ];
        }
        return false;
    }

    public function reviseAndUpdateCurrency(array $data): void
    {
        foreach ($data as $currency => $value) {
            $curr = Currency::where('name', $currency)->get();
            if ($curr[0]['cost'] != $value) {
                Currency::where('name', $currency)->update(['cost' => $value]);
            }
        }
    }
}
