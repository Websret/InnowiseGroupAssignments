<?php

namespace src;

class Task9
{
    public function main(array $arr, int $number): array
    {
        $output = array();
        for ($i = 0; $i < count($arr) - 2; $i++) {
            if ($arr[$i] + $arr[$i+1] + $arr[$i+2] == $number) {
                $output[] = "{$arr[$i]}, {$arr[$i+1]}, {$arr[$i+2]}";
            }
        }
        return $output;
    }
}
