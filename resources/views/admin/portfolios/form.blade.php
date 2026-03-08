<div class="space-y-5"> {{-- Jarak antar elemen form --}}

    {{-- Title --}}
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Title <span class="text-red-500">*</span>
        </label>
        <input type="text" id="title" name="title" value="{{ old('title', $portfolio->title ?? '') }}"
            class="w-full px-4 py-2.5 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-blue-500 dark:focus:border-blue-500 transition duration-150">

        {{-- Pesan Error Validasi --}}
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

    {{-- Project URL --}}
    <div>
        <label for="project_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Project URL
        </label>
        <input type="url" id="project_url" name="project_url"
            value="{{ old('project_url', $portfolio->project_url ?? '') }}" placeholder="https://..."
            class="w-full px-4 py-2.5 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-blue-500 dark:focus:border-blue-500 transition duration-150">

        @error('project_url')
            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

</div>
