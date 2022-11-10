<?php

namespace Application\Controllers;

use Application\Core\Controller;
use Application\Helper\ProductTransformer;
use Application\Lib\Validation\Validator;
use Application\Models\Product;
use Application\Models\Service;
use Application\Repositories\ProductQueries;

class ProductController extends Controller
{
    private Product $product;

    private Service $service;

    private ProductQueries $queries;

    public function __construct()
    {
        $this->product = new Product();
        $this->service = new Service();
        $this->queries = new ProductQueries();
    }

    public function index(): void
    {
        $products = $this->queries->getAllProduct();

        $this->json($products);
    }

    public function show(int $id): void
    {
        $_POST['id'] = $id;
        $validator = new Validator([
            'id' => 'onlyInt|productExist:' . Product::class . ',id|max:10000',
        ]);

        if (!$validator->validate()) {
            $this->json(ProductTransformer::getErrorMessage());
            exit();
        }

        $dataProduct = $this->queries->getProduct($id);
        $dataServices = $this->queries->getAllServices($id);
        $data = ProductTransformer::associationData($dataProduct[0], $dataServices);

        $this->json($data);
    }

    public function getProductAndServiceAction(int $idProduct, int $idService): void
    {
        $_POST['idProduct'] = $idProduct;
        $_POST['idService'] = $idService;
        $validator = new Validator([
            'idProduct' => 'onlyInt|productExist:' . Product::class . ',id|max:10000',
            'idService' => 'onlyInt|productServiceExist:' . Service::class . ',id|max:4',
        ]);

        if (!$validator->validate()) {
            $this->json(ProductTransformer::getErrorMessage());
            exit();
        }

        $dataProduct = $this->queries->getProduct($idProduct);
        $dataService = $this->queries->getProductService($idProduct, $idService);
        $data = ProductTransformer::associationDataAndPrice($dataProduct[0], $dataService[0]);
        $this->json($data);
    }

    public function postCreateProductAction(): void
    {
        $correctData = $_POST;
        $validator = new Validator([
            'name' => 'findProduct:' . Product::class . ',name|maxLength:100|minLength:3',
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
