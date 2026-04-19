<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePortfolioRequest;
use App\Http\Requests\UpdatePortfolioRequest;
use App\Models\Portfolio;
use App\Services\PortfolioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            ->with('success', 'Portfolio successfully created!');
    }

    public function show(Portfolio $portfolio)
    {
        return view('admin.portfolios.show', compact('portfolio'));
    }

    public function toggle(Request $request, Portfolio $portfolio)
    {
        $field = $request->input('field');

        // Ensure only these fields can be changed via toggle
        if (in_array($field, ['is_published', 'is_highlight'])) {

            // 1. Toggle the value of the clicked field
            $portfolio->$field = !$portfolio->$field;

            // 2. Logic if the "is_highlight" toggle is clicked
            if ($field === 'is_highlight') {
                // If highlight is turned on (true), automatically set is_published to true
                if ($portfolio->is_highlight === true) {
                    $portfolio->is_published = true;

                    // Ensure published_at is filled if it was previously empty
                    if (is_null($portfolio->published_at)) {
                        $portfolio->published_at = now();
                    }
                }
                // If highlight is turned off (false), leave is_published as is
            }

            // 3. Logic if the "is_published" toggle is clicked
            if ($field === 'is_published') {
                // Set publish date
                $portfolio->published_at = $portfolio->is_published ? now() : null;

                // If publish is turned off (false / becomes draft), automatically turn off highlight
                if ($portfolio->is_published === false) {
                    $portfolio->is_highlight = false;
                }
            }

            // Save to database
            $portfolio->save();
        }

        return back()->with('success', 'Status successfully updated!');
    }

    public function edit(Portfolio $portfolio)
    {
        return view('admin.portfolios.edit', compact('portfolio'));
    }

    public function update(UpdatePortfolioRequest $request, Portfolio $portfolio, PortfolioService $portfolioService)
    {
        // Delegate update task to Service Class
        $portfolioService->updatePortfolio($portfolio, $request);

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portfolio successfully updated!');
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
            ->with('success', 'Portfolio successfully restored!');
    }

    public function forceDestroy($id)
    {
        $portfolio = Portfolio::onlyTrashed()->findOrFail($id);

        if ($portfolio->thumbnail) {
            Storage::delete($portfolio->thumbnail);
        }

        if (!empty($portfolio->gallery)) {
            foreach ($portfolio->gallery as $image) {
                Storage::delete($image);
            }
        }

        $portfolio->forceDelete();

        return back()->with('success', 'Portfolio successfully deleted permanently!');
    }

    public function destroy(Portfolio $portfolio)
    {
        $portfolio->delete();

        return back()->with('success', 'Portfolio successfully deleted!');
    }
}
