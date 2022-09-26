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

?>
