<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PortfolioResource;
use App\Models\Portfolio;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::where('is_published', true)->latest()->get();
        return PortfolioResource::collection($portfolios);
    }

    // Tambahkan highlighted juga biar frontend gampang kalau mau bikin carousel portfolio
    public function highlighted()
    {
        $portfolios = Portfolio::where('is_published', true)
            ->where('is_highlight', true)
            ->latest()
            ->get();

        return PortfolioResource::collection($portfolios);
    }

    public function show($slug)
    {
        $portfolio = Portfolio::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return new PortfolioResource($portfolio);
    }
}
