<?php
namespace src;

class Task1{
    function main(int $inputNumbers): string
    {
        return $inputNumbers > 30 ? "More than 30" : ($inputNumbers > 20 ? "More than 20" : ($inputNumbers > 10 ?
            "More than 10" : "Equal or less than 10"));
    }
}

?>
