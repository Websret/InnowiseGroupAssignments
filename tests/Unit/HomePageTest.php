<?php

namespace Tests\Unit;

use App\Http\Controllers\ProductController;
use App\Models\Product;
use Database\Seeders\ProductTypes;
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
        $product = Product::first();
        $productPage = (new ProductController())->index();
        $this->assertEquals($product->name, $productPage->products[0]->name);
    }
}
