<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Collection;
use \Illuminate\Contracts\View\Factory;
use \Illuminate\Contracts\View\View;
use \Illuminate\Contracts\Foundation\Application;
use \Illuminate\Http\RedirectResponse;

class ServiceController extends Controller
{
    public function getServices(): Collection
    {
        return DB::table('services')
            ->get();
    }

    public function create(): Factory|View|Application
    {
        return view('components.services.create');
    }

    public function store()
    {
        $this->validate(\request(), [
            'service_name' => 'required|string|min:3|max:50',
            'deadline' => 'required|min:3|max:50',
            'service_cost' => 'required|integer',
        ]);

        Service::create(\request(['service_name', 'deadline', 'service_cost']));

        return redirect()->to('/admin/dashboard');
    }

    public function edit(int $id)
    {
        return view('components.services.edit', ['service' => $this->getService($id)]);
    }

    private function getService(int $id): Collection
    {
        return DB::table('services')
            ->where('id', '=', $id)
            ->get();
    }

    public function update(int $id): RedirectResponse
    {
        $this->validate(\request(), [
            'service_name' => 'required|string|min:3|max:50',
            'deadline' => 'required|min:3|max:50',
            'service_cost' => 'required|integer',
        ]);

        DB::table('services')
            ->where('id', '=', $id)
            ->update([
                'service_name' => $_POST['service_name'],
                'deadline' => $_POST['deadline'],
                'service_cost' => $_POST['service_cost'],
            ]);

        return redirect()->to('/admin/dashboard');
    }

    public function delete(int $id): RedirectResponse
    {
        DB::table('services')
            ->where('id', '=', $id)
            ->delete();

        return redirect()->to('/admin/dashboard');
    }
}
