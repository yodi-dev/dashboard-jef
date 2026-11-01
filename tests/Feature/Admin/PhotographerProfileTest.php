<?php

namespace Tests\Feature\Admin;

use App\Models\PhotographerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PhotographerProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_photographer_profile_edit()
    {
        $response = $this->get(route('admin.photographer-profile.edit'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_photographer_profile_edit()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.photographer-profile.edit'));
        $response->assertStatus(200);
        $response->assertSee('Pengaturan Profil Publik Fotografer');
    }

    public function test_authenticated_user_can_update_photographer_profile()
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('jef-new-avatar.jpg', 600, 600);

        $payload = [
            'name'               => 'Jef Lee Updated',
            'tagline'            => 'Artisan Film Photographer',
            'headline'           => 'New Quiet Moments Headline',
            'sub_headline'       => 'Updated sub headline test',
            'quote'              => 'Updated quote test',
            'about_title'        => 'Updated About Title',
            'about_journey'      => 'Updated journey narrative',
            'about_philosophy'   => 'Updated philosophy narrative',
            'philosophy_1_title' => 'Updated Light',
            'philosophy_1_desc'  => 'Updated Light Description',
            'philosophy_2_title' => 'Updated Moment',
            'philosophy_2_desc'  => 'Updated Moment Description',
            'philosophy_3_title' => 'Updated Quality',
            'philosophy_3_desc'  => 'Updated Quality Description',
            'location'           => 'Kyoto, Japan',
            'email'              => 'jef.updated@example.com',
            'phone'              => '+81 90 1234 5678',
            'instagram'          => '@jeflee.studio',
            'instagram_url'      => 'https://instagram.com/jeflee.studio',
            'avatar'             => $file,
        ];

        $response = $this->actingAs($user)->put(route('admin.photographer-profile.update'), $payload);

        $response->assertRedirect(route('admin.photographer-profile.edit'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('photographer_profiles', [
            'name'      => 'Jef Lee Updated',
            'email'     => 'jef.updated@example.com',
            'instagram' => '@jeflee.studio',
            'location'  => 'Kyoto, Japan',
        ]);

        $profile = PhotographerProfile::current();
        $this->assertNotNull($profile->avatar);
        Storage::disk('public')->assertExists($profile->avatar);
    }

    public function test_public_api_returns_photographer_profile()
    {
        $response = $this->getJson('/api/profile');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'tagline',
                'headline',
                'sub_headline',
                'quote',
                'about_title',
                'about_journey',
                'about_philosophy',
                'philosophies' => [],
                'avatar',
                'location',
                'email',
                'phone',
                'instagram',
                'instagram_url',
            ],
        ]);
    }
}

