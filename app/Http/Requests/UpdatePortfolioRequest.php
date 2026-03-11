<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePortfolioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',

            'description' => 'nullable|string',

            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

            'gallery' => 'nullable|array',

            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

            'is_published' => 'boolean',

            'is_highlight' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title wajib diisi',
        ];
    }
}
