<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateServiceRequest;
use App\Models\ProductType;
use App\Models\Service;
use App\Models\TypeService;
use Illuminate\Contracts\Routing\ResponseFactory;
use \Illuminate\Contracts\View\Factory;
use \Illuminate\Contracts\View\View;
use \Illuminate\Contracts\Foundation\Application;
use \Illuminate\Http\RedirectResponse;

class ServiceController extends Controller
{
    public function create(): Factory|View|Application
    {
        return view('components.services.create', ['productTypes' => ProductType::all()]);
    }

    public function store(UpdateServiceRequest $request): RedirectResponse
    {
        $request->validate(
            ['service_name' =>'unique:App\Models\Service,service_name']
        );
        Service::create($request->validated());
        $id = Service::where($request->validated())->select('id')->firstOrFail();
        $this->addLinksTypeServices($id['id']);

        return redirect()->route('admin.dashboard');
    }

    public function edit(int $id): Factory|View|Application
    {
        return view('components.services.edit', [
            'service' => Service::where('id', $id)->get(),
            'productTypes' => ProductType::all(),
        ]);
    }

    public function update(UpdateServiceRequest $request, int $id): RedirectResponse
    {
        Service::where('id', $id)->update($request->validated());

        $this->addLinksTypeServices($id);

        return redirect()->route('admin.dashboard');
    }

    private function addLinksTypeServices(int $id): void
    {
        $productType = $this->validate(request(), [
            'product_type' => 'array'
        ]);

        if ($productType) {
            TypeService::where('service_type_id', $id)->delete();
            foreach ($productType['product_type'] as $value) {
                TypeService::create([
                    'product_type_id' => $value,
                    'service_type_id' => $id,
                ]);
            }
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        Service::where('id', $id)->delete();

        return redirect()->route('admin.dashboard');
    }
}
