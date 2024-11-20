<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuTamuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, 'check'])->name('home');
Route::resource('products', ProductController::class);

Route::resource('orders', OrderController::class)->only([
  'index',
  'create',
  'store',
  'show',
  'destroy',
]);

Route::get('orders/{id}/reorder', [OrderController::class, 'reorder'])->name('orders.reorder');

Route::get('/restock/{id}', [StockController::class, 'restockProduct'])->name('restock.product');
Route::post('/restock', [StockController::class, 'save'])->name('restock.save');

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');