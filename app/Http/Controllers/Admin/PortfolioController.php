<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePortfolioRequest;
use App\Http\Requests\UpdatePortfolioRequest;
use App\Models\Portfolio;
use App\Services\PortfolioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $query = Portfolio::query();

        // Search query
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($category = $request->input('category')) {
            if ($category !== 'all') {
                $query->where('category', $category);
            }
        }

        // Status tab filter
        $status = $request->input('status', 'all');
        if ($status === 'published') {
            $query->where('is_published', true);
        } elseif ($status === 'draft') {
            $query->where('is_published', false);
        } elseif ($status === 'highlight') {
            $query->where('is_highlight', true);
        }

        // Counts for filter tabs
        $counts = [
            'all' => Portfolio::count(),
            'published' => Portfolio::where('is_published', true)->count(),
            'draft' => Portfolio::where('is_published', false)->count(),
            'highlight' => Portfolio::where('is_highlight', true)->count(),
        ];

        $portfolios = $query->latest()->paginate(10)->withQueryString();

        return view('admin.portfolios.index', compact('portfolios', 'counts', 'status'));
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

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Portfolio status successfully updated!',
                    'is_published' => (bool)$portfolio->is_published,
                    'is_highlight' => (bool)$portfolio->is_highlight,
                    'published_at' => $portfolio->published_at ? $portfolio->published_at->format('d M Y, H:i') : null,
                ]);
            }
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

    public function destroyGalleryImage(Request $request, Portfolio $portfolio, PortfolioService $portfolioService)
    {
        $request->validate([
            'image' => 'required|string',
        ]);

        $portfolioService->removeGalleryImage($portfolio, $request->input('image'));

        return back()->with('success', 'Gallery photo successfully removed!');
    }

    public function trash()
    {
        $portfolios = Portfolio::onlyTrashed()->paginate(10);

        return view('admin.portfolios.trash', compact('portfolios'));
    }

    public function restore(Portfolio $portfolio)
    {
        $portfolio->restore();

        return back()->with('success', 'Portfolio successfully restored!');
    }

    public function forceDestroy(Portfolio $portfolio)
    {
        if ($portfolio->thumbnail && ! Str::startsWith($portfolio->thumbnail, ['http://', 'https://'])) {
            Storage::delete($portfolio->thumbnail);
        }

        if (!empty($portfolio->gallery)) {
            foreach ($portfolio->gallery as $image) {
                if (! Str::startsWith($image, ['http://', 'https://'])) {
                    Storage::delete($image);
                }
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
