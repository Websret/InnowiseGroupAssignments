<?php

namespace Application\Models;

class ProductModel extends Product implements RequestValidation
{
    public function getAllProducts(): array
    {
        $stmt = $this->db->dbo
            ->prepare('SELECT id, name, manufactures, release_date, cost, type_name FROM product 
                            JOIN product_type pt on pt.type_id = product.product_type ORDER BY id ASC');
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getProduct(array $params = []): array
    {
        $this->setId($params['id']);
        $stmt = $this->db->dbo
            ->prepare('SELECT id, name, manufactures, release_date, cost, type_name FROM product
                        JOIN product_type pt on pt.type_id = product.product_type WHERE id = :id');
        $stmt->execute(['id' => $this->getId()]);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $this->isEmptyArray($result);
    }

    public function getNameProduct(array $params = []): array
    {
        $this->setName($params['name']);
        $stmt = $this->db->dbo
            ->prepare('SELECT id, name, manufactures, release_date, cost, type_name FROM product
                        JOIN product_type pt on pt.type_id = product.product_type WHERE name = :name');
        $stmt->execute(['name' => $this->getName()]);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $this->isEmptyArray($result);
    }

    public function addProduct(array $params = []): void
    {
        $this->setName($params['name']);
        $this->setManufacture($params['manufactures']);
        $this->setReleaseDate($params['release_date']);
        $this->setCost($params['cost']);
        $this->setProductType($params['product_type']);
        $this->db->dbo
            ->prepare('INSERT INTO product (name, manufactures, release_date, cost, product_type)
                            VALUES (:name, :manufactures, :release_date, :cost, :product_type)')
            ->execute($this->toArray());
    }

    public function isEmptyArray(array $array): array
    {
        if (empty($array)) {
            return [];
        }
        return $array[0];
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'manufactures' => $this->getManufacture(),
            'release_date' => $this->getReleaseDate(),
            'cost' => $this->getCost(),
            'product_type' => $this->getProductType(),
        ];
    }
}
