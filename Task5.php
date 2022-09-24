<?php
namespace src;

class Task5{
    function main (int $n): string{
        $array = array(0,1);
        for ($i = 2; $i <= $n; $i++){
            $array[$i] = $array[$i-1] + $array[$i-2];
        }
        return (string) $array[$n];
    }
}

$classTask5 = new Task5();
echo $classTask5->main(183);

?>