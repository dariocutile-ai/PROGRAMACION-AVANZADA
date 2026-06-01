<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\InventoryMovementController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\Web\RoleController;
use App\Http\Controllers\Web\SupplierController;
use App\Http\Controllers\Web\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('auth.login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::middleware('checkRole:Admin,Manager,Employee')->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('suppliers', SupplierController::class);

        Route::get('/inventory/movements', [InventoryMovementController::class, 'index'])->name('inventory.movements.index');
        Route::get('/inventory/movements/create', [InventoryMovementController::class, 'create'])->name('inventory.movements.create');
        Route::post('/inventory/movements', [InventoryMovementController::class, 'store'])->name('inventory.movements.store');
        Route::get('/inventory/movements/{movement}', [InventoryMovementController::class, 'show'])->name('inventory.movements.show');

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    });

    Route::middleware('checkRole:Admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
    });
});
