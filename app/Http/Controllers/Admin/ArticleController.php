<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(StoreArticleRequest $request, ArticleService $articleService)
    {
        $articleService->createArticle($request);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil ditambahkan!');
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

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus!');
    }

    public function trash()
    {
        $articles = Article::onlyTrashed()->latest()->paginate(10);

        return view('admin.articles.trash', compact('articles'));
    }

    public function restore($id)
    {
        $article = Article::onlyTrashed()->findOrFail($id);
        $article->restore();

        return redirect()->back()->with('success', 'Artikel berhasil dipulihkan!');
    }

    public function forceDestroy($id)
    {
        $article = Article::onlyTrashed()->findOrFail($id);

        if ($article->cover_image) {
            Storage::delete($article->cover_image);
        }

        $article->forceDelete();

        return redirect()->back()->with('success', 'Artikel beserta gambarnya berhasil dimusnahkan!');
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
        }

        return back()->with('success', 'Status artikel berhasil diubah!');
    }
}
