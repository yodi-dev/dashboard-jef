<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePortfolioRequest;
use App\Http\Requests\UpdatePortfolioRequest;
use App\Models\Portfolio;
use App\Services\PortfolioService;
use Illuminate\Http\Request;

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

    public function toggle(Request $request, Portfolio $portfolio)
    {
        $field = $request->input('field');

        // Pastikan cuma field ini yang bisa diubah lewat toggle
        if (in_array($field, ['is_published', 'is_highlight'])) {

            // 1. Balikkan nilai field yang sedang diklik
            $portfolio->$field = !$portfolio->$field;

            // 2. Logika jika yang diklik adalah toggle "is_highlight"
            if ($field === 'is_highlight') {
                // Jika highlight dihidupkan (true), maka otomatis is_published juga true
                if ($portfolio->is_highlight === true) {
                    $portfolio->is_published = true;

                    // Pastikan published_at terisi jika sebelumnya masih kosong
                    if (is_null($portfolio->published_at)) {
                        $portfolio->published_at = now();
                    }
                }
                // Jika highlight dimatikan (false), is_published tetap dibiarkan sesuai aslinya
            }

            // 3. Logika jika yang diklik adalah toggle "is_published"
            if ($field === 'is_published') {
                // Atur tanggal publish
                $portfolio->published_at = $portfolio->is_published ? now() : null;

                // Jika publish dimatikan (false / jadi draft), maka otomatis highlight juga mati
                if ($portfolio->is_published === false) {
                    $portfolio->is_highlight = false;
                }
            }

            // Simpan ke database
            $portfolio->save();
        }

        return back()->with('success', 'Status berhasil diubah!');
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
