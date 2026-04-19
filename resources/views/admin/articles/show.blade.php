<x-app-layout>
    <div class="container mx-auto py-6">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                Article Details
            </h1>

            <div class="flex space-x-3">
                {{-- Back Button --}}
                <a href="{{ route('admin.articles.index') }}"
                    class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-200">
                    &larr; Back to List
                </a>
            </div>
        </div>

        {{-- Content Card --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 border border-gray-200 dark:border-gray-700">

            {{-- Status Badge --}}
            <div class="mb-6 flex items-center space-x-4">
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
            </div>

            {{-- Thumbnail --}}
            @if ($article->thumbnail)
                <div class="mb-8">
                    <img src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}"
                        class="w-full max-h-[400px] object-cover rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                </div>
            @endif

            {{-- Title --}}
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                {{ $article->title }}
            </h2>

            {{-- Article Content --}}
            {{-- Kita pakai {!! !!} agar tag HTML dari Rich Text Editor (misal CKEditor/Trix) bisa ter-render dengan baik --}}
            <div
                class="prose max-w-none dark:prose-invert text-gray-700 dark:text-gray-300 mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                {!! $article->content !!}
            </div>

        </div>
    </div>
</x-app-layout>
