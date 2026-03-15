<?php

use App\Http\Controllers\Api\PortfolioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('portfolios')->group(function () {
    Route::get('/', [PortfolioController::class, 'index']); // GET /api/portfolios
    Route::get('/{slug}', [PortfolioController::class, 'show']); // GET /api/portfolios/nama-slug
});
