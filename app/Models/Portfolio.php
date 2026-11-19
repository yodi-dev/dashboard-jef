<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Portfolio extends Model
{
    use SoftDeletes;

    public const CATEGORIES = [
        'Family',
        'Portrait',
        'Couple',
        'Newborn',
        'Work Documentary',
        'Animal',
        'Plant',
        'Sports',
        'Event',
        'Celebration',
        'Travel',
    ];

    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'thumbnail',
        'gallery',
        'is_published',
        'published_at',
        'is_highlight',
    ];

    protected $casts = [
        'gallery' => 'array',
        'is_published' => 'boolean',
        'is_highlight' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($portfolio) {
            if (! $portfolio->slug) {
                $portfolio->slug = Str::slug($portfolio->title);
            }
        });
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        if (! $this->thumbnail) {
            return null;
        }

        if (Str::startsWith($this->thumbnail, ['http://', 'https://'])) {
            return $this->thumbnail;
        }

        $url = Storage::url($this->thumbnail);
        if ($url && ! Str::startsWith($url, ['http://', 'https://'])) {
            $url = 'https://' . ltrim($url, '/');
        }

        return $url;
    }

    public function getGalleryUrlsAttribute(): array
    {
        if (empty($this->gallery) || ! is_array($this->gallery)) {
            return [];
        }

        return array_map(function ($path) {
            if (Str::startsWith($path, ['http://', 'https://'])) {
                return $path;
            }
            $url = Storage::url($path);
            return ($url && ! Str::startsWith($url, ['http://', 'https://'])) ? 'https://' . ltrim($url, '/') : $url;
        }, $this->gallery);
    }
}
