<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PhotographerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tagline',
        'headline',
        'sub_headline',
        'quote',
        'about_title',
        'about_journey',
        'about_philosophy',
        'philosophy_1_title',
        'philosophy_1_desc',
        'philosophy_2_title',
        'philosophy_2_desc',
        'philosophy_3_title',
        'philosophy_3_desc',
        'avatar',
        'location',
        'email',
        'phone',
        'instagram',
        'instagram_url',
    ];

    /**
     * Get the resolved public URL of the avatar.
     */
    public function getAvatarUrlAttribute(): ?string
    {
        if (!$this->avatar) {
            return null;
        }

        if (str_starts_with($this->avatar, 'http://') || str_starts_with($this->avatar, 'https://')) {
            if (str_contains($this->avatar, 'dashboard-jef.test')) {
                return str_replace('http://dashboard-jef.test', config('app.url'), $this->avatar);
            }
            return $this->avatar;
        }

        return url(Storage::url($this->avatar));
    }

    /**
     * Singleton accessor for the photographer profile.
     */
    public static function current(): self
    {
        return static::firstOrCreate([], [
            'name' => 'Jef Lee',
            'tagline' => 'Portrait & Documentary Photographer',
            'headline' => 'Telling honest stories through natural light and quiet moments.',
            'sub_headline' => 'A portrait and documentary photographer dedicated to capturing genuine human warmth, family milestones, and timeless atmosphere.',
            'quote' => 'Photography is more than capturing light — it is preserving life itself, pausing the fleeting smiles and quiet touches before they fade into memory.',
            'about_title' => 'Documenting the quiet cadence of ordinary life.',
            'about_journey' => "My journey in photography began not in a commercial studio, but on the quiet morning coastlines of Australia, carrying a single mechanical camera. I became fascinated with how fleeting ambient light turns everyday moments into enduring memories.\n\nOver the past several years, that fascination evolved into an intentional practice: photographing families, quiet portraits, artisan workshops, and unscripted daily life.",
            'about_philosophy' => 'My philosophy is grounded in minimal gear and maximum connection. Rather than directing rigid poses, I facilitate a relaxed, unhurried space where your natural laughter, spontaneous smiles, and tender glances can unfold organically under soft ambient light.',
            'philosophy_1_title' => 'Natural Ambient Light',
            'philosophy_1_desc' => 'Working strictly with natural morning glow and twilight to preserve the authentic mood and emotional warmth of the atmosphere.',
            'philosophy_2_title' => 'The Unrehearsed Moment',
            'philosophy_2_desc' => 'Avoiding rigid posing in favor of patient observation. Allowing genuine connection, laughter, and intimacy to unfold naturally.',
            'philosophy_3_title' => 'Archival Craftsmanship',
            'philosophy_3_desc' => 'Each photograph is individually graded with timeless, film-inspired tone curves suited for fine art print collections.',
            'avatar' => null,
            'location' => 'Australia / Kyoto, Japan',
            'email' => 'jef@example.com',
            'phone' => '+61 400 123 456',
            'instagram' => '@jeflee',
            'instagram_url' => 'https://instagram.com/jeflee',
        ]);
    }
}

