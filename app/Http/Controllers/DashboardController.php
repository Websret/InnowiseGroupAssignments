<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;

class DashboardController extends Controller
{
    public function show()
    {
        return view('components.dashboard.panel', [
            'products' => Product::with('type')->get(),
            'services' => Service::all(),
        ]);
    }
}
