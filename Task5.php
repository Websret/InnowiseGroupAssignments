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
        $array = [0, 1];
        do {
            $array[] = $array[count($array) - 1] + $array[count($array) - 2];
        } while (ceil(log10($array[count($array) - 1]) + 1) <= $n);

        return $array[count($array) - 1];
    }
}
