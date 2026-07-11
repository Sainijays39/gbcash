<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\Admin\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'store'])->name('login.store');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');

        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');

        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [AdminUserController::class, 'index'])->name('index');
            Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('edit');
            Route::patch('/{user}', [AdminUserController::class, 'update'])->name('update');
            Route::patch('/{user}/toggle-block', [AdminUserController::class, 'toggleBlock'])->name('toggle-block');
            Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('transactions')->name('transactions.')->group(function () {
            Route::get('/', [AdminTransactionController::class, 'index'])->name('index');
            Route::get('/{transaction}', [AdminTransactionController::class, 'show'])->name('show');
            Route::patch('/{transaction}/approve', [AdminTransactionController::class, 'approve'])->name('approve');
            Route::patch('/{transaction}/reject', [AdminTransactionController::class, 'reject'])->name('reject');
        });
    });
});
