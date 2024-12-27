<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RentalController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;

// Guest Route
Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::post('/post-login', [AuthController::class, 'login']);
})->middleware('guest');

// Admin Route
Route::group(['middleware' => 'admin'], function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Admin Route
    Route::prefix('admin/admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.admin');
        Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
        Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('/update/{id}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/delete/{id}', [AdminController::class, 'destroy'])->name('admin.delete');
        Route::get('/admin/flashsales/{id}', [AdminController::class, 'show'])->name('admin.admin.show');
    });

    Route::get('/admin-logout', [AuthController::class, 'admin_logout'])->name('admin.logout');
})->middleware('admin');

// User Route
Route::group(['middleware' => 'web'], function () {
    Route::get('/user', function () {
        return view('pages.user.index');
    })->name('user.dashboard');

    Route::get('/user-logout', [AuthController::class, 'user_logout'])->name('user.logout');
})->middleware('web');

// Route default untuk halaman welcome
Route::get('/', function () {
    return view('welcome');
});


// Rute untuk kendaraan
Route::get('/vehicles', [VehicleController::class, 'index'])->name('admin.vehicles.index');
Route::get('/vehicles/create', [VehicleController::class, 'create'])->name('admin.vehicles.create'); 
Route::post('/vehicles', [VehicleController::class, 'store'])->name('admin.vehicles.store');
Route::get('/vehicles/{vehicle}/detail', [VehicleController::class, 'detail'])->name('admin.vehicles.detail');
Route::get('/vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])->name('admin.vehicles.edit');
Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('admin.vehicles.update');
Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'delete'])->name('admin.vehicles.delete');


// Rute untuk peminjaman
Route::get('/rentals', [RentalController::class, 'index'])->name('admin.rentals.index');
Route::get('/rentals/create', [RentalController::class, 'create'])->name('admin.rentals.create'); 
Route::post('/rentals', [RentalController::class, 'store'])->name('admin.rentals.store');
Route::get('/rentals/{rental}/edit', [RentalController::class, 'edit'])->name('admin.rentals.edit');
Route::get('/rentals/{rental}/detail', [RentalController::class, 'detail'])->name('admin.rentals.detail');
Route::put('/rentals/{rental}', [RentalController::class, 'update'])->name('admin.rentals.update');
Route::delete('/rentals/{rental}', [RentalController::class, 'delete'])->name('admin.rentals.delete');

// Route::delete('/rentals/{id}/delete', [RentalController::class, 'delete'])->name('admin.rentals.delete');


// Route untuk filter kendaraan berdasarkan status
Route::get('/vehicles/status/{status}', [VehicleController::class, 'filter'])->name('vehicles.filter');