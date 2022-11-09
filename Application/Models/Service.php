<?php

namespace Application\Models;

use Application\Core\Model;

abstract class Service extends Model
{
    private int $idProduct;

    private int $idService;

    public function getIdProduct(): int
    {
        return $this->idProduct;
    }

    public function setIdProduct(int $id): void
    {
        $this->idProduct = $id;
    }

    public function getIdService(): int
    {
        return $this->idService;
    }

    public function setIdService(int $id): void
    {
        $this->idService = $id;
    }
}