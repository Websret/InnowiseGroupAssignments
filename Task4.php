<?php

namespace src;

class Task4
{
    public function main(string $input): array|string
    {
        $chars = ['-', '_'];
        $output = ucwords(str_replace($chars, ' ', $input));

        return str_replace(' ', '', $output);
    }
}
