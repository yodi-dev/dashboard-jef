<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PhotographerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotographerProfileController extends Controller
{
    public function edit()
    {
        $profile = PhotographerProfile::current();

        return view('admin.photographer_profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'tagline'             => 'nullable|string|max:255',
            'headline'            => 'nullable|string|max:255',
            'sub_headline'        => 'nullable|string',
            'quote'               => 'nullable|string',
            'about_title'         => 'nullable|string|max:255',
            'about_journey'       => 'nullable|string',
            'about_philosophy'    => 'nullable|string',
            'philosophy_1_title'  => 'nullable|string|max:255',
            'philosophy_1_desc'   => 'nullable|string',
            'philosophy_2_title'  => 'nullable|string|max:255',
            'philosophy_2_desc'   => 'nullable|string',
            'philosophy_3_title'  => 'nullable|string|max:255',
            'philosophy_3_desc'   => 'nullable|string',
            'avatar'              => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'remove_avatar'       => 'nullable|boolean',
            'location'            => 'nullable|string|max:255',
            'email'               => 'nullable|email|max:255',
            'phone'               => 'nullable|string|max:255',
            'instagram'           => 'nullable|string|max:255',
            'instagram_url'       => 'nullable|url|max:255',
        ]);

        $profile = PhotographerProfile::current();

        // Handle Avatar Removal
        if ($request->boolean('remove_avatar')) {
            if ($profile->avatar && !str_starts_with($profile->avatar, 'http') && Storage::disk('public')->exists($profile->avatar)) {
                Storage::disk('public')->delete($profile->avatar);
            }
            $validated['avatar'] = null;
        }

        // Handle New Avatar Upload
        if ($request->hasFile('avatar')) {
            if ($profile->avatar && !str_starts_with($profile->avatar, 'http') && Storage::disk('public')->exists($profile->avatar)) {
                Storage::disk('public')->delete($profile->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('profiles', 'public');
        }

        $profile->update($validated);

        return redirect()->route('admin.photographer-profile.edit')
            ->with('success', 'Profil publik fotografer berhasil diperbarui!');
    }
}

