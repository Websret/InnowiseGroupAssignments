<?php

namespace Application\Lib;

class DataTransformer
{
    public static function associationData(array $array1, array $array2): array
    {
        return $array1 + [
                'services:' => $array2
            ];
    }

    public static function changeKeys(string $new_key, array &$array): array
    {
        $new_array = [];
        foreach ($array as $key => $value) {
            $new_array[$new_key . ++$key] = $value;
        }
        return $new_array;
    }

    public static function validateData(array $array): array
    {
        $dt = new DataTransformer();
        if (!empty($array)) {
            return $dt->validateProductType($array);
        }
        exit('Not correct data!');
    }

    private function validateProductType(array $array): array
    {
        foreach ($array as $key => $value) {
            if ($key == "product_type") {
                $value = match ($value) {
                    'TV-sets' => 1,
                    'Laptops' => 2,
                    'Mobile phones' => 3,
                    'Fridges' => 4,
                };
                $array[$key] = $value;
            }
        }
        return $array;
    }
}
