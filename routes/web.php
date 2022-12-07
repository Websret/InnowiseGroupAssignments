<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ServiceController;
use \App\Http\Controllers\CsvToS3Controller;

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

Route::middleware(['auth', 'isAdmin'])->group(function() {
    Route::get('/admin/dashboard', [DashboardController::class, 'show'])->name('admin.dashboard');

    Route::resource('/product', ProductController::class)->except('index', 'show');

    Route::resource('/service', ServiceController::class)->except('index', 'show');

    Route::get('csv/export', [CsvToS3Controller::class, 'export'])->name('csv.export');
});

Route::resource('/product', ProductController::class)->only('index', 'show');

Route::resource('/register', RegistrationController::class)->only('create', 'store');

Route::resource('/login', SessionsController::class)->only('create', 'store');
Route::get('/logout', [SessionsController::class, 'destroy'])->name('logout');

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.auth');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
