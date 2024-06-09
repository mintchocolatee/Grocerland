<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FaqController;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::get('/login', [UserController::class, 'login'])->name('user.login');
Route::post('/login', [UserController::class, 'handleLogin'])->name('user.handleLogin');
Route::get('/register', [UserController::class, 'register'])->name('user.register');
Route::post('/register', [UserController::class, 'handleRegister'])->name('user.handleRegister');
Route::get('/verify-email/{token}', [UserController::class, 'verifyEmail'])->name('user.verifyEmail');
Route::get('/reset-password', [UserController::class, 'resetPassword'])->name('user.resetPassword');
Route::post('/reset-password', [UserController::class, 'handleResetPassword'])->name('user.handleResetPassword');
Route::get('/reset-password/{token}', [UserController::class, 'verifyResetPassword'])->name('user.verifyResetPassword');
Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');

// Product CRUD routes
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::post('/product', [ProductController::class, 'store'])->name('products.store');
Route::get('products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/product/create', [ProductController::class, 'create'])->name('products.create');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/search', [ProductController::class, 'search'])->name('search');

// Cart CRUD routes
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::post('cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::patch('cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

// Order routes
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::post('/orders/reorder/{orderId}', [OrderController::class, 'reorder'])->name('orders.reorder');

// Checkout CRUD routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

// FAQ CRUD routes
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
Route::post('/faq/post', [FaqController::class, 'store'])->name('faq.store');
Route::get('/faq/add', [FaqController::class, 'create'])->name('faq.create');
Route::get('/faq/{id}/edit', [FaqController::class, 'edit'])->name('faq.edit');
Route::put('/faq/{id}', [FaqController::class, 'update'])->name('faq.update');
Route::delete('/faq/{id}/destroy', [FaqController::class, 'destroy'])->name('faq.destroy');
Route::delete('/faq/{faqId}/destroySub/{subIndex}', [FaqController::class, 'destroySub'])->name('faq.destroySub');
