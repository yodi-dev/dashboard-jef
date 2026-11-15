<x-app-layout>
    @section('title', 'Portfolio: ' . $portfolio->title)

    <div class="space-y-6">

        {{-- Header & Actions --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                Detail Portfolio
            </h1>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.portfolios.edit', $portfolio->id) }}"
                    class="px-4 py-2 bg-zinc-900 text-white hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-white rounded-lg transition duration-150 shadow-sm font-medium text-sm">
                    Edit Portfolio
                </a>
                <a href="{{ route('admin.portfolios.index') }}"
                    class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150 font-medium text-sm">
                    &larr; Back to List
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 sm:p-8 border border-gray-200 dark:border-gray-700">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                {{-- Bagian Kiri: Thumbnail --}}
                <div class="md:col-span-1 space-y-4">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-2">Thumbnail</h3>
                        @if ($portfolio->thumbnail_url)
                            <img src="{{ $portfolio->thumbnail_url }}"
                                class="w-full h-auto object-cover rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm"
                                alt="Thumbnail">
                        @else
                            <div
                                class="w-full h-48 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-400 border border-dashed border-gray-300 dark:border-gray-600">
                                No Thumbnail
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Bagian Kanan: Info & Teks --}}
                <div class="md:col-span-2 space-y-6">
                    {{-- Judul & Slug --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ $portfolio->title }}</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Slug: <span
                                class="font-mono bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded text-xs">{{ $portfolio->slug }}</span>
                        </p>
                    </div>

                    {{-- Badges Status --}}
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-2.5 py-1 text-xs font-mono uppercase tracking-wider bg-stone-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 rounded-md border border-stone-200 dark:border-zinc-700">
                            {{ $portfolio->category ?? 'Portrait' }}
                        </span>

                        @if ($portfolio->is_published)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-medium bg-stone-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 rounded-full border border-stone-200 dark:border-zinc-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                <span>Published</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-medium bg-stone-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400 rounded-full border border-stone-200 dark:border-zinc-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-zinc-400"></span>
                                <span>Draft</span>
                            </span>
                        @endif

                        @if ($portfolio->is_highlight)
                            <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium bg-stone-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-200 rounded-full border border-stone-300 dark:border-zinc-600">
                                <svg class="w-3 h-3 text-amber-500 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span>Featured</span>
                            </span>
                        @endif

                        @if ($portfolio->published_at)
                            <span class="px-2.5 py-1 text-xs font-mono text-zinc-500 dark:text-zinc-400 bg-stone-50 dark:bg-zinc-800/50 rounded-md border border-stone-200 dark:border-zinc-700">
                                {{ \Carbon\Carbon::parse($portfolio->published_at)->format('d M Y H:i') }}
                            </span>
                        @endif
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-2">Description</h3>
                        <div
                            class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg text-gray-800 dark:text-gray-200 whitespace-pre-line border border-gray-200 dark:border-gray-700 text-sm leading-relaxed">
                            {{ $portfolio->description ?: 'No description added.' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Bawah: Gallery --}}
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Photo Gallery</h3>

                @if (!empty($portfolio->gallery_urls))
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        @foreach ($portfolio->gallery_urls as $image_url)
                            <div class="relative group aspect-square">
                                <img src="{{ $image_url }}"
                                    class="w-full h-full object-cover rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm transition-transform duration-300 group-hover:scale-105"
                                    alt="Gallery Image">
                            </div>
                        @endforeach
                    </div>
                @else
                    <div
                        class="w-full p-8 text-center bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-dashed border-gray-300 dark:border-gray-700">
                        <p class="text-gray-500 dark:text-gray-400 italic">There are no gallery photos for this
                            portfolio.
                        </p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
