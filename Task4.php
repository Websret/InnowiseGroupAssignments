<?php
namespace src;

class Task4{
    function main(string $input): array|string{
        $chars = array('-', '_');
        $output = ucwords(str_replace($chars, ' ', $input));
        return str_replace(' ', '', $output);
    }
}

?>
