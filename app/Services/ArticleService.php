<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleService
{
    public function createArticle($request)
    {
        $data = $request->validated();

        // Kalau excerpt kosong, potong 150 huruf pertama dari konten
        $validated['excerpt'] = $request->excerpt ?? Str::limit(strip_tags($request->content), 150);

        // Handle Checkbox & Published At
        $data['is_published'] = $request->has('is_published');
        $data['is_highlight'] = $request->has('is_highlight');

        if ($data['is_published']) {
            $data['published_at'] = now();
        }

        // Handle Upload Cover Image (Langsung ngikutin default disk di .env)
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('articles/covers');
        }

        return Article::create($data);
    }

    public function updateArticle(Article $article, $request)
    {
        $data = $request->validated();

        // Handle Checkboxes
        $data['is_published'] = $request->has('is_published');
        $data['is_highlight'] = $request->has('is_highlight');

        // Update published_at jika status berubah
        if ($data['is_published'] && !$article->published_at) {
            $data['published_at'] = now();
        } elseif (!$data['is_published']) {
            $data['published_at'] = null;
        }

        // Handle Update Cover Image
        if ($request->hasFile('cover_image')) {
            // Hapus gambar lama jika ada
            if ($article->cover_image) {
                Storage::delete($article->cover_image);
            }
            // Upload gambar baru
            $data['cover_image'] = $request->file('cover_image')->store('articles/covers');
        }

        $article->update($data);

        return $article;
    }
}
