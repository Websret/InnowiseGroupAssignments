<?php

namespace Application\Models;

use Application\Core\Model;

class ServiceModel extends Model
{
    public function getAllServices(array $params = []): array
    {
        $stmt = $this->db->dbo
            ->prepare('SELECT DISTINCT servace_name, deadline, service_cost
                        FROM product
                                 LEFT JOIN product_type pt on pt.type_id = product.product_type
                                 LEFT JOIN productType_services pts on pt.type_id = pts.productType_id
                                 LEFT JOIN services s on pts.serviceType_id = s.service_id
                        WHERE id = :id');
        $stmt->execute($params);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getProductService(array $params = []): array
    {
        $stmt = $this->db->dbo
            ->prepare('SELECT DISTINCT servace_name, deadline, service_cost
                        FROM product
                                 LEFT JOIN product_type pt on pt.type_id = product.product_type
                                 LEFT JOIN productType_services pts on pt.type_id = pts.productType_id
                                 LEFT JOIN services s on pts.serviceType_id = s.service_id WHERE service_id = :idService
                        AND id = :idProduct');
        $stmt->execute($params);

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result[0];
    }
}
