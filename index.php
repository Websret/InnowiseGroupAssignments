<?php

use Application\Lib\DotEnv;

include 'vendor/autoload.php';

(new DotEnv(__DIR__ . '/.env'))->load();

session_start();

require_once 'Application/Config/routes.php';
