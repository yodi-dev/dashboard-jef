<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('is_published', true)->latest()->get();

        // collection() digunakan untuk data array/banyak
        return ArticleResource::collection($articles);
    }

    public function highlighted()
    {
        $articles = Article::where('is_published', true)
            ->where('is_highlight', true)
            ->latest()
            ->get();

        return ArticleResource::collection($articles);
    }

    public function show($slug)
    {
        // firstOrFail() otomatis nembak 404 error json kalau data ga ada
        $article = Article::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // new() digunakan untuk single object/satu data
        return new ArticleResource($article);
    }
}
