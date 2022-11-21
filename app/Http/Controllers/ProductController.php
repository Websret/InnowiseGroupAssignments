<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use \Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('components.products.show', ['products' => Product::with('type')->get()]);
    }

    public function show(int $id): Factory|View|Application
    {
        return view('components.products.index', [
            'product' => Product::with('type')->where('id', '=', $id)->get(),
            'services' => Product::where('id', $id)->with('type.service')->first(),
        ]);
    }

    public function create(): Factory|View|Application
    {
        return view('components.products.create', ['productTypes' => ProductType::all()]);
    }

    public function store(UpdateProductRequest $request): RedirectResponse
    {
        Product::create($request->validated());

        return redirect()->route('admin.dashboard');
    }

    public function edit(int $id): Factory|View|Application
    {
        return view('components.products.edit', [
            'product' => Product::with('type')->where('id', '=', $id)->get(),
            'productTypes' => ProductType::all(),
        ]);
    }

    public function update(UpdateProductRequest $request, int $id): RedirectResponse
    {
        Product::where('id', $id)->update($request->validated());

        return redirect()->route('admin.dashboard');
    }

    public function destroy(int $id): RedirectResponse
    {
        Product::where('id', $id)->delete();

        return redirect()->route('admin.dashboard');
    }
}
