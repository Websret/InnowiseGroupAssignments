<?php

namespace Application\Models;

use Application\Core\Model;
use Application\Lib\DataTransformer;

class Product extends Model
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

        return $result[0];
    }

    public function getProductService(array $params = []): array
    {
        $stmt = $this->db->dbo
            ->prepare('SELECT DISTINCT servace_name, deadline, service_cost
                        FROM product
                                 LEFT JOIN product_type pt on pt.type_id = product.product_type
                                 LEFT JOIN product_t_s pts on pt.type_id = pts.type_tss_id
                                 LEFT JOIN services s on pts.service_tss_id = s.service_id WHERE service_id = :idService
                        AND id = :idProduct');
        $stmt->execute($params);

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result[0];
    }

    public function getAllServices(array $params = []): array
    {
        $stmt = $this->db->dbo
            ->prepare('SELECT DISTINCT servace_name, deadline, service_cost
                        FROM product
                                 LEFT JOIN product_type pt on pt.type_id = product.product_type
                                 LEFT JOIN product_t_s pts on pt.type_id = pts.type_tss_id
                                 LEFT JOIN services s on pts.service_tss_id = s.service_id
                        WHERE id = :id');
        $stmt->execute($params);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addProduct(array $params = []): void
    {
        $this->db->dbo
            ->prepare('INSERT INTO product (name, manufactures, release_date, cost, product_type)
                            VALUES (:name, :manufactures, :release_date, :cost, :product_type)')
            ->execute($params);
    }
}
