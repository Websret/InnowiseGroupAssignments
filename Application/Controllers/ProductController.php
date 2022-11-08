<?php

namespace Application\Controllers;

use Application\Core\Controller;
use Application\Lib\DataTransformer;
use Application\Lib\Validator;
use Application\Models\ProductModel;

class ProductController extends Controller
{
    private ProductModel $product;

    public function __construct()
    {
        $this->product = new ProductModel();
    }

    public function index(): void
    {
        $this->json($this->product->getAllProducts());
    }

    public function show(int $id): void
    {
        $validator = new Validator([
            $id => 'onlyInt|checkExist:' . ProductModel::class .',id|max:10000',
        ]);

        if (!$validator->validate()) {
            DataTransformer::showErrorMessage();
//            exit('{"message":"' . $_SESSION['data']['errorMessage'][$id] . '"}');
        }
        $dataProduct = $this->product->getProduct(['id' => $id]);
        $dataServices = $this->product->getAllServices(['id' => $id]);
        $dataServices = DataTransformer::changeKeys('', $dataServices);
        $data = DataTransformer::associationData($dataProduct, $dataServices);

        $this->json($data);
    }

    public function getProductAndServiceAction(int $idProduct = null, int $idService = null): void
    {
        $dataProduct = $this->product->getProduct(['id' => $idProduct]);
        $dataService = $this->product->getProductService(['idProduct' => $idProduct, 'idService' => $idService]);
        $data = DataTransformer::associationData($dataProduct, $dataService);
        $this->json($data);
    }

    public function postCreateProductAction(array $parameter = []): void
    {
        $data = $this->jsonGet();
        $correctData = DataTransformer::validateData($data);
        $this->product->addProduct($correctData);
    }
}
