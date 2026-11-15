<?php

namespace Tests\Feature\Admin;

use App\Models\Article;
use App\Models\Booking;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrashTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_trash_page(): void
    {
        $user = User::factory()->create();

        $portfolio = Portfolio::create([
            'title' => 'Trashed Work',
            'category' => 'Portrait',
            'description' => 'Test description',
        ]);
        $portfolio->delete();

        $response = $this->actingAs($user)->get(route('admin.trash'));
        $response->assertStatus(200);
        $response->assertSee('Recycle Bin');
        $response->assertSee('Trashed Work');
    }

    public function test_authenticated_user_can_restore_trashed_portfolio(): void
    {
        $user = User::factory()->create();

        $portfolio = Portfolio::create([
            'title' => 'Trashed Work to Restore',
            'category' => 'Portrait',
        ]);
        $portfolio->delete();

        $this->assertSoftDeleted('portfolios', ['id' => $portfolio->id]);

        $response = $this->actingAs($user)
            ->from(route('admin.trash'))
            ->post(route('admin.portfolios.restore', $portfolio->id));
        $response->assertRedirect(route('admin.trash'));

        $this->assertNotSoftDeleted('portfolios', ['id' => $portfolio->id]);
    }

    public function test_authenticated_user_can_force_delete_portfolio(): void
    {
        $user = User::factory()->create();

        $portfolio = Portfolio::create([
            'title' => 'Trashed Work to Permanently Delete',
            'category' => 'Portrait',
        ]);
        $portfolio->delete();

        $response = $this->actingAs($user)
            ->from(route('admin.trash'))
            ->delete(route('admin.portfolios.forceDestroy', $portfolio->id));
        $response->assertRedirect(route('admin.trash'));

        $this->assertDatabaseMissing('portfolios', ['id' => $portfolio->id]);
    }

    public function test_authenticated_user_can_restore_trashed_article(): void
    {
        $user = User::factory()->create();

        $article = Article::create([
            'title' => 'Trashed Story',
            'content' => 'Content here',
        ]);
        $article->delete();

        $this->assertSoftDeleted('articles', ['id' => $article->id]);

        $response = $this->actingAs($user)
            ->from(route('admin.trash'))
            ->post(route('admin.articles.restore', $article->id));
        $response->assertRedirect(route('admin.trash'));

        $this->assertNotSoftDeleted('articles', ['id' => $article->id]);
    }

    public function test_authenticated_user_can_force_delete_article(): void
    {
        $user = User::factory()->create();

        $article = Article::create([
            'title' => 'Trashed Story to Destroy',
            'content' => 'Content here',
        ]);
        $article->delete();

        $response = $this->actingAs($user)
            ->from(route('admin.trash'))
            ->delete(route('admin.articles.forceDestroy', $article->id));
        $response->assertRedirect(route('admin.trash'));

        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }

    public function test_authenticated_user_can_restore_trashed_booking(): void
    {
        $user = User::factory()->create();

        $booking = Booking::create([
            'name' => 'Alice Walker',
            'email' => 'alice@example.com',
            'phone' => '08123456789',
            'package' => 'Portrait Session',
            'location' => 'Tokyo Studio',
            'booking_date' => now()->addDays(5),
            'status' => 'pending',
        ]);
        $booking->delete();

        $this->assertSoftDeleted('bookings', ['id' => $booking->id]);

        $response = $this->actingAs($user)
            ->from(route('admin.trash'))
            ->post(route('admin.bookings.restore', $booking->id));
        $response->assertRedirect(route('admin.trash'));

        $this->assertNotSoftDeleted('bookings', ['id' => $booking->id]);
    }

    public function test_authenticated_user_can_force_delete_booking(): void
    {
        $user = User::factory()->create();

        $booking = Booking::create([
            'name' => 'Bob Builder',
            'email' => 'bob@example.com',
            'phone' => '08123456789',
            'package' => 'Family Session',
            'location' => 'Kyoto Garden',
            'booking_date' => now()->addDays(3),
            'status' => 'pending',
        ]);
        $booking->delete();

        $response = $this->actingAs($user)
            ->from(route('admin.trash'))
            ->delete(route('admin.bookings.forceDestroy', $booking->id));
        $response->assertRedirect(route('admin.trash'));

        $this->assertDatabaseMissing('bookings', ['id' => $booking->id]);
    }
}
