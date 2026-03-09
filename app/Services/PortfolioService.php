<?php

namespace App\Services;

use App\Models\Portfolio;
use Illuminate\Support\Arr;

class PortfolioService
{
    public function createPortfolio($request)
    {
        // 1. Ambil data yang valid
        $validatedData = $request->validated();
        $data = Arr::except($validatedData, ['thumbnail', 'gallery']);

        // 2. Handle Checkbox & Published At
        $data['is_published'] = $request->has('is_published');
        $data['is_highlight'] = $request->has('is_highlight');

        if ($data['is_published']) {
            $data['published_at'] = now();
        }

        // 3. Handle Upload Thumbnail
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('portfolios/thumbnails', 'public');
        }

        // 4. Handle Upload Gallery
        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = $image->store('portfolios/galleries', 'public');
            }
            $data['gallery'] = $galleryPaths;
        }

        // 5. Simpan data
        return Portfolio::create($data);
    }
}
