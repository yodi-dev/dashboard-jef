<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PortfolioResource;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $query = Portfolio::where('is_published', true);

        if ($request->filled('category') && $request->category !== 'All') {
            $query->where('category', $request->category);
        }

        $portfolios = $query->latest()->get();
        return PortfolioResource::collection($portfolios);
    }

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
