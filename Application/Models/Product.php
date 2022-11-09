<?php

namespace Application\Models;

use Application\Core\Model;

abstract class Product extends Model
{
    private int $id;

    private string $name;

    private string $manufacture;

    private string $release_date;

    private int $cost;

    private int $product_type;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getManufacture(): string
    {
        return $this->manufacture;
    }

    public function setManufacture(string $manufacture): void
    {
        $this->manufacture = $manufacture;
    }

    public function getReleaseDate(): string
    {
        return $this->release_date;
    }

    public function setReleaseDate(string $release_date): void
    {
        $this->release_date = $release_date;
    }

    public function getCost(): int
    {
        return $this->cost;
    }

    public function setCost(int $cost): void
    {
        $this->cost = $cost;
    }

    public function getProductType(): int
    {
        return $this->product_type;
    }

    public function setProductType(int $product_type): void
    {
        $this->product_type = $product_type;
    }
}