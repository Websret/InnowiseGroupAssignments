<?php

namespace Application\Controllers;

use Application\Core\Controller;
use Application\Helper\ProductTransformer;
use Application\Lib\Validation\Validator;
use Application\Models\Product;
use Application\Models\Service;
use Application\Repositories\ProductRepository;

class ProductController extends Controller
{
    private Product $product;

    private ProductRepository $productRepository;

    public function __construct()
    {
        $this->product = new Product();
        $this->productRepository = new ProductRepository();
    }

    public function index(): void
    {
        $products = $this->productRepository->getAllProduct();
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

        $dataProduct = $this->productRepository->getProduct($id);
        $dataServices = $this->productRepository->getAllServices($id);
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

        $dataProduct = $this->productRepository->getProduct($idProduct);
        $dataService = $this->productRepository->getProductService($idProduct, $idService);
        $data = ProductTransformer::associationDataAndPrice($dataProduct[0], $dataService[0]);
        $this->json($data);
    }

    public function postCreateProductAction(): void
    {
        $_POST = ProductTransformer::changeKeyData($_POST);
        $validator = new Validator([
            'name' => 'findProduct:' . Product::class . ',name|maxLength:100|minLength:3|required',
            'manufactures' => 'onlyString|minLength:2|maxLength:100|required',
            'release_date' => 'minLength:9|maxLength:19|required',
            'cost' => 'onlyInt|min:10|max:100000|required',
            'product_type' => 'onlyInt|serviceExist:product_type|max:4|required',
        ]);

        if (!$validator->validate()) {
            $this->json(ProductTransformer::getErrorMessage());
            exit();
        }

        $this->product
            ->insert('name', 'manufactures', 'release_date', 'cost', 'product_type')
            ->values(':name', ':manufactures', ':release_date', ':cost', ':product_type')
            ->add($_POST);
    }
}
