<?php
namespace src;

class Task7{
    function main(array $arr, int $position):array{
        unset($arr[$position]);
        array_splice($arr, $position, 1);
        return $arr;
    }
}

$classTask7 = new Task7();
$arr=[1,2,3,4,5];
$n = 3;
var_dump($classTask7->main($arr, $n));

?>