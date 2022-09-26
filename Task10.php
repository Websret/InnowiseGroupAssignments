<?php
namespace src;

class Task10{
    function main(int $input):array{
        $array = array($input);
        if ($input < 1)
            return [];
        while($input > 1){
            if($input % 2 == 0){
                $input /= 2;
            }else{
                $input = 3 * $input + 1;
            }
            $array[] = $input;
        }
        return $array;
    }
}

?>
