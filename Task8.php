<?php
namespace src;

class Task8
{
    function main(string $js): void{
        $arr = json_decode($js,true);
        array_walk_recursive($arr,function($key,$val){
            echo $val, ":",$key,'
';
        });
    }
}

$classTask8 = new Task8();
$json = '{"Title": "The Cuckoos Calling",
"Author": "Robert Galbraith",
"Detail": {
"Publisher": "Little Brown"
}}';
$classTask8->main($json);

?>