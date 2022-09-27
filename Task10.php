<?php

namespace src;

class Task10
{
    public function main(int $input): array
    {
        $array = [$input];
        if (!is_int($input) or $input < 1) {
            throw new \InvalidArgumentException();
        }
        while ($input > 1) {
            if ($input % 2 == 0) {
                $input /= 2;
            } else {
                $input = 3 * $input + 1;
            }
            $array[] = $input;
        }

        return $array;
    }
}
