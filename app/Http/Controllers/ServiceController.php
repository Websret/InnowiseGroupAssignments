<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use \Illuminate\Contracts\View\Factory;
use \Illuminate\Contracts\View\View;
use \Illuminate\Contracts\Foundation\Application;
use \Illuminate\Http\RedirectResponse;

class ServiceController extends Controller
{
    public function create(): Factory|View|Application
    {
        return view('components.services.create');
    }

    public function store(UpdateServiceRequest $request): RedirectResponse
    {
        Service::create($request->validated());

        return redirect()->route('admin.dashboard');
    }

    public function edit(int $id): Factory|View|Application
    {
        return view('components.services.edit', ['service' => Service::where('id', $id)->get()]);
    }

    public function update(UpdateServiceRequest $request, int $id): RedirectResponse
    {
        Service::where('id', $id)->update($request->validated());

        return redirect()->route('admin.dashboard');
    }

    public function destroy(int $id): RedirectResponse
    {
        Service::where('id', $id)->delete();

        return redirect()->route('admin.dashboard');
    }
}
