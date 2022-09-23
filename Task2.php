<?php
namespace src;

class Task2{
    function main(string $date): string
    {
        $today = time();
        $diff = (strtotime($date) - $today);
        return (int)($diff/86400);
    }
}

$classDate = new Task2();
echo $classDate->main("17-05-2023");

?>
