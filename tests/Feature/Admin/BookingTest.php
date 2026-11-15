<?php

namespace Tests\Feature\Admin;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_authenticated_user_can_view_bookings_index(): void
    {
        Booking::create([
            'name' => 'Alice Johnson',
            'email' => 'alice@example.com',
            'phone' => '+61412345678',
            'package' => 'Portrait Session',
            'location' => 'Sydney Beach',
            'booking_date' => now()->addDays(7),
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->user)->get(route('admin.bookings.index'));

        $response->assertOk()
            ->assertViewIs('admin.bookings.index')
            ->assertSee('Alice Johnson');
    }

    public function test_authenticated_user_can_view_booking_detail(): void
    {
        $booking = Booking::create([
            'name' => 'Bob Smith',
            'email' => 'bob@example.com',
            'phone' => '+61498765432',
            'package' => 'Family & Newborn',
            'location' => 'Studio',
            'booking_date' => now()->addDays(5),
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->user)->get(route('admin.bookings.show', $booking));
        $response->assertRedirect(route('admin.bookings.edit', $booking));

        $editResponse = $this->actingAs($this->user)->get(route('admin.bookings.edit', $booking));
        $editResponse->assertOk()
            ->assertViewIs('admin.bookings.edit')
            ->assertSee('Bob Smith');
    }

    public function test_authenticated_user_can_update_booking_status(): void
    {
        $booking = Booking::create([
            'name' => 'Carol Danvers',
            'email' => 'carol@example.com',
            'phone' => '+61400112233',
            'package' => 'Couple Session',
            'location' => 'Harbour',
            'booking_date' => now()->addDays(10),
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->user)->put(route('admin.bookings.update', $booking), [
            'status' => 'confirmed',
            'admin_notes' => 'Deposit received via direct transfer.',
        ]);

        $response->assertRedirect(route('admin.bookings.index'));
        $booking->refresh();
        $this->assertEquals('confirmed', $booking->status);
        $this->assertEquals('Deposit received via direct transfer.', $booking->admin_notes);
    }

    public function test_authenticated_user_can_soft_delete_booking(): void
    {
        $booking = Booking::create([
            'name' => 'Dave Miller',
            'email' => 'dave@example.com',
            'phone' => '+61455667788',
            'package' => 'Custom Session',
            'location' => 'Outdoor',
            'booking_date' => now()->addDays(3),
            'status' => 'canceled',
        ]);

        $response = $this->actingAs($this->user)->delete(route('admin.bookings.destroy', $booking));

        $response->assertRedirect(route('admin.bookings.index'));
        $this->assertSoftDeleted('bookings', ['id' => $booking->id]);
    }
}
