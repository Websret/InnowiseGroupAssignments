<?php

namespace Application\Repositories;

use Application\Models\Product;
use Application\Models\Service;

class ProductRepository
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
            ->select('products.id', 'name', 'manufactures', 'release_date', 'cost', 'type_name')
            ->join('product_types', 'product_types.id', '=', 'products.product_type')
            ->orderBy('id', 'ASC')
            ->get();
    }

    public function getAllServices(int $id): array
    {
        return $this->service
            ->select('service_name', 'deadline', 'service_cost')
            ->join('product_types', 'product_types.id', '=', 'products.product_type')
            ->join('product_type_services', 'product_types.id', '=', 'product_type_services.product_type_id')
            ->join('services', 'product_type_services.service_type_id', '=', 'services.id')
            ->where('products.id = :id')
            ->get(['id' => $id]);
    }

    public function getProduct(int $id): array
    {
        return $this->product
            ->select('products.id', 'name', 'manufactures', 'release_date', 'cost', 'type_name')
            ->join('product_types', 'product_types.id', '=', 'products.product_type')
            ->where('products.id = :id')
            ->get(['id' => $id]);
    }

    public function getProductService(int $idProduct, int $idService): array
    {
        return $this->service
            ->select('service_name', 'deadline', 'service_cost')
            ->join('product_types', 'product_types.id', '=', 'products.product_type')
            ->join('product_type_services', 'product_types.id', '=', 'product_type_services.product_type_id')
            ->join('services', 'product_type_services.service_type_id', '=', 'services.id')
            ->where('services.id = :idService', 'products.id = :idProduct')
            ->get(['idService' => $idService, 'idProduct' => $idProduct]);
    }
}
