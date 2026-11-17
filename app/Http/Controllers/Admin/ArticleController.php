<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::query();

        // Search query
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
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
            'all' => Article::count(),
            'published' => Article::where('is_published', true)->count(),
            'draft' => Article::where('is_published', false)->count(),
            'highlight' => Article::where('is_highlight', true)->count(),
        ];

        $articles = $query->latest()->paginate(10)->withQueryString();

        return view('admin.articles.index', compact('articles', 'counts', 'status'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(StoreArticleRequest $request, ArticleService $articleService)
    {
        $articleService->createArticle($request);

        return redirect()->route('admin.articles.index')->with('success', 'Article successfully added!');
    }

    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(UpdateArticleRequest $request, Article $article, ArticleService $articleService)
    {
        $articleService->updateArticle($article, $request);

        return redirect()->route('admin.articles.index')->with('success', 'Article successfully updated!');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Article successfully deleted!');
    }

    public function trash()
    {
        $articles = Article::onlyTrashed()->latest()->paginate(10);

        return view('admin.articles.trash', compact('articles'));
    }

    public function restore(Article $article)
    {
        $article->restore();

        return redirect()->back()->with('success', 'Article successfully recovered!');
    }

    public function forceDestroy(Article $article)
    {
        if ($article->cover_image && ! Str::startsWith($article->cover_image, ['http://', 'https://'])) {
            Storage::delete($article->cover_image);
        }

        $article->forceDelete();

        return redirect()->back()->with('success', 'The article and its images were successfully destroyed!');
    }

    public function toggle(Request $request, Article $article)
    {
        $field = $request->input('field');

        if (in_array($field, ['is_published', 'is_highlight'])) {
            $article->$field = !$article->$field;

            // Logika cerdas Toggle
            if ($field === 'is_highlight' && $article->is_highlight === true) {
                $article->is_published = true;
                if (is_null($article->published_at)) {
                    $article->published_at = now();
                }
            }

            if ($field === 'is_published') {
                $article->published_at = $article->is_published ? now() : null;
                if ($article->is_published === false) {
                    $article->is_highlight = false;
                }
            }

            $article->save();

            if ($request->wantsJson() || $request->ajax()) {
                $counts = [
                    'all' => Article::count(),
                    'published' => Article::where('is_published', true)->count(),
                    'draft' => Article::where('is_published', false)->count(),
                    'highlight' => Article::where('is_highlight', true)->count(),
                ];

                return response()->json([
                    'success' => true,
                    'message' => 'Article status successfully changed!',
                    'is_published' => (bool)$article->is_published,
                    'is_highlight' => (bool)$article->is_highlight,
                    'published_at' => $article->published_at ? $article->published_at->format('d M Y, H:i') : null,
                    'counts' => $counts,
                ]);
            }
        }

        return back()->with('success', 'Article status successfully changed!');
    }
}
