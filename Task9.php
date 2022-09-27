<?php

namespace src;

class Task9
{
    public function main(array $arr, int $number): array
    {
        if (count($arr) < 3 or $number < 1) {
            throw new \InvalidArgumentException();
        }
        foreach ($arr as $item) {
            if ($item < 0) {
                throw new \InvalidArgumentException();
            }
        }
        $output = [];
        for ($i = 0; $i < count($arr) - 2; $i++) {
            if ($arr[$i] + $arr[$i + 1] + $arr[$i + 2] == $number) {
                $output[] = "{$arr[$i]} + {$arr[$i + 1]} + {$arr[$i + 2]} = $number";
            }
        }

        return $output;
    }
}

$classTask9 = new Task9();
var_dump($classTask9->main([2, 7, 7, 1, 2, 2, 12, 2, 2], 16));
