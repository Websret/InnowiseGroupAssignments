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
            'name' => 'required|min:2|max:255|string',
            'email' => 'required|email|min:4|max:255',
            'password' => 'required|confirmed|min:4|max:255',
        ]);

        $user = User::create(\request(['name', 'email', 'password']));

        auth()->login($user);

        return redirect()->to('/');
    }
}
