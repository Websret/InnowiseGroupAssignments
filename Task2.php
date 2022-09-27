<?php

namespace src;

class Task2
{
    public function main(string $date): int
    {
        $today = time();
        $arrayDate = explode('-', $date);
        $days = $arrayDate[0];
        $mounts = $arrayDate[1];
        $years = $arrayDate[2];

        if (checkdate((int) $mounts, (int) $days, (int) $years)) {
            $diff = (strtotime($date) - $today) / 86400;
        } else {
            throw new \InvalidArgumentException();
        }

        return ceil($diff);
    }
}
