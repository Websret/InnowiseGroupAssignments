<?php
namespace src;

class Task3{
    function main(int $number): int
    {
        if($number > 0){
            return ($number - 1) % 9 + 1;
        }else{
            return 0;
        }
    }
}

$classTask3 = new Task3();
echo $classTask3->main(5689);

?>