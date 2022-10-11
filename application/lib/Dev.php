<?php

use JetBrains\PhpStorm\NoReturn;

ini_set('display_errors', 1);
error_reporting(E_ALL);

#[NoReturn] function debug(string $str): void
{
    echo "<pre>var_dump($str);</pre>";
    exit;
}
