<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\TrashController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('trash', TrashController::class)->name('trash');

        Route::patch('/portfolios/{id}/restore', [PortfolioController::class, 'restore'])->name('portfolios.restore');
        Route::delete('/portfolios/{id}/force-delete', [PortfolioController::class, 'forceDestroy'])->name('portfolios.forceDestroy');
        Route::resource('portfolios', PortfolioController::class);
        // Route khusus untuk toggle status
        Route::patch('portfolios/{portfolio}/toggle', [PortfolioController::class, 'toggle'])
            ->name('portfolios.toggle');

        Route::post('articles/{id}/restore', [ArticleController::class, 'restore'])->name('articles.restore');
        Route::delete('articles/{id}/force-delete', [ArticleController::class, 'forceDestroy'])->name('articles.forceDestroy');
        Route::resource('articles', ArticleController::class);
        Route::patch('articles/{article}/toggle', [ArticleController::class, 'toggle'])
            ->name('articles.toggle');

        Route::resource('bookings', BookingController::class)->except(['create', 'store']);
        Route::post('bookings/{id}/restore', [BookingController::class, 'restore'])->name('bookings.restore');
        Route::delete('bookings/{id}/force-destroy', [BookingController::class, 'forceDestroy'])->name('bookings.forceDestroy');

        Route::controller(ProfileController::class)->group(function () {
            Route::get('/profile', 'edit')->name('profile.edit');
            Route::patch('/profile', 'update')->name('profile.update');
            Route::delete('/profile', 'destroy')->name('profile.destroy');
        });
    });

require __DIR__ . '/auth.php';
