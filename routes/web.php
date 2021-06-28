<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

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
Route::get('/',[ProductController::class, 'index'])->name('index');

Route::post('/cart',[ProductController::class, 'cart'])->name('cart');
Route::post('/add-to-cart',[ProductController::class, 'addToCart'])->name('addToCart');

Route::post('/update-cart',[ProductController::class, 'updateCart'])->name('cart.update');
Route::post('/cancel-cart',[ProductController::class, 'cancelCart'])->name('cart.cancel');
Route::post('/checkout-cart',[ProductController::class, 'checkout'])->name('cart.checkout');
Route::post('/checkout',[ProductController::class, 'checkoutSubmit'])->name('checkout');

Route::get('/order-history',[OrderController::class, 'index'])->name('order.history');
Route::post('/order-detail',[OrderController::class, 'orderDetail'])->name('order.detail');

Route::get('/order-redund/{order}',[OrderController::class, 'orderRefund'])->name('order.refund');



