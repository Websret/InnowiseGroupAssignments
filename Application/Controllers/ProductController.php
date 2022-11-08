<?php

namespace Application\Controllers;

use Application\Core\Controller;
use Application\Lib\Helper\ProductTransformer;
use Application\Lib\Validation\Validator;
use Application\Models\ProductModel;
use Application\Models\ServiceModel;

class ProductController extends Controller
{
    private ProductModel $product;

    private ServiceModel $service;

    public function __construct()
    {
        $this->product = new ProductModel();
        $this->service = new ServiceModel();
    }

    public function index(): void
    {
        $this->json($this->product->getAllProducts());
    }

    public function show(int $id): void
    {
        $_POST['id'] = $id;
        $validator = new Validator([
            'id' => 'onlyInt|productExist:' . ProductModel::class . ',id|max:10000',
        ]);

        if (!$validator->validate()) {
            $this->json(ProductTransformer::getErrorMessage());
            exit();
        }

        $dataProduct = $this->product->getProduct(['id' => $id]);
        $dataServices = $this->service->getAllServices(['id' => $id]);
        $dataServices = ProductTransformer::changeData($dataServices);
        $data = ProductTransformer::associationData($dataProduct, $dataServices);

        $this->json($data);
    }

    public function getProductAndServiceAction(int $idProduct, int $idService): void
    {
        $_POST['idProduct'] = $idProduct;
        $_POST['idService'] = $idService;
        $validator = new Validator([
            'idProduct' => 'onlyInt|productExist:' . ProductModel::class . ',id|max:10000',
            'idService' => 'onlyInt|productServiceExist:' . ServiceModel::class . ',id|max:4',
        ]);

        if (!$validator->validate()) {
            $this->json(ProductTransformer::getErrorMessage());
            exit();
        }

        $dataProduct = $this->product->getProduct(['id' => $idProduct]);
        $dataService = $this->service->getProductService(['idProduct' => $idProduct, 'idService' => $idService]);
        $data = ProductTransformer::associationDataAndPrice($dataProduct, $dataService);
        $this->json($data);
    }

    public function postCreateProductAction(array $parameter = []): void
    {
        $data = $this->jsonGet();
        $correctData = ProductTransformer::changeKeyData($data);
        $_POST['name'] = $correctData['name'];
        $_POST['manufactures'] = $correctData['manufactures'];
        $_POST['release_date'] = $correctData['release_date'];
        $_POST['cost'] = $correctData['cost'];
        $_POST['product_type'] = $correctData['product_type'];
        $validator = new Validator([
            'name' => 'findProduct:' . ProductModel::class . ',name|maxLength:100|minLength:3',
            'manufactures' => 'onlyString|minLength:2|maxLength:100',
            'release_date' => 'minLength:9|maxLength:19',
            'cost' => 'onlyInt|min:10|max:100000',
            'product_type' => 'onlyInt|serviceExist:product_type|max:4',
        ]);

        if (!$validator->validate()) {
            $this->json(ProductTransformer::getErrorMessage());
            exit();
        }

        $this->product->addProduct($correctData);
    }
}
