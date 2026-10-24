<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
}
