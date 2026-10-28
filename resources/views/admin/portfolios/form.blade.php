<div class="space-y-6">

    {{-- Title --}}
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Title <span class="text-red-500">*</span>
        </label>
        <input type="text" id="title" name="title" value="{{ old('title', $portfolio->title ?? '') }}" required
            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-green-500 dark:focus:border-green-500 transition duration-150">

        @error('title')
            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Category / Theme --}}
    <div>
        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Category / Theme <span class="text-red-500">*</span>
        </label>
        <select id="category" name="category" required
            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-green-500 dark:focus:border-green-500 transition duration-150">
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
        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Description
        </label>
        <textarea id="description" name="description" rows="4"
            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-green-500 dark:focus:border-green-500 transition duration-150">{{ old('description', $portfolio->description ?? '') }}</textarea>

        @error('description')
            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Grid for Upload Files --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Thumbnail --}}
        <div>
            <label for="thumbnail" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Thumbnail <span class="text-xs text-gray-500">(Formats: JPG, PNG, WEBP)</span>
            </label>

            {{-- OLD IMAGE PREVIEW --}}
            @if (isset($portfolio) && $portfolio->thumbnail_url)
                <div class="mb-3">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Current Thumbnail:</p>
                    <img src="{{ $portfolio->thumbnail_url }}" alt="Thumbnail"
                        class="h-32 object-cover rounded-md border border-gray-300 dark:border-gray-700">
                </div>
            @endif

            <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                class="w-full px-3 py-2 border rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 dark:file:bg-gray-700 dark:file:text-gray-300 transition duration-150">

            @error('thumbnail')
                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Gallery (Multiple) --}}
        <div>
            <label for="gallery" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Gallery <span class="text-xs text-gray-500">(You can select multiple images)</span>
            </label>

            {{-- OLD IMAGE PREVIEW --}}
            @if (isset($portfolio) && !empty($portfolio->gallery_urls))
                <div class="mb-3">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Current Gallery:</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($portfolio->gallery_urls as $image_url)
                            <img src="{{ $image_url }}" alt="Gallery"
                                class="h-16 w-16 object-cover rounded-md border border-gray-300 dark:border-gray-700">
                        @endforeach
                    </div>
                </div>
            @endif

            <input type="file" id="gallery" name="gallery[]" multiple accept="image/*"
                class="w-full px-3 py-2 border rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 dark:file:bg-gray-700 dark:file:text-gray-300 transition duration-150">

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
                class="w-5 h-5 rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 dark:bg-gray-900 dark:border-gray-700"
                {{ old('is_published', $portfolio->is_published ?? false) ? 'checked' : '' }}>
            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300 font-medium">Publish Portfolio</span>
        </label>

        {{-- Is Highlight --}}
        <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_highlight" value="1"
                class="w-5 h-5 rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:bg-gray-900 dark:border-gray-700"
                {{ old('is_highlight', $portfolio->is_highlight ?? false) ? 'checked' : '' }}>
            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300 font-medium">Set as Highlight (Landing Page)</span>
        </label>

    </div>

</div>
