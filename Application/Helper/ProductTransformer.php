<?php

namespace Application\Helper;

class ProductTransformer
{
    public static function associationData(array $array1, array $array2): array
    {
        return $array1 + ['services' => $array2];
    }

    public static function associationDataAndPrice(array $array1, array $array2): array
    {
        $newArray = $array1 + ['service' => $array2];
        $totalPrice = $array1['cost'] + $array2['service_cost'];
        $newArray['total_cost'] = $totalPrice;

        return $newArray;
    }

    public static function changeKeyData(array $array): array
    {
        $pt = new ProductTransformer();
        if (!empty($array)) {
            return $pt->validateProductType($array);
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
                    default => 0,
                };
                $array[$key] = $value;
            }
        }
        return $array;
    }

    public static function getErrorMessage(): array
    {
        $pt = new ProductTransformer();
        return ($pt->createErrorArray());
    }

    private function createErrorArray(): array
    {
        $newArray = [];
        foreach ($_SESSION['data']['errorMessage'] as $key => $value) {
            $newArray['message'] = $value;
        }
        return $newArray;
    }
}
