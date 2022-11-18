<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function show()
    {
        $products = new ProductController();
        $services = new ServiceController();
        return view('components.dashboard.panel', [
            'products' => $products->getProducts(),
            'services' => $services->getServices(),
        ]);
    }
}
