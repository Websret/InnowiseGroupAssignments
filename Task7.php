<?php

namespace src;

class Task7
{
    public function main(array $arr, int $position): array
    {
        unset($arr[$position]);
        array_splice($arr, $position, 1);

        return $arr;
    }
}
