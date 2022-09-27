<?php

namespace src;

class Task8
{
    public function main(string $js): void
    {
        if (!$this->isJson($js)) {
            throw new \InvalidArgumentException();
        }
        $arr = json_decode($js, true);

        array_walk_recursive($arr, function ($key, $val) {
            echo "\n",$val, ':',$key;
        });
    }

    public function isJson($string): bool
    {
        return is_string($string) && is_array(json_decode($string, true)) ? true : false;
    }
}
