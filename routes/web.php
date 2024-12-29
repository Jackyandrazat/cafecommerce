<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

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
    return view('welcome');
});


// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'index']);
// });

// Route::middleware(['auth', 'role:kasir'])->group(function () {
//     Route::get('/kasir/dashboard', [KasirController::class, 'index']);
// });

Route::middleware(['auth', 'role:admin|kasir'])->group(function () {
    // Route::get('/reports/orders', [ReportController::class, 'generateOrderReport'])->name('reports.orders');
    Route::get('/reports/orders/{id}', [ReportController::class, 'generateOrderReport'])
        ->name('reports.orders');
    Route::get('/reports/monthly', [ReportController::class, 'generateMonthlyReport'])->name('reports.monthly');
});

