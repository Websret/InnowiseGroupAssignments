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

Route::get('/', [ProductController::class, 'show']);

Route::get('/admin/dashboard', [DashboardController::class, 'show']);

Route::get('/product/create', [ProductController::class, 'create']);
Route::post('/product/create', [ProductController::class, 'store']);
Route::get('/product/{id}', [ProductController::class, 'index'])->where('id', '[0-9]+');
Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->where('id', '[0-9]+');
Route::put('/product/{id}/edit', [ProductController::class, 'update'])->where('id', '[0-9]+');
Route::delete('/product/{id}/delete', [ProductController::class, 'delete'])->where('id', '[0-9]+');

Route::get('/service/create', [ServiceController::class, 'create']);
Route::post('/service/create', [ServiceController::class, 'store']);
Route::get('/service/{id}/edit', [ServiceController::class, 'edit'])->where('id', '[0-9]+');
Route::put('/service/{id}/edit', [ServiceController::class, 'update'])->where('id', '[0-9]+');
Route::delete('/service/{id}/delete', [ServiceController::class, 'delete'])->where('id', '[0-9]+');

Route::get('/register', [RegistrationController::class, 'create']);
Route::post('/register', [RegistrationController::class, 'store']);

Route::get('/login', [SessionsController::class, 'create']);
Route::post('/login', [SessionsController::class, 'store']);
Route::get('/logout', [SessionsController::class, 'destroy']);
