<?php

namespace Application\Core;

use Application\Lib\FileSystem;

abstract class Model
{
    public FileSystem $link;

    public function __construct()
    {
        $this->link = new FileSystem;
    }
}
