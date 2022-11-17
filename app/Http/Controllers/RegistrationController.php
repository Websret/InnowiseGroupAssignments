<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use \Illuminate\Contracts\View\Factory;
use \Illuminate\Contracts\View\View;
use \Illuminate\Contracts\Foundation\Application;
use Illuminate\Validation\ValidationException;
use \Illuminate\Http\RedirectResponse;

class RegistrationController extends Controller
{
    public function create(): Factory|View|Application
    {
        return view('components.registration.create');
    }

    /**
     * @throws ValidationException
     */
    public function store(): RedirectResponse
    {
        $this->validate(\request(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::create(\request(['name', 'email', 'password']));

        auth()->login($user);

        return redirect()->to('/');
    }
}
