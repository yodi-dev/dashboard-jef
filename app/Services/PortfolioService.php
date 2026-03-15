<?php

namespace App\Services;

use App\Models\Portfolio;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class PortfolioService
{
    /**
     * Handle pembuatan Portfolio baru (Create)
     */
    public function createPortfolio($request)
    {
        $validatedData = $request->validated();
        $data = Arr::except($validatedData, ['thumbnail', 'gallery']);

        // Handle Checkbox & Published At
        $data['is_published'] = $request->has('is_published');
        $data['is_highlight'] = $request->has('is_highlight');

        if ($data['is_published']) {
            $data['published_at'] = now();
        }

        // Handle Upload Thumbnail
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('portfolios/thumbnails');
        }

        // Handle Upload Gallery
        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = $image->store('portfolios/galleries');
            }
            $data['gallery'] = $galleryPaths;
        }

        return Portfolio::create($data);
    }

    /**
     * Handle pembaruan Portfolio (Update)
     */
    public function updatePortfolio(Portfolio $portfolio, $request)
    {
        $validatedData = $request->validated();

        // Keluarkan data gambar dari array utama biar nggak nimpa data lama jadi kosong
        $data = Arr::except($validatedData, ['thumbnail', 'gallery']);

        // Handle Checkboxes
        $data['is_published'] = $request->has('is_published');
        $data['is_highlight'] = $request->has('is_highlight');

        // Update published_at jika status berubah
        if ($data['is_published'] && !$portfolio->published_at) {
            $data['published_at'] = now();
        } elseif (!$data['is_published']) {
            $data['published_at'] = null;
        }

        // Handle Update Thumbnail
        if ($request->hasFile('thumbnail')) {
            // Hapus gambar lama fisik di storage jika ada
            if ($portfolio->thumbnail) {
                Storage::delete($portfolio->thumbnail);
            }
            // Upload gambar baru dan masukkan path-nya ke array $data
            $data['thumbnail'] = $request->file('thumbnail')->store('portfolios/thumbnails');
        }

        // Handle Update Gallery
        if ($request->hasFile('gallery')) {
            // Hapus gambar gallery lama secara fisik jika ada
            if (!empty($portfolio->gallery)) {
                foreach ($portfolio->gallery as $oldImage) {
                    Storage::delete($oldImage);
                }
            }

            // Upload gambar gallery baru
            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = $image->store('portfolios/galleries');
            }
            $data['gallery'] = $galleryPaths;
        }

        // Eksekusi update ke database
        $portfolio->update($data);

        return $portfolio;
    }
}
