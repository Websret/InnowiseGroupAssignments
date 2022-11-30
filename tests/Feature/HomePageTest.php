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
        $response = $this->get('/');

        $response->assertSee('product');
        $this->assertGuest();
    }
}
