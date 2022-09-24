<?php
namespace src;

class Task9{
    function main(array $arr, int $number):array{
        $output = array();
        for($i = 0; $i < count($arr) - 2; $i++){
            if($arr[$i] + $arr[$i+1] + $arr[$i+2] == $number){
                $output[] = "{$arr[$i]}, {$arr[$i+1]}, {$arr[$i+2]}";
            }
        }
        return $output;
    }
}

$classTask9 = new Task9();
$arr = [2,7,7,1,8,2,7,8,7];
var_dump($classTask9->main($arr, 16));

?>