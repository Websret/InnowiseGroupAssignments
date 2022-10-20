<?php

namespace Application\Models;

use Application\Core\Model;

class Main extends Model
{
    public function getUploads(): array
    {
        return $this->link->getFiles();
    }
}