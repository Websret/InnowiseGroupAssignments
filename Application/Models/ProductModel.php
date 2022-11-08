<?php

namespace Application\Models;

use Application\Core\Model;

class ProductModel extends Model
{
    public function getAllProducts(): array
    {
        $stmt = $this->db->dbo
            ->prepare('SELECT id, name, manufactures, release_date, cost, type_name FROM product 
                            JOIN product_type pt on pt.type_id = product.product_type');
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getProduct(array $params = []): array
    {
        $stmt = $this->db->dbo
            ->prepare('SELECT id, name, manufactures, release_date, cost, type_name FROM product
                        JOIN product_type pt on pt.type_id = product.product_type WHERE id = :id');
        $stmt->execute($params);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($result)) {
            return [];
        }
        return $result[0];
    }

    public function getNameProduct(array $params = []): array
    {
        $stmt = $this->db->dbo
            ->prepare('SELECT id, name, manufactures, release_date, cost, type_name FROM product
                        JOIN product_type pt on pt.type_id = product.product_type WHERE name = :name');
        $stmt->execute($params);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($result)) {
            return [];
        }
        return $result[0];
    }

    public function addProduct(array $params = []): void
    {
        $this->db->dbo
            ->prepare('INSERT INTO product (name, manufactures, release_date, cost, product_type)
                            VALUES (:name, :manufactures, :release_date, :cost, :product_type)')
            ->execute($params);
    }
}
