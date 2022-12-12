<?php

namespace Application\Controllers;

use Application\Core\Controller;
use Application\Helper\ProductTransformer;
use Application\Lib\Validation\Validator;
use Application\Models\Product;
use Application\Models\Service;
use Application\Repositories\ProductRepository;


/**
 * @OA\Info(
 *     title="API documentation",
 *     version="0.1"
 * )
 */
class ProductController extends Controller
{
    private Product $product;

    private ProductRepository $productRepository;

    public function __construct()
    {
        $this->product = new Product();
        $this->productRepository = new ProductRepository();
    }

    /**
     * @OA\Get(
     *   path="/product",
     *   tags={"Products"},
     *   summary="Method to read all the saved products from database.",
     *  @OA\Response(
     *         response="200",
     *         description="The list with products",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     ref="#/components/schemas/Products"
     *                 )
     *             )
     *         }
     *     ),
     *   @OA\Response(response="404",description="Not found"),
     * )
     * @OA\Schema(
     *     schema="Products",
     *     type="object",
     *     @OA\Property(
     *          property="id",
     *          type="integer",
     *          description="id product"
     *      ),
     *      @OA\Property(
     *          property="name",
     *          type="string",
     *          description="Product name"
     *      ),
     *      @OA\Property(
     *          property="manufactures",
     *          type="string",
     *          description="Manufacture name",
     *      ),
     *      @OA\Property(
     *          property="release_date",
     *          type="date",
     *          description="Product release date",
     *      ),
     *      @OA\Property(
     *          property="cost",
     *          type="integer",
     *          description="Product cost",
     *      ),
     *      @OA\Property(
     *          property="type_name",
     *          type="string",
     *          description="Name product type",
     *      ),
     *      example={
     *          "id": "3",
     *          "name": "bearer",
     *          "manufactures": "apple",
     *          "release_date": "2021-11-01 09:42:05",
     *          "cost": "900",
     *          "type_name": "Phones",
     *      }
     * )
     */
    public function index(): void
    {
        $products = $this->productRepository->getAllProduct();
        $this->json($products);
    }

    /**
     * @OA\Get(
     *   path="/product/[0-9]+",
     *   tags={"Product", "Services"},
     *   summary="Method to read one product by id from database.",
     *  @OA\Response(
     *         response="200",
     *         description="The product info with her availible services.",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     ref="#/components/schemas/ProductWithServices"
     *                 )
     *             )
     *         }
     *     ),
     *   @OA\Response(response="404",description="Not found"),
     * )
     * @OA\Schema(
     *     schema="ProductWithServices",
     *     type="object",
     *     @OA\Property(
     *          property="id",
     *          type="integer",
     *          description="id product"
     *      ),
     *      @OA\Property(
     *          property="name",
     *          type="string",
     *          description="Product name"
     *      ),
     *      @OA\Property(
     *          property="manufactures",
     *          type="string",
     *          description="Manufacture name",
     *      ),
     *      @OA\Property(
     *          property="release_date",
     *          type="date",
     *          description="Product release date",
     *      ),
     *      @OA\Property(
     *          property="cost",
     *          type="integer",
     *          description="Product cost",
     *      ),
     *      @OA\Property(
     *          property="type_name",
     *          type="string",
     *          description="Name product type",
     *      ),
     *     @OA\Property(
     *          property="services",
     *          type="array",
     *          description="The list with available services.",
     *          @OA\Items(
     *              ref="#/components/schemas/Services"
     *          ),
     *     ),
     *      example={
     *          "id": "3",
     *          "name": "bearer",
     *          "manufactures": "apple",
     *          "release_date": "2021-11-01 09:42:05",
     *          "cost": "900",
     *          "type_name": "Phones",
     *          "services":{
     *              {
     *                  "service_name": "Warranty",
     *                  "deadline": "1 year",
     *                  "service_cost": "100",
     *              },
     *              {
     *                  "service_name": "Delivery",
     *                  "deadline": "1 day",
     *                  "service_cost": "10",
     *              },
     *          },
     *      }
     * )
     *
     * @OA\Schema(
     *     schema="Services",
     *     type="object",
     *     @OA\Property(
     *          property="service_name",
     *          type="string",
     *          description="Service name"
     *      ),
     *      @OA\Property(
     *          property="deadline",
     *          type="string",
     *          description="Service deadline"
     *      ),
     *      @OA\Property(
     *          property="service_cost",
     *          type="integer",
     *          description="Service cost",
     *      ),
     *      example={
     *          "service_name": "Delivery",
     *          "deadline": "1 week",
     *          "service_cost": "10",
     *      }
     * )
     */
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

    /**
     * @OA\Get(
     *   path="/product/[0-9]+/[0-9]+",
     *   tags={"Product", "Service"},
     *   summary="Method to read one product and one service by id from database.",
     *  @OA\Response(
     *         response="200",
     *         description="The product info with her select service.",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     ref="#/components/schemas/ProductWithService"
     *                 )
     *             )
     *         }
     *     ),
     *   @OA\Response(response="404",description="Not found"),
     * )
     * @OA\Schema(
     *     schema="ProductWithService",
     *     type="object",
     *     @OA\Property(
     *          property="id",
     *          type="integer",
     *          description="Id product"
     *      ),
     *      @OA\Property(
     *          property="name",
     *          type="string",
     *          description="Product name"
     *      ),
     *      @OA\Property(
     *          property="manufactures",
     *          type="string",
     *          description="Manufacture name",
     *      ),
     *      @OA\Property(
     *          property="release_date",
     *          type="date",
     *          description="Product release date",
     *      ),
     *      @OA\Property(
     *          property="cost",
     *          type="integer",
     *          description="Product cost",
     *      ),
     *      @OA\Property(
     *          property="type_name",
     *          type="string",
     *          description="Name product type",
     *      ),
     *     @OA\Property(
     *          property="service",
     *          type="array",
     *          description="The list with available services.",
     *          @OA\Items(
     *              ref="#/components/schemas/Services"
     *          ),
     *     ),
     *     @OA\Property(
     *          property="total_cost",
     *          type="integer",
     *          description="Total price",
     *     ),
     *      example={
     *          "id": "3",
     *          "name": "bearer",
     *          "manufactures": "apple",
     *          "release_date": "2021-11-01 09:42:05",
     *          "cost": "900",
     *          "type_name": "Phones",
     *          "service":{
     *              "service_name": "Delivery",
     *              "deadline": "1 day",
     *              "service_cost": "10",
     *          },
     *          "total_cost": "910",
     *      }
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/product/create",
     *     summary="Method add in database new data about product.",
     *     tags={"Product"},
     *     @OA\Response(
     *         response="200",
     *         description="Success"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not found"
     *     ),
     * )
     */

    /**
     * @OA\Post(
     *   path="/product/create",
     *   tags={"Product"},
     *   summary="Method add in database new data about product.",
     *  @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               ref="#/components/schemas/Products"
     *           )
     *       )
     *   ),
     *     @OA\Response(
     *         response="200",
     *         description="Success.",
     *     ),
     *   @OA\Response(response="404",description="Not found"),
     * )
     */
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
