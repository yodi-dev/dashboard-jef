<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePhotographerProfileRequest;
use App\Models\PhotographerProfile;
use Illuminate\Support\Facades\Storage;

class PhotographerProfileController extends Controller
{
    public function edit()
    {
        $profile = PhotographerProfile::current();

        return view('admin.photographer_profile.edit', compact('profile'));
    }

    public function update(UpdatePhotographerProfileRequest $request)
    {
        $validated = $request->validated();

        $profile = PhotographerProfile::current();
        $disk = config('filesystems.default', 'public');

        // Handle Avatar Removal
        if ($request->boolean('remove_avatar')) {
            if ($profile->avatar && !str_starts_with($profile->avatar, 'http') && Storage::disk($disk)->exists($profile->avatar)) {
                Storage::disk($disk)->delete($profile->avatar);
            }
            $validated['avatar'] = null;
        }

        // Handle New Avatar Upload
        if ($request->hasFile('avatar')) {
            if ($profile->avatar && !str_starts_with($profile->avatar, 'http') && Storage::disk($disk)->exists($profile->avatar)) {
                Storage::disk($disk)->delete($profile->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('profiles', $disk);
        }

        // Handle Hero Banner Image Removal
        if ($request->boolean('remove_hero_image')) {
            if ($profile->hero_image && !str_starts_with($profile->hero_image, 'http') && Storage::disk($disk)->exists($profile->hero_image)) {
                Storage::disk($disk)->delete($profile->hero_image);
            }
            $validated['hero_image'] = null;
        }

        // Handle New Hero Banner Image Upload
        if ($request->hasFile('hero_image')) {
            if ($profile->hero_image && !str_starts_with($profile->hero_image, 'http') && Storage::disk($disk)->exists($profile->hero_image)) {
                Storage::disk($disk)->delete($profile->hero_image);
            }
            $validated['hero_image'] = $request->file('hero_image')->store('heroes', $disk);
        }

        $profile->update($validated);

        return redirect()->route('admin.photographer-profile.edit')
            ->with('success', 'Photographer public profile updated successfully!');
    }
}

