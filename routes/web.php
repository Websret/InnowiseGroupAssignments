<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ServiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ProductController::class, 'index'])->name('index');

Route::get('/admin/dashboard', [DashboardController::class, 'show'])->name('admin.dashboard');

Route::resource('/product', ProductController::class);

Route::resource('/service', ServiceController::class)->except('index', 'show');

Route::get('/register', [RegistrationController::class, 'create']);
Route::post('/register', [RegistrationController::class, 'store']);
Route::resource('/register', RegistrationController::class)->only('create', 'store');

Route::resource('/login', ServiceController::class)->only('create', 'store');
Route::get('/logout', [SessionsController::class, 'destroy'])->name('logout');
