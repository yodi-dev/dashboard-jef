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

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/portfolios/trash', [PortfolioController::class, 'trash'])->name('portfolios.trash');
        Route::patch('/portfolios/{id}/restore', [PortfolioController::class, 'restore'])->name('portfolios.restore');
        Route::delete('/portfolios/{id}/force-delete', [PortfolioController::class, 'forceDelete'])->name('portfolios.forceDelete');
        Route::resource('portfolios', PortfolioController::class);
        // Route khusus untuk toggle status
        Route::patch('portfolios/{portfolio}/toggle', [PortfolioController::class, 'toggle'])
            ->name('portfolios.toggle');

        Route::resource('articles', ArticleController::class);

        Route::resource('bookings', BookingController::class);

        Route::controller(ProfileController::class)->group(function () {
            Route::get('/profile', 'edit')->name('profile.edit');
            Route::patch('/profile', 'update')->name('profile.update');
            Route::delete('/profile', 'destroy')->name('profile.destroy');
        });
    });

require __DIR__ . '/auth.php';
