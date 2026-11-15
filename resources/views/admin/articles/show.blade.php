<x-app-layout>
    @section('title', 'Article: ' . $article->title)

    <div class="space-y-6 max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                Article Details
            </h1>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.articles.edit', $article->id) }}"
                    class="px-4 py-2 bg-zinc-900 text-white hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-white rounded-lg text-sm font-medium transition duration-150 shadow-sm">
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
            <div class="mb-6 flex flex-wrap items-center gap-2.5">
                @if ($article->is_published)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-medium bg-stone-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 rounded-full border border-stone-200 dark:border-zinc-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        <span>Published</span>
                    </span>
                    @if ($article->published_at)
                        <span class="text-xs font-mono text-zinc-500 dark:text-zinc-400">
                            on {{ \Carbon\Carbon::parse($article->published_at)->format('d M Y, H:i') }}
                        </span>
                    @endif
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-medium bg-stone-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400 rounded-full border border-stone-200 dark:border-zinc-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-zinc-400"></span>
                        <span>Draft</span>
                    </span>
                @endif

                @if ($article->is_highlight)
                    <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium bg-stone-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-200 rounded-full border border-stone-300 dark:border-zinc-600">
                        <svg class="w-3 h-3 text-amber-500 fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span>Featured</span>
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
