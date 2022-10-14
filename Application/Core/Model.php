<?php

namespace Application\Core;

use Application\Lib\RestApi;

abstract class Model
{
    public RestApi $link;

    public function __construct()
    {
        $this->link = new RestApi;
    }
}
