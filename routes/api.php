<?php

use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/health', fn () => response()->json(['status' => 'ok']));

    Route::prefix('auth')->middleware('throttle:10,1')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);

        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    });

    Route::middleware(['cors', 'auth:sanctum', 'throttle:api'])->group(function () {
        // Products: Admin + Manager write, Employee read only.
        Route::get('products', [\App\Http\Controllers\Api\V1\ProductsController::class, 'index'])
            ->middleware('checkRole:Employee,Manager,Admin');
        Route::get('products/{product}', [\App\Http\Controllers\Api\V1\ProductsController::class, 'show'])
            ->middleware('checkRole:Employee,Manager,Admin');
        Route::post('products', [\App\Http\Controllers\Api\V1\ProductsController::class, 'store'])
            ->middleware('checkRole:Admin,Manager');
        Route::put('products/{product}', [\App\Http\Controllers\Api\V1\ProductsController::class, 'update'])
            ->middleware('checkRole:Admin,Manager');
        Route::patch('products/{product}', [\App\Http\Controllers\Api\V1\ProductsController::class, 'update'])
            ->middleware('checkRole:Admin,Manager');
        Route::delete('products/{product}', [\App\Http\Controllers\Api\V1\ProductsController::class, 'destroy'])
            ->middleware('checkRole:Admin');

        // Categories: Employee/Manager solo GET, Admin CRUD completo
        Route::get('categories', [\App\Http\Controllers\Api\V1\CategoriesController::class, 'index'])
            ->middleware('checkRole:Employee,Manager,Admin');
        Route::get('categories/{category}', [\App\Http\Controllers\Api\V1\CategoriesController::class, 'show'])
            ->middleware('checkRole:Employee,Manager,Admin');
        Route::post('categories', [\App\Http\Controllers\Api\V1\CategoriesController::class, 'store'])
            ->middleware('checkRole:Admin');
        Route::put('categories/{category}', [\App\Http\Controllers\Api\V1\CategoriesController::class, 'update'])
            ->middleware('checkRole:Admin');
        Route::patch('categories/{category}', [\App\Http\Controllers\Api\V1\CategoriesController::class, 'update'])
            ->middleware('checkRole:Admin');
        Route::delete('categories/{category}', [\App\Http\Controllers\Api\V1\CategoriesController::class, 'destroy'])
            ->middleware('checkRole:Admin');

        // Suppliers: Employee/Manager solo GET, Admin CRUD completo
        Route::get('suppliers', [\App\Http\Controllers\Api\V1\SuppliersController::class, 'index'])
            ->middleware('checkRole:Employee,Manager,Admin');
        Route::get('suppliers/{supplier}', [\App\Http\Controllers\Api\V1\SuppliersController::class, 'show'])
            ->middleware('checkRole:Employee,Manager,Admin');
        Route::post('suppliers', [\App\Http\Controllers\Api\V1\SuppliersController::class, 'store'])
            ->middleware('checkRole:Admin');
        Route::put('suppliers/{supplier}', [\App\Http\Controllers\Api\V1\SuppliersController::class, 'update'])
            ->middleware('checkRole:Admin');
        Route::patch('suppliers/{supplier}', [\App\Http\Controllers\Api\V1\SuppliersController::class, 'update'])
            ->middleware('checkRole:Admin');
        Route::delete('suppliers/{supplier}', [\App\Http\Controllers\Api\V1\SuppliersController::class, 'destroy'])
            ->middleware('checkRole:Admin');

        // Comments (polymorphic)
        Route::get('{commentable}/{id}/comments', [\App\Http\Controllers\Api\V1\CommentsController::class, 'index'])
            ->middleware('checkRole:Employee,Manager,Admin');
        Route::post('{commentable}/{id}/comments', [\App\Http\Controllers\Api\V1\CommentsController::class, 'store'])
            ->middleware('checkRole:Employee,Manager,Admin');

        // Inventory movements (purchase/sale/waste/restock)
        Route::post('inventory/movements', [\App\Http\Controllers\Api\V1\InventoryMovementsController::class, 'store'])
            ->middleware('checkRole:Admin,Manager');

        // Reports
        Route::middleware('checkRole:Employee,Manager,Admin')->group(function () {
            Route::get('reports/low-stock', [\App\Http\Controllers\Api\V1\ReportsController::class, 'lowStock']);
            Route::get('reports/most-sold', [\App\Http\Controllers\Api\V1\ReportsController::class, 'mostSold']);
            Route::get('reports/recent-movements', [\App\Http\Controllers\Api\V1\ReportsController::class, 'recentMovements']);
            Route::get('reports/inventory-summary', [\App\Http\Controllers\Api\V1\ReportsController::class, 'inventorySummary']);
            Route::get('reports/by-category', [\App\Http\Controllers\Api\V1\ReportsController::class, 'byCategory']);
        });
    });
});




