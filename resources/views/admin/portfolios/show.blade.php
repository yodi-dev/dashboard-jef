<x-app-layout>
    <div class="space-y-6">

        {{-- Header & Actions --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                Detail Portfolio
            </h1>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.portfolios.edit', $portfolio->id) }}"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-150 shadow-sm font-medium text-sm">
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
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300 rounded-full">
                            🏷️ {{ $portfolio->category ?? 'Portrait' }}
                        </span>

                        @if ($portfolio->is_published)
                            <span
                                class="px-3 py-1 text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full border border-green-200 dark:border-green-800">
                                ✅ Published
                            </span>
                        @else
                            <span
                                class="px-3 py-1 text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-full border border-yellow-200 dark:border-yellow-800">
                                📝 Draft
                            </span>
                        @endif

                        @if ($portfolio->is_highlight)
                            <span
                                class="px-3 py-1 text-xs font-medium bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400 rounded-full border border-purple-200 dark:border-purple-800 flex items-center gap-1">
                                ✨ Highlighted
                            </span>
                        @endif

                        @if ($portfolio->published_at)
                            <span
                                class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-full border border-blue-200 dark:border-blue-800">
                                📅 {{ \Carbon\Carbon::parse($portfolio->published_at)->format('d M Y H:i') }}
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
