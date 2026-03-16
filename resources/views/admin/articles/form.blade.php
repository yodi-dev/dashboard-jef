{{-- Title --}}
<div class="mb-6">
    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Article Title <span
            class="text-red-500">*</span></label>
    <input type="text" name="title" id="title" value="{{ old('title', $article->title ?? '') }}" required
        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-gray-600 dark:text-gray-100 sm:text-sm"
        placeholder="Enter an engaging title...">
    @error('title')
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>

{{-- Cover Image --}}
<div class="mb-6">
    <label for="cover_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cover Image</label>

    {{-- Preview Gambar Lama (Hanya muncul saat Edit & gambar ada) --}}
    @if (isset($article) && $article->cover_image)
        <div class="mb-3 relative inline-block">
            <img src="{{ Storage::url($article->cover_image) }}" alt="Current Cover"
                class="h-32 object-cover rounded-md border border-gray-200 dark:border-gray-600 shadow-sm">
            <span class="absolute top-2 right-2 bg-gray-900/70 text-white text-xs px-2 py-1 rounded">Current</span>
        </div>
    @endif

    <input type="file" name="cover_image" id="cover_image" accept="image/*"
        class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 dark:file:bg-gray-700 dark:file:text-gray-300 dark:hover:file:bg-gray-600 transition">
    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
        Recommended size: 1200x630px. Max size: 2MB.
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
        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-gray-600 dark:text-gray-100 sm:text-sm"
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
            class="w-9 h-5 bg-gray-300 peer-focus:outline-none rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-500 peer-checked:bg-green-500">
        </div>
        <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">Publish Immediately</span>
    </label>

    {{-- Toggle Highlight --}}
    <label class="relative inline-flex items-center cursor-pointer">
        <input type="checkbox" name="is_highlight" value="1" class="sr-only peer"
            {{ old('is_highlight', $article->is_highlight ?? false) ? 'checked' : '' }}>
        <div
            class="w-9 h-5 bg-gray-300 peer-focus:outline-none rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-500 peer-checked:bg-purple-500">
        </div>
        <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">Set as Highlight</span>
    </label>

</div>

{{-- Submit Button --}}
<div class="flex justify-end pt-4  dark:border-gray-700 mt-6">
    <button type="submit"
        class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg shadow-sm transition duration-150 ease-in-out">
        {{ isset($article) ? 'Update Article' : 'Save Article' }}
    </button>
</div>
