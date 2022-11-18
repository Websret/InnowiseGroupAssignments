<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Collection;
use \Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    public function show(): Factory|View|Application
    {
        return view('components.products.show', ['products' => $this->getProducts()]);
    }

    public function index(int $id): Factory|View|Application
    {
        return view('components.products.index', ['product' => $this->getProduct($id)]);
    }

    public function getProducts(): Collection
    {
        return DB::table('products')
            ->select('products.id', 'name', 'manufacture', 'release_date', 'cost', 'description', 'type_name')
            ->join('product_types', 'product_types.id', '=', 'products.product_type')
            ->orderBy('products.id', 'ASC')
            ->get();
    }

    public function create(): Factory|View|Application
    {
        return view('components.products.create', ['productTypes' => $this->getProductTypes()]);
    }

    public function getProductTypes(): Collection
    {
        return DB::table('product_types')
            ->get();
    }

    public function store(): RedirectResponse
    {
        $this->validate(\request(), [
            'name' => 'required|min:2|max:255|string',
            'manufacture' => 'required|min:2|max:255',
            'release_date' => 'required',
            'cost' => 'required|min:1|integer',
            'description' => 'required|min:4|max:255',
            'product_type' => 'required|integer',
        ]);

        Product::create(\request(['name', 'manufacture', 'release_date', 'cost', 'description', 'product_type']));

        return redirect()->to('/admin/dashboard');
    }

    public function edit(int $id): Factory|View|Application
    {
        return view('components.products.edit', [
            'product' => $this->getProduct($id),
            'productTypes' => $this->getProductTypes(),
        ]);
    }

    public function getProduct(int $id): Collection
    {
        return DB::table('products')
            ->select('products.id', 'name', 'manufacture', 'release_date', 'cost', 'description', 'type_name')
            ->join('product_types', 'product_types.id', '=', 'products.product_type')
            ->where('products.id', '=', $id)
            ->get();
    }

    public function update(int $id): RedirectResponse
    {
        $this->validate(\request(), [
            'name' => 'required|min:2|max:255|string',
            'manufacture' => 'required|min:2|max:255',
            'release_date' => 'required',
            'cost' => 'required|min:1|integer',
            'description' => 'required|min:4|max:255',
            'product_type' => 'required|integer',
        ]);

        DB::table('products')
            ->where('products.id', '=', $id)
            ->update([
                'name' => $_POST['name'],
                'manufacture' => $_POST['manufacture'],
                'release_date' => $_POST['release_date'],
                'cost' => $_POST['cost'],
                'description' => $_POST['description'],
                'product_type' => $_POST['product_type'],
            ]);

        return redirect()->to('/admin/dashboard');
    }
}
