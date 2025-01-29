<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::middleware(['auth', 'role:admin|kasir'])->group(function () {
    // Route::get('/reports/orders', [ReportController::class, 'generateOrderReport'])->name('reports.orders');
    Route::get('/reports/orders/{id}', [ReportController::class, 'generateOrderReport'])
        ->name('reports.orders');
    Route::get('/reports/monthly', [ReportController::class, 'generateMonthlyReport'])->name('reports.monthly');
});


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:kasir|pelanggan'])->group(function () {
    Route::get('/cart', [CartItemController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartItemController::class, 'store'])->name('cart.store');
    Route::get('/cart/{cartItem}', [CartItemController::class, 'show'])->name('cart.show');
    Route::patch ('/cart/{cartItem}', [CartItemController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartItemController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/add', [CartItemController::class, 'store'])->name('cart.add');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/apply-promo', [CheckoutController::class, 'applyPromo'])->name('checkout.apply-promo');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
});

