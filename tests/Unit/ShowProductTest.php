<?php

namespace Tests\Unit;

use App\Http\Controllers\ProductController;
use App\Models\Product;
use Tests\TestCase;

class ShowProductTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_show_product_page()
    {
//        $product = Product::factory(1)->create();
        $product = Product::all();
        $page = (new ProductController())->show($product[0]->id);
        $this->assertEquals($product[0]->name, $page->product[0]->name);
    }
}
