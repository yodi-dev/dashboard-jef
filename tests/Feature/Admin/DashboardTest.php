<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('redirects unauthenticated users to login', function () {
    $this->get('/admin/dashboard')
        ->assertRedirect('/login');
});

it('allows authenticated users to access the dashboard', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/admin/dashboard')
        ->assertOk()
        ->assertViewIs('dashboard');
});
