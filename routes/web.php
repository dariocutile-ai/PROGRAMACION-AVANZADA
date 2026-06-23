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
        
        // Rutas de Exportación
        Route::get('/reports/pdf/inventory', [\App\Http\Controllers\Web\ReportExportController::class, 'pdfInventory'])->name('reports.pdf.inventory');
        Route::get('/reports/pdf/low-stock', [\App\Http\Controllers\Web\ReportExportController::class, 'pdfLowStock'])->name('reports.pdf.lowStock');
        Route::get('/reports/pdf/movements', [\App\Http\Controllers\Web\ReportExportController::class, 'pdfMovements'])->name('reports.pdf.movements');
        Route::get('/reports/pdf/by-category', [\App\Http\Controllers\Web\ReportExportController::class, 'pdfByCategory'])->name('reports.pdf.byCategory');

        Route::get('/reports/excel/inventory', [\App\Http\Controllers\Web\ReportExportController::class, 'excelInventory'])->name('reports.excel.inventory');
        Route::get('/reports/excel/low-stock', [\App\Http\Controllers\Web\ReportExportController::class, 'excelLowStock'])->name('reports.excel.lowStock');
        Route::get('/reports/excel/movements', [\App\Http\Controllers\Web\ReportExportController::class, 'excelMovements'])->name('reports.excel.movements');
        Route::get('/reports/excel/by-category', [\App\Http\Controllers\Web\ReportExportController::class, 'excelByCategory'])->name('reports.excel.byCategory');
    });

    Route::middleware('checkRole:Admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::get('/audit-logs', [\App\Http\Controllers\Web\AuditLogController::class, 'index'])->name('audit.index');
    });

    Route::get('/help', [\App\Http\Controllers\Web\HelpController::class, 'index'])->name('help.index');
});
