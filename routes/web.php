<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Models\Product;


// Homepage
Route::get('/', function () {
    $products = Product::inRandomOrder()->limit(6)->get(); // Fetch 4 random products
    return view('welcome', compact('products'));
});

// Products Routes
Route::get('/products', [ProductController::class, 'index'])->name('product.index'); // Show all products
Route::get('/products/fetch', [ProductController::class, 'fetchProducts']); // Fetch & store products

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index'); // View cart
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add'); // Add to cart
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update'); // Update cart
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove'); // Remove item


// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/order-summary/{transactionId}', [CheckoutController::class, 'orderSummary'])->name('order.summary');

