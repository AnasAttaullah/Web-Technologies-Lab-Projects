<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;

Route::get('/', function () {
    return redirect()->route('customers.index');
});

Route::resource('customers', CustomerController::class);
Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class);
Route::resource('order-details', OrderDetailController::class);
