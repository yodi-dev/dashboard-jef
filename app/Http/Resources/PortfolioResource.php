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
            'thumbnail'    => $this->thumbnail ? url(Storage::url($this->thumbnail)) : null,
            'is_highlight' => (bool) $this->is_highlight,
            'created_at'   => $this->created_at->format('d M Y'),
        ];
    }
}
