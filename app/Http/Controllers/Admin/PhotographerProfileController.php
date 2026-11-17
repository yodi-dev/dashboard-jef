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

        $highlightPortfolios = \App\Models\Portfolio::where('is_published', true)
            ->where('is_highlight', true)
            ->latest()
            ->get(['id', 'title', 'slug', 'thumbnail']);

        return view('admin.photographer_profile.edit', compact('profile', 'highlightPortfolios'));
    }

    public function update(UpdatePhotographerProfileRequest $request)
    {
        try {
            $validated = $request->validated();

            $profile = PhotographerProfile::current();
            $disk = config('filesystems.default', 'public');

            // Handle Avatar
            unset($validated['avatar']);
            if ($request->boolean('remove_avatar')) {
                if ($profile->avatar && !str_starts_with($profile->avatar, 'http') && Storage::disk($disk)->exists($profile->avatar)) {
                    Storage::disk($disk)->delete($profile->avatar);
                }
                $validated['avatar'] = null;
            } elseif ($request->hasFile('avatar')) {
                if ($profile->avatar && !str_starts_with($profile->avatar, 'http') && Storage::disk($disk)->exists($profile->avatar)) {
                    Storage::disk($disk)->delete($profile->avatar);
                }
                $validated['avatar'] = $request->file('avatar')->store('profiles', $disk);
            }

            // Handle Hero Banner Image
            unset($validated['hero_image']);
            if ($request->boolean('remove_hero_image')) {
                if ($profile->hero_image && !str_starts_with($profile->hero_image, 'http') && Storage::disk($disk)->exists($profile->hero_image)) {
                    Storage::disk($disk)->delete($profile->hero_image);
                }
                $validated['hero_image'] = null;
            } elseif ($request->hasFile('hero_image')) {
                if ($profile->hero_image && !str_starts_with($profile->hero_image, 'http') && Storage::disk($disk)->exists($profile->hero_image)) {
                    Storage::disk($disk)->delete($profile->hero_image);
                }
                $validated['hero_image'] = $request->file('hero_image')->store('heroes', $disk);
            }

            unset($validated['remove_avatar'], $validated['remove_hero_image']);

            if (empty($validated['hero_portfolio_id'])) {
                $validated['hero_portfolio_id'] = null;
            }

            $profile->update($validated);

            return redirect()->route('admin.photographer-profile.edit')
                ->with('success', 'Photographer public profile updated successfully!');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Profile Update Failed: ' . $e->getMessage(), [
                'exception' => $e,
            ]);

            return redirect()->route('admin.photographer-profile.edit')
                ->withInput()
                ->withErrors(['error' => 'Failed to update profile: ' . $e->getMessage()]);
        }
    }
}

