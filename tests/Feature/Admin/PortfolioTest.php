<?php

namespace Tests\Feature\Admin;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Storage::fake('public');
    }

    public function test_authenticated_user_can_view_portfolio_index(): void
    {
        Portfolio::create([
            'title' => 'Family Gathering',
            'category' => 'Family',
            'is_published' => true,
        ]);

        $response = $this->actingAs($this->user)->get(route('admin.portfolios.index'));

        $response->assertOk()
            ->assertViewIs('admin.portfolios.index')
            ->assertSee('Family Gathering');
    }

    public function test_authenticated_user_can_create_portfolio(): void
    {
        $thumbnail = UploadedFile::fake()->image('thumb.jpg', 800, 600);
        $galleryPhoto = UploadedFile::fake()->image('gallery1.jpg', 800, 600);

        $response = $this->actingAs($this->user)->post(route('admin.portfolios.store'), [
            'title' => 'Sydney Sunset Session',
            'category' => 'Portrait',
            'description' => 'A calm natural light portrait session.',
            'thumbnail' => $thumbnail,
            'gallery' => [$galleryPhoto],
            'is_published' => '1',
            'is_highlight' => '1',
        ]);

        $response->assertRedirect(route('admin.portfolios.index'));
        $this->assertDatabaseHas('portfolios', [
            'title' => 'Sydney Sunset Session',
            'category' => 'Portrait',
            'is_published' => 1,
            'is_highlight' => 1,
        ]);
    }

    public function test_updating_portfolio_appends_new_gallery_photos_safely(): void
    {
        $portfolio = Portfolio::create([
            'title' => 'Original Series',
            'category' => 'Portrait',
            'gallery' => ['portfolios/galleries/photo1.jpg', 'portfolios/galleries/photo2.jpg'],
            'is_published' => true,
        ]);

        $newPhoto = UploadedFile::fake()->image('newphoto.jpg', 800, 600);

        $response = $this->actingAs($this->user)->put(route('admin.portfolios.update', $portfolio), [
            'title' => 'Updated Series Title',
            'category' => 'Portrait',
            'gallery' => [$newPhoto],
            'is_published' => '1',
        ]);

        $response->assertRedirect(route('admin.portfolios.index'));
        $portfolio->refresh();

        // Must now contain 3 photos (2 original + 1 new), not 1!
        $this->assertCount(3, $portfolio->gallery);
        $this->assertEquals('Updated Series Title', $portfolio->title);
    }

    public function test_authenticated_user_can_delete_individual_gallery_photo(): void
    {
        Storage::disk('public')->put('portfolios/galleries/to_remove.jpg', 'fake-image-content');

        $portfolio = Portfolio::create([
            'title' => 'Gallery Delete Test',
            'category' => 'Portrait',
            'gallery' => ['portfolios/galleries/keep.jpg', 'portfolios/galleries/to_remove.jpg'],
            'is_published' => true,
        ]);

        $response = $this->actingAs($this->user)->delete(route('admin.portfolios.destroyGalleryImage', $portfolio), [
            'image' => 'portfolios/galleries/to_remove.jpg',
        ]);

        $response->assertRedirect();
        $portfolio->refresh();

        $this->assertCount(1, $portfolio->gallery);
        $this->assertEquals(['portfolios/galleries/keep.jpg'], $portfolio->gallery);
        Storage::disk('public')->assertMissing('portfolios/galleries/to_remove.jpg');
    }

    public function test_authenticated_user_can_toggle_portfolio_status(): void
    {
        $portfolio = Portfolio::create([
            'title' => 'Toggle Test',
            'category' => 'Portrait',
            'is_published' => false,
            'is_highlight' => false,
        ]);

        // Toggle highlight automatically publishes
        $this->actingAs($this->user)->patch(route('admin.portfolios.toggle', $portfolio), [
            'field' => 'is_highlight',
        ]);

        $portfolio->refresh();
        $this->assertTrue($portfolio->is_highlight);
        $this->assertTrue($portfolio->is_published);
        $this->assertNotNull($portfolio->published_at);
    }

    public function test_authenticated_user_can_soft_delete_portfolio(): void
    {
        $portfolio = Portfolio::create([
            'title' => 'Delete Target',
            'category' => 'Portrait',
            'is_published' => true,
        ]);

        $response = $this->actingAs($this->user)
            ->from(route('admin.portfolios.index'))
            ->delete(route('admin.portfolios.destroy', $portfolio));

        $response->assertRedirect(route('admin.portfolios.index'));
        $this->assertSoftDeleted('portfolios', ['id' => $portfolio->id]);
    }

    public function test_user_can_filter_and_search_portfolios(): void
    {
        Portfolio::create([
            'title' => 'Kyoto Street Story',
            'category' => 'Street',
            'is_published' => true,
        ]);
        Portfolio::create([
            'title' => 'Sydney Coast Editorial',
            'category' => 'Portrait',
            'is_published' => false,
        ]);

        // Search test
        $response = $this->actingAs($this->user)->get(route('admin.portfolios.index', ['search' => 'Kyoto']));
        $response->assertOk()
            ->assertSee('Kyoto Street Story')
            ->assertDontSee('Sydney Coast Editorial');

        // Status filter test
        $response = $this->actingAs($this->user)->get(route('admin.portfolios.index', ['status' => 'draft']));
        $response->assertOk()
            ->assertSee('Sydney Coast Editorial')
            ->assertDontSee('Kyoto Street Story');
    }

    public function test_user_can_toggle_portfolio_via_ajax_json(): void
    {
        $portfolio = Portfolio::create([
            'title' => 'Ajax Toggle Test',
            'category' => 'Portrait',
            'is_published' => false,
            'is_highlight' => false,
        ]);

        $response = $this->actingAs($this->user)
            ->withHeaders(['Accept' => 'application/json'])
            ->patchJson(route('admin.portfolios.toggle', $portfolio), [
                'field' => 'is_published',
            ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'is_published' => true,
            ]);

        $this->assertTrue($portfolio->fresh()->is_published);
    }
}
