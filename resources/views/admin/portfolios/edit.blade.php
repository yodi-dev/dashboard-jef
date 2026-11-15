<x-app-layout>
    @section('title', 'Edit Portfolio: ' . $portfolio->title)

    <div class="space-y-6 max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                Edit Portfolio: <span class="text-zinc-800 dark:text-zinc-200">{{ $portfolio->title }}</span>
            </h1>

            {{-- Tombol Back --}}
            <a href="{{ route('admin.portfolios.index') }}"
                class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg text-sm font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150">
                &larr; Back to List
            </a>
        </div>

        {{-- Form Card --}}
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 sm:p-8 border border-gray-200 dark:border-gray-700">

            <form x-data="{ submitting: false }" @submit="submitting = true" action="{{ route('admin.portfolios.update', $portfolio) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Include Form Partial --}}
                @include('admin.portfolios.form')

                {{-- Submit Button --}}
                <div class="mt-8 flex justify-end">
                    <button type="submit"
                        :disabled="submitting"
                        :class="submitting ? 'opacity-70 cursor-not-allowed' : ''"
                        class="px-6 py-2.5 bg-zinc-900 text-white font-medium rounded-lg hover:bg-zinc-800 focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:ring-offset-2 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-white dark:focus:ring-offset-zinc-800 transition duration-150 shadow-sm inline-flex items-center gap-2">
                        <svg x-show="submitting" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="submitting ? 'Saving Portfolio...' : 'Update Portfolio'">Update Portfolio</span>
                    </button>
                </div>
            </form>

            @if (isset($portfolio) && !empty($portfolio->gallery) && is_array($portfolio->gallery))
                @foreach ($portfolio->gallery as $idx => $rawPath)
                    <form id="delete-gallery-form-{{ $idx }}" action="{{ route('admin.portfolios.destroyGalleryImage', $portfolio) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="image" value="{{ $rawPath }}">
                    </form>
                @endforeach
            @endif

        </div>
    </div>
</x-app-layout>
