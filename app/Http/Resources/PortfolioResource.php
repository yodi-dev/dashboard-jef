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
            $url = $path;
        } else {
            $disk = config('filesystems.default', 'public');
            $url = Storage::disk($disk)->url($path);
        }

        if ($url && !str_starts_with($url, 'http://') && !str_starts_with($url, 'https://')) {
            $url = 'https://' . ltrim($url, '/');
        }

        if (!app()->runningInConsole() && (str_contains($url, 'localhost') || str_contains($url, '127.0.0.1'))) {
            $host = request()->getSchemeAndHttpHost();
            if (!str_contains($host, 'localhost') && !str_contains($host, '127.0.0.1')) {
                $url = preg_replace('#^https?://[^/]+#', $host, $url);
            }
        }

        return $url;
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
