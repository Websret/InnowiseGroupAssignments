<?php

namespace Application\Controllers;

use Application\Core\Controller;
use Application\Lib\DataTransformer;

class ProductController extends Controller
{
    public function getProductAction(int $id = null): void
    {
        if (empty($id)) {
            $data = $this->model->getAllProducts();
        } else {
            $dataProduct = $this->model->getProduct(['id' => $id]);
            $dataServices = $this->model->getAllServices(['id' => $id]);
            $dataServices = DataTransformer::changeKeys('', $dataServices);
            $data = DataTransformer::associationData($dataProduct, $dataServices);
        }

        $this->json($data);
    }

    public function getProductAndServiceAction(int $idProduct = null, int $idService = null): void
    {
        $dataProduct = $this->model->getProduct(['id' => $idProduct]);
        $dataService = $this->model->getProductService(['idProduct' => $idProduct, 'idService' => $idService]);
        $data = DataTransformer::associationData($dataProduct, $dataService);
        $this->json($data);
    }

    public function postCreateProductAction(array $parameter = []): void
    {
        $data = $this->jsonGet();
        $correctData = DataTransformer::validateData($data);
        $this->model->addProduct($correctData);
    }
}
