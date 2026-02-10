<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\BookingController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PortfolioController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');
    Route::get('/article', [ArticleController::class, 'index'])->name('article');
    Route::get('/booking', [BookingController::class, 'index'])->name('booking');
});

require __DIR__ . '/auth.php';
