{{-- Title --}}
<div class="mb-6">
    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Article Title <span
            class="text-red-500">*</span></label>
    <input type="text" name="title" id="title" value="{{ old('title', $article->title ?? '') }}" required
        class="w-full rounded-md border-gray-300 shadow-sm focus:border-zinc-800 focus:ring-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 dark:bg-gray-900 dark:border-gray-600 dark:text-gray-100 sm:text-sm"
        placeholder="Enter an engaging title...">
    @error('title')
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>

{{-- Cover Image --}}
<div class="mb-6" x-data="{ preview: null }">
    <label for="cover_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cover Image</label>

    {{-- Live Client Preview --}}
    <div x-show="preview" class="mb-3 relative inline-block">
        <img :src="preview" alt="New Cover Preview"
            class="h-32 object-cover rounded-md border-2 border-zinc-800 dark:border-zinc-200 shadow-sm">
        <span class="absolute top-2 right-2 bg-zinc-900 text-white text-xs px-2 py-1 rounded font-medium">New Selected</span>
    </div>

    {{-- Preview Gambar Lama (Hanya muncul saat Edit & gambar ada) --}}
    @if (isset($article) && $article->cover_image_url)
        <div x-show="!preview" class="mb-3 relative inline-block">
            <img src="{{ $article->cover_image_url }}" alt="Current Cover"
                class="h-32 object-cover rounded-md border border-gray-200 dark:border-gray-600 shadow-sm">
            <span class="absolute top-2 right-2 bg-gray-900/70 text-white text-xs px-2 py-1 rounded">Current</span>
        </div>
    @endif

    <input type="file" name="cover_image" id="cover_image" accept="image/*"
        @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
        class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-stone-100 file:text-zinc-800 hover:file:bg-stone-200 dark:file:bg-zinc-800 dark:file:text-zinc-200 transition">
    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
        Recommended size: 1200x630px. Max size: 5MB.
        @if (isset($article))
            <em>Leave blank if you don't want to change the image.</em>
        @endif
    </p>
    @error('cover_image')
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>

{{-- Content --}}
<div class="mb-6">
    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content <span
            class="text-red-500">*</span></label>
    <textarea name="content" id="content" rows="10" required
        class="w-full rounded-md border-gray-300 shadow-sm focus:border-zinc-800 focus:ring-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 dark:bg-gray-900 dark:border-gray-600 dark:text-gray-100 sm:text-sm"
        placeholder="Write your article content here...">{{ old('content', $article->content ?? '') }}</textarea>
    @error('content')
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>

{{-- Options (Published & Highlight) --}}
<div class="mb-6 flex gap-8 p-4  dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-lg">

    {{-- Toggle Published --}}
    <label class="relative inline-flex items-center cursor-pointer">
        <input type="checkbox" name="is_published" value="1" class="sr-only peer"
            {{ old('is_published', $article->is_published ?? false) ? 'checked' : '' }}>
        <div
            class="w-9 h-5 bg-stone-200 peer-focus:outline-none rounded-full peer dark:bg-zinc-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-zinc-600 peer-checked:bg-zinc-900 dark:peer-checked:bg-zinc-100 dark:peer-checked:after:bg-zinc-900">
        </div>
        <span class="ml-3 text-sm font-medium text-zinc-700 dark:text-zinc-300">Publish Immediately</span>
    </label>

    {{-- Toggle Highlight --}}
    <label class="relative inline-flex items-center cursor-pointer">
        <input type="checkbox" name="is_highlight" value="1" class="sr-only peer"
            {{ old('is_highlight', $article->is_highlight ?? false) ? 'checked' : '' }}>
        <div
            class="w-9 h-5 bg-stone-200 peer-focus:outline-none rounded-full peer dark:bg-zinc-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-zinc-600 peer-checked:bg-zinc-900 dark:peer-checked:bg-zinc-100 dark:peer-checked:after:bg-zinc-900">
        </div>
        <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">Set as Highlight</span>
    </label>

</div>

{{-- Submit Button --}}
<div class="flex justify-end pt-4 dark:border-gray-700 mt-6">
    <button type="submit"
        :disabled="submitting"
        :class="submitting ? 'opacity-70 cursor-not-allowed' : ''"
        class="bg-zinc-900 hover:bg-zinc-800 text-white dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-white font-semibold py-2.5 px-6 rounded-lg shadow-sm transition duration-150 ease-in-out inline-flex items-center gap-2">
        <svg x-show="submitting" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span x-text="submitting ? 'Saving Article...' : '{{ isset($article) ? 'Update Article' : 'Save Article' }}'">{{ isset($article) ? 'Update Article' : 'Save Article' }}</span>
    </button>
</div>
