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
        $products = $this->product
            ->select('id', 'name', 'manufactures', 'release_date', 'cost', 'type_name')
            ->join('product_types', 'product_types.type_id', '=', 'products.product_type')
            ->orderBy('id', 'ASC')
            ->get();

        $this->json($products);
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

        $dataProduct = $this->product
            ->select('id', 'name', 'manufactures', 'release_date', 'cost', 'type_name')
            ->join('product_types', 'product_types.type_id', '=', 'products.product_type')
            ->where('id = :id')
            ->get(['id' => $id]);

        $dataServices = $this->service
            ->select('service_name', 'deadline', 'service_cost')
            ->join('product_types', 'product_types.type_id', '=', 'products.product_type')
            ->join('product_type_services', 'product_types.type_id', '=', 'product_type_services.product_type_id')
            ->join('services', 'product_type_services.service_type_id', '=', 'services.service_id')
            ->where('id = :id')
            ->get(['id' => $id]);

        $data = ProductTransformer::associationData($dataProduct[0], $dataServices);

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

        $dataProduct = $this->product
            ->select('id', 'name', 'manufactures', 'release_date', 'cost', 'type_name')
            ->join('product_types', 'product_types.type_id', '=', 'products.product_type')
            ->where('id = :id')
            ->get(['id' => $idProduct]);

        $dataService = $this->service
            ->select('service_name', 'deadline', 'service_cost')
            ->join('product_types', 'product_types.type_id', '=', 'products.product_type')
            ->join('product_type_services', 'product_types.type_id', '=', 'product_type_services.product_type_id')
            ->join('services', 'product_type_services.service_type_id', '=', 'services.service_id')
            ->where('service_id = :idService', 'id = :idProduct')
            ->get(['idService' => $idService, 'idProduct' => $idProduct]);
        $data = ProductTransformer::associationDataAndPrice($dataProduct[0], $dataService[0]);
        $this->json($data);
    }

    public function postCreateProductAction(): void
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

        $this->product
            ->insert('name', 'manufactures', 'release_date', 'cost', 'product_type')
            ->values(':name', ':manufactures', ':release_date', ':cost', ':product_type')
            ->add($correctData);
    }
}
