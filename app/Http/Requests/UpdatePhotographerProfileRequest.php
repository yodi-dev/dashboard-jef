<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePhotographerProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
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
        ];
    }
}
