<?php

namespace App\Http\Controllers;

use \Illuminate\Contracts\View\Factory;
use \Illuminate\Contracts\View\View;
use \Illuminate\Contracts\Foundation\Application;
use \Illuminate\Http\RedirectResponse;

class SessionsController extends Controller
{
    public function create(): Factory|View|Application
    {
        return view('components.sessions.create');
    }

    public function store(): RedirectResponse
    {
        if (!auth()->attempt(request(['email', 'password']))) {
            return back()->withErrors([
               'message' => 'The email or password is incorrect, please try again',
            ]);
        }

        return redirect()->to(route('index'));
    }

    public function destroy(): RedirectResponse
    {
        auth()->logout();

        return redirect()->to(route('index'));
    }
}
