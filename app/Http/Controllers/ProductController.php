<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function show(): Factory|View|Application
    {
        $products = DB::table('products')
            ->join('product_types', 'product_types.id', '=', 'products.product_type')
            ->orderBy('products.id', 'ASC')
            ->get();

        return view('components.products.show', ['products' => $products]);
    }
}
