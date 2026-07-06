<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ElectricityController;
use App\Http\Controllers\FastagController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RechargeController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/services', ServicesController::class)->name('services.index');

    Route::prefix('electricity')->name('electricity.')->group(function () {
        Route::get('/', [ElectricityController::class, 'index'])->name('index');
        Route::post('/fetch-bill', [ElectricityController::class, 'fetchBill'])->name('fetch-bill');
        Route::post('/pay', [ElectricityController::class, 'pay'])->name('pay');
    });

    Route::prefix('fastag')->name('fastag.')->group(function () {
        Route::get('/', [FastagController::class, 'index'])->name('index');
        Route::post('/fetch-details', [FastagController::class, 'fetchDetails'])->name('fetch-details');
        Route::post('/recharge', [FastagController::class, 'recharge'])->name('recharge');
    });

    Route::prefix('recharge')->name('recharge.')->group(function () {
        Route::get('/', [RechargeController::class, 'index'])->name('index');
        Route::post('/plans', [RechargeController::class, 'plans'])->name('plans');
        Route::post('/pay', [RechargeController::class, 'pay'])->name('pay');
    });

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::patch('/email', [ProfileController::class, 'updateEmail'])->name('update-email');
        Route::patch('/mobile', [ProfileController::class, 'updateMobile'])->name('update-mobile');
    });
});
