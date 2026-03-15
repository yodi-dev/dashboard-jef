<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    /**
     * Get list of published portfolios
     */
    public function index(Request $request)
    {
        // Hanya ambil yang sudah di-publish
        $query = Portfolio::where('is_published', true);

        // Kalau di URL ada ?highlight=true, ambil yang highlight aja (buat Landing Page)
        if ($request->boolean('highlight')) {
            $query->where('is_highlight', true);
        }

        // Urutkan dari yang terbaru di-publish
        $portfolios = $query->orderBy('published_at', 'desc')->get();

        // Format data biar URL gambar langsung siap pakai di front-end
        $portfolios->transform(function ($portfolio) {
            $portfolio->thumbnail_url = $portfolio->thumbnail ? url(Storage::url($portfolio->thumbnail)) : null;
            return $portfolio;
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar Portfolio berhasil diambil',
            'data'    => $portfolios
        ], 200);
    }

    /**
     * Get detail portfolio by slug
     */
    public function show($slug)
    {
        // Cari berdasarkan slug dan pastikan sudah di-publish
        $portfolio = Portfolio::where('slug', $slug)
            ->where('is_published', true)
            ->first();

        // Kalau nggak ketemu atau belum publish, balikin 404
        if (!$portfolio) {
            return response()->json([
                'success' => false,
                'message' => 'Portfolio tidak ditemukan atau belum dipublish'
            ], 404);
        }

        // Format URL untuk thumbnail
        $portfolio->thumbnail_url = $portfolio->thumbnail ? url(Storage::url($portfolio->thumbnail)) : null;

        // Format URL untuk gallery
        $galleryUrls = [];
        if (!empty($portfolio->gallery)) {
            foreach ($portfolio->gallery as $image) {
                $galleryUrls[] = url(Storage::url($image));
            }
        }
        $portfolio->gallery_urls = $galleryUrls;

        return response()->json([
            'success' => true,
            'message' => 'Detail Portfolio berhasil diambil',
            'data'    => $portfolio
        ], 200);
    }
}
