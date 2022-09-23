<?php
namespace src;

class Task4{
    function main(string $input): array|string{
        $chars = array('-', '_');
        $output = ucwords(str_replace($chars, ' ', $input));
        return str_replace(' ', '', $output);
    }
}

$classTask4 = new Task4();
echo $classTask4->main("The quick-brown_fox jumps over the_lazy-dog");

?>