<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ShoeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ActivityLogController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('categories', CategoryController::class);
Route::resource('shoes', ShoeController::class);
Route::resource('promos', PromoController::class);
Route::resource('transactions', TransactionController::class)->except(['edit', 'update', 'destroy']);
Route::post('transactions/{transaction}/pay', [TransactionController::class, 'payInstallment'])->name('transactions.pay');
Route::get('logs', [ActivityLogController::class, 'index'])->name('logs.index');
