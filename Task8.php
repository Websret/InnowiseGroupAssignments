<?php

namespace src;

class Task8
{
    public function main(string $js): void
    {
        $arr = json_decode($js, true);
        array_walk_recursive($arr, function ($key, $val) {
            echo $val, ':',$key,"\n";
        });
    }
}
