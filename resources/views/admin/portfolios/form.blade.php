<div class="space-y-6">

    {{-- Title --}}
    <div>
        <label for="title" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
            Title <span class="text-red-500">*</span>
        </label>
        <input type="text" id="title" name="title" value="{{ old('title', $portfolio->title ?? '') }}" required
            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 transition duration-150">

        @error('title')
            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Category / Theme --}}
    <div>
        <label for="category" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
            Category / Theme <span class="text-red-500">*</span>
        </label>
        <select id="category" name="category" required
            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 transition duration-150">
            @foreach(\App\Models\Portfolio::CATEGORIES as $cat)
                <option value="{{ $cat }}" {{ old('category', $portfolio->category ?? 'Portrait') === $cat ? 'selected' : '' }}>
                    {{ $cat }}
                </option>
            @endforeach
        </select>

        @error('category')
            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Description --}}
    <div>
        <label for="description" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
            Description
        </label>
        <textarea id="description" name="description" rows="4"
            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 transition duration-150">{{ old('description', $portfolio->description ?? '') }}</textarea>

        @error('description')
            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Grid for Upload Files --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Thumbnail --}}
        <div x-data="{ preview: null }">
            <label for="thumbnail" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                Thumbnail <span class="text-xs text-zinc-500">(Formats: JPG, PNG, WEBP)</span>
            </label>

            {{-- LIVE CLIENT PREVIEW --}}
            <div x-show="preview" class="mb-3">
                <p class="text-xs text-zinc-700 dark:text-zinc-300 font-medium mb-1">New Thumbnail Selected (Preview):</p>
                <img :src="preview" alt="New Thumbnail Preview"
                    class="h-32 object-cover rounded-md border-2 border-zinc-800 dark:border-zinc-200 shadow-sm">
            </div>

            {{-- OLD IMAGE PREVIEW --}}
            @if (isset($portfolio) && $portfolio->thumbnail_url)
                <div x-show="!preview" class="mb-3">
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Current Thumbnail:</p>
                    <img src="{{ $portfolio->thumbnail_url }}" alt="Thumbnail"
                        class="h-32 object-cover rounded-md border border-stone-300 dark:border-zinc-700">
                </div>
            @endif

            <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
                class="w-full px-3 py-2 border rounded-lg bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-stone-100 file:text-zinc-800 hover:file:bg-stone-200 dark:file:bg-zinc-800 dark:file:text-zinc-200 transition duration-150">

            @error('thumbnail')
                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Gallery (Multiple) --}}
        <div x-data="{ count: 0 }">
            <label for="gallery" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                Gallery <span class="text-xs text-zinc-500">(Select multiple images to add to gallery)</span>
            </label>

            {{-- OLD IMAGE PREVIEW --}}
            @if (isset($portfolio) && !empty($portfolio->gallery) && is_array($portfolio->gallery))
                <div class="mb-3">
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Current Gallery ({{ count($portfolio->gallery) }} photos):</p>
                    <div class="flex flex-wrap gap-2.5">
                        @foreach ($portfolio->gallery as $idx => $rawPath)
                            @php
                                $displayUrl = \Illuminate\Support\Str::startsWith($rawPath, ['http://', 'https://']) ? $rawPath : \Illuminate\Support\Facades\Storage::url($rawPath);
                            @endphp
                            <div class="relative group/photo inline-block">
                                <img src="{{ $displayUrl }}" alt="Gallery photo {{ $idx + 1 }}"
                                    class="h-16 w-16 object-cover rounded-md border border-stone-300 dark:border-zinc-700">
                                
                                <button type="button"
                                    onclick="if(confirm('Are you sure you want to delete this photo from the gallery?')) { document.getElementById('delete-gallery-form-{{ $idx }}').submit(); }"
                                    class="absolute -top-1.5 -right-1.5 bg-red-600 hover:bg-red-700 text-white rounded-full p-1 shadow transition-transform opacity-90 group-hover/photo:opacity-100"
                                    title="Delete photo">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <input type="file" id="gallery" name="gallery[]" multiple accept="image/*"
                @change="count = $event.target.files.length"
                class="w-full px-3 py-2 border rounded-lg bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-stone-100 file:text-zinc-800 hover:file:bg-stone-200 dark:file:bg-zinc-800 dark:file:text-zinc-200 transition duration-150">
            <p x-show="count > 0" class="mt-1 text-xs text-zinc-700 dark:text-zinc-300 font-medium">
                <span x-text="count"></span> new photo(s) selected to add.
            </p>

            @error('gallery')
                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
            @error('gallery.*')
                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

    </div>

    {{-- Checkboxes for Status (Published & Highlight) --}}
    <div class="flex flex-col sm:flex-row sm:space-x-8 space-y-3 sm:space-y-0 pt-2">

        {{-- Is Published --}}
        <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_published" value="1"
                class="w-5 h-5 rounded border-stone-300 text-zinc-900 shadow-sm focus:border-zinc-500 focus:ring focus:ring-zinc-400 focus:ring-opacity-50 dark:bg-zinc-900 dark:border-zinc-700"
                {{ old('is_published', $portfolio->is_published ?? false) ? 'checked' : '' }}>
            <span class="ml-2 text-sm text-zinc-700 dark:text-zinc-300 font-medium">Publish Portfolio</span>
        </label>

        {{-- Is Highlight --}}
        <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_highlight" value="1"
                class="w-5 h-5 rounded border-stone-300 text-zinc-900 shadow-sm focus:border-zinc-500 focus:ring focus:ring-zinc-400 focus:ring-opacity-50 dark:bg-zinc-900 dark:border-zinc-700"
                {{ old('is_highlight', $portfolio->is_highlight ?? false) ? 'checked' : '' }}>
            <span class="ml-2 text-sm text-zinc-700 dark:text-zinc-300 font-medium">Set as Highlight (Landing Page)</span>
        </label>

    </div>

</div>
