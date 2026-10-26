<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PortfolioResource extends JsonResource
{
    private function resolveUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            if (str_contains($path, 'dashboard-jef.test')) {
                return str_replace('http://dashboard-jef.test', config('app.url'), $path);
            }
            return $path;
        }
        return url(Storage::url($path));
    }

    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'slug'         => $this->slug,
            'category'     => $this->category ?? 'Portrait',
            'description'  => $this->description,
            'thumbnail'    => $this->resolveUrl($this->thumbnail),
            'gallery'      => is_array($this->gallery)
                                ? array_map(fn($img) => $this->resolveUrl($img), $this->gallery)
                                : [],
            'is_highlight' => (bool) $this->is_highlight,
            'created_at'   => $this->created_at->format('d M Y'),
        ];
    }
}
