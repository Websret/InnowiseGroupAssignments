<?php

namespace src;

ini_set('precision', 300);

class Task5
{
    public function main(int $n): string
    {
        if ($n < 0) {
            throw new \InvalidArgumentException();
        }
        $first = '0';
        $second = '1';
        $numbers = '';
        while (strlen($numbers) < $n) {
            $numbers = '';
            $isMoreTen = false;
            $first = strrev($first);
            $second = strrev($second);
            for ($i = 0; $i < strlen($second); $i++) {
                $temp = @(int)$first[$i] + @(int)$second[$i];
                if ($isMoreTen) {
                    $temp++;
                }
                if ($temp >= 10) {
                    $isMoreTen = true;
                    $numbers .= $temp % 10;
                } else {
                    $isMoreTen = false;
                    $numbers .= $temp;
                }
            }
            if ($isMoreTen) {
                $numbers .= 1;
            }
            $numbers = strrev($numbers);
            $second = strrev($second);
            $first = $second;
            $second = $numbers;
        }

        return $numbers;
    }
}
