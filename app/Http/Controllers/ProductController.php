<?php

namespace App\Http\Controllers;

use App\Helpers\EmploymentWithCurrencyData;
use App\Helpers\ProductFilter;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use \Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): Factory|View|Application
    {
        $xmlData = new EmploymentWithCurrencyData();
        $currencies = $xmlData->getCurrency(env('CURRENCY_XML_FILE'));
        $xmlData->reviseAndUpdateCurrencyInDb($currencies);

        $productFilter = new ProductFilter();
        $products = $productFilter->run($request, Product::class)
            ->with('type')
            ->orderBy($request->order ?: 'name')
            ->paginate(5);

        return view('components.products.show', [
            'products' => $products,
            'productTypes' => ProductType::all(),
        ]);
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
