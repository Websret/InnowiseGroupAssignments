<?php

namespace src;

class Task6
{
    public function main(int $year, int $lastYear, int $month, int $lastMonth, string $day = 'Monday'): int
    {
        if ($year < 1 or $lastYear < 1 or $month < 1 or $lastMonth < 1) {
            throw new \InvalidArgumentException();
        }
        $count = 0;
        $startTime = strtotime("01.$month.$year");
        $lastDayMonth = cal_days_in_month(CAL_GREGORIAN, $lastMonth, $lastYear);
        $endTime = strtotime("$lastDayMonth.$lastMonth.$lastYear");
        while ($startTime <= $endTime) {
            if ((date('w', $startTime) == 1) and date('d', $startTime) == 1) {
                $count++;
            }
            $startTime += 86400;
        }

        return $count;
    }
}
