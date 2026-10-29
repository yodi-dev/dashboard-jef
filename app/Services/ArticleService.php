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

        // Auto generate excerpt dari konten jika excerpt kosong
        if (empty($data['excerpt'])) {
            $data['excerpt'] = Str::limit(strip_tags($data['content']), 150);
        }

        // Handle Checkbox & Published At
        $data['is_published'] = $request->has('is_published');
        $data['is_highlight'] = $request->has('is_highlight');

        if ($data['is_published']) {
            $data['published_at'] = now();
        }

        // Handle Upload Cover Image (Langsung mengikuti default disk di .env)
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('articles/covers');
        }

        return Article::create($data);
    }

    public function updateArticle(Article $article, $request)
    {
        $data = $request->validated();

        // Auto generate excerpt jika kosong
        if (empty($data['excerpt']) && !empty($data['content'])) {
            $data['excerpt'] = Str::limit(strip_tags($data['content']), 150);
        }

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
            // Hapus gambar lama fisik di storage jika ada dan bukan link eksternal
            if ($article->cover_image && ! Str::startsWith($article->cover_image, ['http://', 'https://'])) {
                Storage::delete($article->cover_image);
            }
            // Upload gambar baru
            $data['cover_image'] = $request->file('cover_image')->store('articles/covers');
        }

        $article->update($data);

        return $article;
    }
}
