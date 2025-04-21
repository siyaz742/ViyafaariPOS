<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisteredUserController;






// Public Routes
Route::get('/', function () {
    return view('auth.login');
});


// Dashboard Route (Only for Authenticated and Verified Users)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



// Authenticated Routes
Route::middleware('auth')->group(function () {

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('customers', CustomerController::class);
    Route::post('/customers/{id}/restore', [CustomerController::class, 'restore'])->name('customers.restore');
    Route::resource('products', ProductController::class);
    Route::post('/products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::resource('vendors', VendorController::class);
    Route::post('/vendors/{id}/restore', [VendorController::class, 'restore'])->name('vendors.restore');
    Route::resource('orders', OrderController::class);
    Route::resource('users', UserController::class);
    Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');

    Route::get('stock/add', [ProductController::class, 'batchAddStockForm'])->name('stock.batchAddStockForm');
    Route::post('stock/store', [ProductController::class, 'storeBatchStockAddition'])->name('stock.storeBatchStockAddition');
    Route::get('stock/history', [ProductController::class, 'stockAdditionHistory'])->name('stock.history');


    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('reports/sales/export', [ReportController::class, 'exportSales'])->name('reports.export.sales');
    Route::get('/reports/sales-by-product', [ReportController::class, 'salesByProduct'])->name('reports.salesByProduct');
    Route::get('reports/sales-by-product/export', [ReportController::class, 'exportSalesByProduct'])->name('reports.export.sales_by_product');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/sales-data', [DashboardController::class, 'getSalesData']);
    Route::get('/dashboard/revenue-data', [DashboardController::class, 'getRevenueData']);
    Route::get('/dashboard/top-products', [DashboardController::class, 'getTopProducts']);
    Route::get('/dashboard/low-stock-data', [DashboardController::class, 'getLowStockData']);





    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

});

require __DIR__.'/auth.php';
