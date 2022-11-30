<?php

namespace Tests\Unit;

use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Http\Request;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_catalog_products_page()
    {
//        $this->seed(ProductTypes::class);
//        Product::factory(1)->create();

        $product = Product::all();
        $productPage = (new ProductController())->index(Request::create(route('index', 'GET')));
        $this->assertEquals($product[0]->name, $productPage->products[0]->name);
    }
}
