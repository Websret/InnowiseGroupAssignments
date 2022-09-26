<?php
namespace src;

class Task6{
    function main(int $year, int $lastYear, int $month, int $lastMonth, string $day = 'Monday'):int{
        $count = 0;
        $startTime = strtotime("01.$month.$year");
        $endTime = strtotime("31.$lastMonth.$lastYear");
        while($startTime <= $endTime){
            if((date('w', $startTime) == 1) and date('d', $startTime) == 1){
                $count++;
            }
            $startTime+=86400;
        }
        return $count;
    }
}

?>
