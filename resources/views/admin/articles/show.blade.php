<x-app-layout>
    <div class="space-y-6 max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                Article Details
            </h1>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.articles.edit', $article->id) }}"
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition duration-150 shadow-sm">
                    Edit Article
                </a>
                <a href="{{ route('admin.articles.index') }}"
                    class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg text-sm font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150">
                    &larr; Back to List
                </a>
            </div>
        </div>

        {{-- Content Card --}}
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 sm:p-8 border border-gray-200 dark:border-gray-700">

            {{-- Status Badge --}}
            <div class="mb-6 flex flex-wrap items-center gap-3">
                @if ($article->is_published)
                    <span
                        class="px-3 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded-full dark:bg-green-900 dark:text-green-200">
                        Published
                    </span>
                    @if ($article->published_at)
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            on {{ \Carbon\Carbon::parse($article->published_at)->format('d M Y, H:i') }}
                        </span>
                    @endif
                @else
                    <span
                        class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-semibold rounded-full dark:bg-yellow-900 dark:text-yellow-200">
                        Draft
                    </span>
                @endif

                @if ($article->is_highlight)
                    <span
                        class="px-3 py-1 bg-purple-100 text-purple-800 text-sm font-semibold rounded-full dark:bg-purple-900 dark:text-purple-200">
                        ✨ Highlighted
                    </span>
                @endif
            </div>

            {{-- Cover Image --}}
            @if ($article->cover_image_url)
                <div class="mb-8">
                    <img src="{{ $article->cover_image_url }}" alt="{{ $article->title }}"
                        class="w-full max-h-[420px] object-cover rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                </div>
            @endif

            {{-- Title --}}
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-4">
                {{ $article->title }}
            </h2>

            {{-- Article Content --}}
            <div
                class="prose max-w-none dark:prose-invert text-gray-700 dark:text-gray-300 mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                {!! $article->content !!}
            </div>

        </div>
    </div>
</x-app-layout>
