<?php

namespace src;

class Task3
{
    public function main(int $number): int
    {
        if (!is_int($number) or $number < 9) {
            throw new \InvalidArgumentException();
        } else {
            return ($number - 1) % 9 + 1;
        }
    }
}
