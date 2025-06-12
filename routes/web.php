<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\KamarController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReservasiController;
use App\Http\Controllers\Admin\DirectOrderController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('show.login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

//test
Route::get('/test-login', function() {
    $user = User::where('email', 'admin@hotel.com')->first();
    Auth::login($user);
    return redirect('/admin/dashboard');
});

// Admin Routes

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::post('/dashboard/update-kamar-status', [DashboardController::class, 'updateKamarStatus'])->name('admin.dashboard.update-kamar-status');

// Kamar Management
Route::resource('kamar', KamarController::class)->except(['show']);
Route::delete('/kamar/foto/{id}', [KamarController::class, 'deleteFoto'])->name('admin.kamar.delete-foto');

// Reservasi Management
Route::resource('reservasi', ReservasiController::class)->except(['edit', 'update', 'destroy']);
Route::post('/reservasi/{id}/update-status', [ReservasiController::class, 'updateStatus'])->name('admin.reservasi.update-status');

// Direct Order
Route::get('/direct-order', [DirectOrderController::class, 'index'])->name('admin.direct-order');
Route::post('/direct-order', [DirectOrderController::class, 'store'])->name('admin.direct-order.store');


// Home Route
Route::get('/', function () {
    return view('welcome');
})->middleware('guest');