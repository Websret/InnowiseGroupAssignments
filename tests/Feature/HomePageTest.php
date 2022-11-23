<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\ProductTypes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
//    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_home_page_view()
    {
        $this->seed(ProductTypes::class);
        $products = Product::factory(2)->create();

        $view = $this->view('components.products.show', ['products' => $products]);

        $view->assertSee('product');
        $this->assertGuest();
    }
}
