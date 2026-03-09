<div class="space-y-6"> {{-- Jarak antar elemen form --}}

    {{-- Title --}}
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Title <span class="text-red-500">*</span>
        </label>
        <input type="text" id="title" name="title" value="{{ old('title', $portfolio->title ?? '') }}"
            class="w-full px-4 py-2.5 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-blue-500 dark:focus:border-blue-500 transition duration-150">

        @error('title')
            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Description --}}
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Description
        </label>
        <textarea id="description" name="description" rows="4"
            class="w-full px-4 py-2.5 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-blue-500 dark:focus:border-blue-500 transition duration-150">{{ old('description', $portfolio->description ?? '') }}</textarea>

        @error('description')
            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Grid untuk Upload Files biar rapi --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Thumbnail --}}
        <div>
            <label for="thumbnail" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Thumbnail <span class="text-xs text-gray-500">(Format: JPG, PNG, WEBP)</span>
            </label>
            <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                class="w-full px-3 py-2 border rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-gray-700 dark:file:text-gray-300 transition duration-150">

            @error('thumbnail')
                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Gallery (Multiple) --}}
        <div>
            <label for="gallery" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Gallery <span class="text-xs text-gray-500">(Bisa pilih lebih dari 1 gambar)</span>
            </label>
            <input type="file" id="gallery" name="gallery[]" multiple accept="image/*"
                class="w-full px-3 py-2 border rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-gray-700 dark:file:text-gray-300 transition duration-150">

            @error('gallery')
                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
            @error('gallery.*')
                {{-- Error jika ada file di dalam array yang nggak valid --}}
                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

    </div>

    {{-- Checkboxes untuk Status (Published & Highlight) --}}
    <div class="flex flex-col sm:flex-row sm:space-x-8 space-y-3 sm:space-y-0 pt-2">

        {{-- Is Published --}}
        <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_published" value="1"
                class="w-5 h-5 rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-900 dark:border-gray-700"
                {{ old('is_published', $portfolio->is_published ?? false) ? 'checked' : '' }}>
            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300 font-medium">Publish Portfolio</span>
        </label>

        {{-- Is Highlight --}}
        <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_highlight" value="1"
                class="w-5 h-5 rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-900 dark:border-gray-700"
                {{ old('is_highlight', $portfolio->is_highlight ?? false) ? 'checked' : '' }}>
            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300 font-medium">Jadikan Highlight (Landing
                Page)</span>
        </label>

    </div>

</div>
