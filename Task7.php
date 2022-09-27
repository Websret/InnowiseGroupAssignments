<?php

namespace src;

class Task7
{
    public function main(array $arr, int $position): array
    {
        if ($position > count($arr) - 1) {
            throw new \InvalidArgumentException();
        }
        unset($arr[$position]);
        array_splice($arr, $position, 0);

        return $arr;
    }
}
