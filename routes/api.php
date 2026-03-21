<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\PortfolioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('portfolios')->group(function () {
    Route::get('/', [PortfolioController::class, 'index']);
    Route::get('/{slug}', [PortfolioController::class, 'show']);
});

Route::prefix('articles')->group(function () {
    Route::get('/', [ArticleController::class, 'index']);
    Route::get('/{slug}', [ArticleController::class, 'show']);
});

Route::post('/bookings', [BookingController::class, 'store']);
