<?php

namespace Application\Repositories;

use Application\Models\Product;
use Application\Models\Service;

class ProductQueries
{
    private Service $service;

    private Product $product;

    public function __construct()
    {
        $this->service = new Service();
        $this->product = new Product();
    }

    public function getAllProduct(): array
    {
        return $this->product
            ->select('id', 'name', 'manufactures', 'release_date', 'cost', 'type_name')
            ->join('product_types', 'product_types.type_id', '=', 'products.product_type')
            ->orderBy('id', 'ASC')
            ->get();
    }

    public function getAllServices(int $id): array
    {
        return $this->service
            ->select('service_name', 'deadline', 'service_cost')
            ->join('product_types', 'product_types.type_id', '=', 'products.product_type')
            ->join('product_type_services', 'product_types.type_id', '=', 'product_type_services.product_type_id')
            ->join('services', 'product_type_services.service_type_id', '=', 'services.service_id')
            ->where('id = :id')
            ->get(['id' => $id]);
    }

    public function getProduct(int $id): array
    {
        return $this->product
            ->select('id', 'name', 'manufactures', 'release_date', 'cost', 'type_name')
            ->join('product_types', 'product_types.type_id', '=', 'products.product_type')
            ->where('id = :id')
            ->get(['id' => $id]);
    }

    public function getProductService(int $idProduct, int $idService): array
    {
        return $this->service
            ->select('service_name', 'deadline', 'service_cost')
            ->join('product_types', 'product_types.type_id', '=', 'products.product_type')
            ->join('product_type_services', 'product_types.type_id', '=', 'product_type_services.product_type_id')
            ->join('services', 'product_type_services.service_type_id', '=', 'services.service_id')
            ->where('service_id = :idService', 'id = :idProduct')
            ->get(['idService' => $idService, 'idProduct' => $idProduct]);
    }
}
