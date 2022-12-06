<?php

namespace App\Helpers;

class GetXMLData
{
    public function getCurrency(string $file): bool|array
    {
        if (!empty($file)) {

            $xml = simplexml_load_file($file);

            return [
                'usd' => (float) $xml->filials->filial[0]->rates->value[0]['sale'],
                'eur' => (float) $xml->filials->filial[0]->rates->value[1]['sale'],
                'rub' => (float) $xml->filials->filial[0]->rates->value[2]['sale'],
            ];
        }
        return false;
    }
}
