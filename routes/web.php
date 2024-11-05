<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.new_login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\DashboardController::class, 'index'])->name('home');

Route::middleware("auth")->group(function () {
    Route::get('/customers', [CustomerController::class, 'index'])->name('admin.customer');
    Route::post('/customers/add', [CustomerController::class, 'store'])->name('saveData');
    Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');

    Route::get('/products', [ProductController::class, 'index'])->name('admin.product');
    Route::post('/products/add', [ProductController::class, 'store'])->name('saveDataProduct');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

    Route::get('/debts', [DebtController::class, 'index'])->name('admin.debt');
    Route::post('/debts/add', [DebtController::class, 'store'])->name('saveDataDebt');
    Route::get('/debts/{id}', [DebtController::class, 'show'])->name('admin.debt.detail');
    Route::post("/debts/pay", [DebtController::class, "payDebt"])->name("payDebt");

    Route::get('/download-report', [ReportController::class, 'downloadReport'])->name('download.report.pdf');
    Route::get('/download-excel', [ReportController::class, 'downloadExcel'])->name('download.report.excel');


});
