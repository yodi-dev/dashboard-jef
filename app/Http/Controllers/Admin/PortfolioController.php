<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePortfolioRequest;
use App\Http\Requests\UpdatePortfolioRequest;
use App\Models\Portfolio;
use App\Services\PortfolioService;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::latest()->paginate(10);

        return view('admin.portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        return view('admin.portfolios.create');
    }


    public function store(StorePortfolioRequest $request, PortfolioService $portfolioService)
    {
        $portfolioService->createPortfolio($request);

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portfolio berhasil ditambahkan!');
    }

    public function show(Portfolio $portfolio)
    {
        //
    }

    public function edit(Portfolio $portfolio)
    {
        return view('admin.portfolios.edit', compact('portfolio'));
    }

    public function update(UpdatePortfolioRequest $request, Portfolio $portfolio, PortfolioService $portfolioService)
    {
        // Lempar tugas update ke Service Class
        $portfolioService->updatePortfolio($portfolio, $request);

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portfolio berhasil diperbarui!');
    }

    public function trash()
    {
        $portfolios = Portfolio::onlyTrashed()->paginate(10);

        return view('admin.portfolios.trash', compact('portfolios'));
    }

    public function restore($id)
    {
        $portfolio = Portfolio::withTrashed()->findOrFail($id);
        $portfolio->restore();

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portfolio berhasil dikembalikan!');
    }

    public function forceDelete($id)
    {
        $portfolio = Portfolio::withTrashed()->findOrFail($id);
        $portfolio->forceDelete();

        return redirect()->route('admin.portfolios.trash')
            ->with('success', 'Portfolio dihapus permanen.');
    }

    public function destroy(Portfolio $portfolio)
    {
        $portfolio->delete();

        return back()->with('success', 'Portfolio deleted');
    }
}
