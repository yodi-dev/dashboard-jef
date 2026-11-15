<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PhotographerProfileController;
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

        Route::post('/portfolios/{portfolio}/restore', [PortfolioController::class, 'restore'])->withTrashed()->name('portfolios.restore');
        Route::delete('/portfolios/{portfolio}/force-delete', [PortfolioController::class, 'forceDestroy'])->withTrashed()->name('portfolios.forceDestroy');
        Route::resource('portfolios', PortfolioController::class);
        Route::delete('portfolios/{portfolio}/gallery-image', [PortfolioController::class, 'destroyGalleryImage'])
            ->name('portfolios.destroyGalleryImage');
        // Route khusus untuk toggle status
        Route::patch('portfolios/{portfolio}/toggle', [PortfolioController::class, 'toggle'])
            ->name('portfolios.toggle');

        Route::post('articles/{article}/restore', [ArticleController::class, 'restore'])->withTrashed()->name('articles.restore');
        Route::delete('articles/{article}/force-delete', [ArticleController::class, 'forceDestroy'])->withTrashed()->name('articles.forceDestroy');
        Route::resource('articles', ArticleController::class);
        Route::patch('articles/{article}/toggle', [ArticleController::class, 'toggle'])
            ->name('articles.toggle');

        Route::resource('bookings', BookingController::class)->except(['create', 'store']);
        Route::post('bookings/{booking}/restore', [BookingController::class, 'restore'])->withTrashed()->name('bookings.restore');
        Route::delete('bookings/{booking}/force-delete', [BookingController::class, 'forceDestroy'])->withTrashed()->name('bookings.forceDestroy');

        Route::controller(PhotographerProfileController::class)->group(function () {
            Route::get('/photographer-profile', 'edit')->name('photographer-profile.edit');
            Route::put('/photographer-profile', 'update')->name('photographer-profile.update');
        });

        Route::controller(ProfileController::class)->group(function () {
            Route::get('/profile', 'edit')->name('profile.edit');
            Route::patch('/profile', 'update')->name('profile.update');
            Route::delete('/profile', 'destroy')->name('profile.destroy');
        });
    });

require __DIR__ . '/auth.php';
