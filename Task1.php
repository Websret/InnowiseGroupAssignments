<?php
namespace src;

use http\Exception\InvalidArgumentException;

class Task1{
    function main(int $inputNumbers): void
    {
        try {
            $output = $inputNumbers > 30 ? "More than 30" : ($inputNumbers > 20 ? "More than 20" : ($inputNumbers > 10 ?
                "More than 10" : "Equal or less than 10"));
            echo $output;
        }catch (\InvalidArgumentException $e){
            echo "Main function accepts only integers.";
        }
    }
}

$inputNumbers = new Task1();
$mainNumbers = "main";
echo $inputNumbers->$mainNumbers(11);

?>
