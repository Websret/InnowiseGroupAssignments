<?php

namespace Application\Models;

class ServiceModel extends Service implements RequestValidation
{
    public function getAllServices(array $params = []): array
    {
        $this->setIdProduct($params['id']);
        $stmt = $this->db->dbo
            ->prepare('SELECT DISTINCT servace_name, deadline, service_cost
                        FROM product
                                 LEFT JOIN product_type pt on pt.type_id = product.product_type
                                 LEFT JOIN productType_services pts on pt.type_id = pts.productType_id
                                 LEFT JOIN services s on pts.serviceType_id = s.service_id
                        WHERE id = :id');
        $stmt->execute(['id' => $this->getIdProduct()]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getProductService(array $params = []): array
    {
        $this->setIdService($params['idService']);
        $this->setIdProduct($params['idProduct']);
        $stmt = $this->db->dbo
            ->prepare('SELECT DISTINCT servace_name, deadline, service_cost
                        FROM product
                                 LEFT JOIN product_type pt on pt.type_id = product.product_type
                                 LEFT JOIN productType_services pts on pt.type_id = pts.productType_id
                                 LEFT JOIN services s on pts.serviceType_id = s.service_id WHERE service_id = :idService
                        AND id = :idProduct');
        $stmt->execute(['idService' => $this->getIdService(), 'idProduct' => $this->getIdProduct()]);

        return $this->isEmptyArray($stmt->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function isEmptyArray(array $array): array
    {
        if (empty($array)) {
            return [];
        }
        return $array[0];
    }
}
