<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PortfolioResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'slug'         => $this->slug,
            'category'     => $this->category ?? 'Portrait',
            'description'  => $this->description,
            'thumbnail'    => $this->thumbnail ? url(Storage::url($this->thumbnail)) : null,
            'gallery'      => is_array($this->gallery)
                                ? array_map(fn($img) => url(Storage::url($img)), $this->gallery)
                                : [],
            'is_highlight' => (bool) $this->is_highlight,
            'created_at'   => $this->created_at->format('d M Y'),
        ];
    }
}
