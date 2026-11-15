<?php

namespace Tests\Feature\Api;

use App\Models\Article;
use App\Models\Portfolio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PublicApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_can_get_profile(): void
    {
        $response = $this->getJson('/api/profile');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'name',
                'tagline',
                'headline',
            ],
        ]);
    }

    public function test_public_can_list_published_portfolios_only(): void
    {
        Portfolio::create([
            'title' => 'Published Work',
            'category' => 'Portrait',
            'is_published' => true,
            'published_at' => now(),
        ]);

        Portfolio::create([
            'title' => 'Draft Work',
            'category' => 'Portrait',
            'is_published' => false,
        ]);

        $response = $this->getJson('/api/portfolios');
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['title' => 'Published Work']);
        $response->assertJsonMissing(['title' => 'Draft Work']);
    }

    public function test_public_can_view_single_published_portfolio_by_slug(): void
    {
        $portfolio = Portfolio::create([
            'title' => 'Coastal Light Moments',
            'category' => 'Portrait',
            'description' => 'Detailed session narrative',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $response = $this->getJson('/api/portfolios/' . $portfolio->slug);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'title' => 'Coastal Light Moments',
            'slug'  => $portfolio->slug,
        ]);
    }

    public function test_public_can_list_published_articles_only(): void
    {
        Article::create([
            'title' => 'The Art of Natural Light',
            'content' => 'Article content about natural morning light.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        Article::create([
            'title' => 'Draft Story',
            'content' => 'Hidden draft story.',
            'is_published' => false,
        ]);

        $response = $this->getJson('/api/articles');
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['title' => 'The Art of Natural Light']);
        $response->assertJsonMissing(['title' => 'Draft Story']);
    }

    public function test_public_can_submit_booking_reservation(): void
    {
        Mail::fake();

        $payload = [
            'name'         => 'Elena Rostova',
            'email'        => 'elena@example.com',
            'phone'        => '+6281234567890',
            'package'      => 'Portrait Session',
            'location'     => 'Bali Coastal Studio',
            'booking_date' => now()->addDays(7)->format('Y-m-d H:i:s'),
            'message'      => 'Looking forward to our photoshoot session.',
        ];

        $response = $this->postJson('/api/bookings', $payload);
        $response->assertStatus(201);
        $response->assertJsonFragment([
            'name'    => 'Elena Rostova',
            'package' => 'Portrait Session',
            'status'  => 'pending',
        ]);

        $this->assertDatabaseHas('bookings', [
            'email'   => 'elena@example.com',
            'package' => 'Portrait Session',
        ]);
    }
}
