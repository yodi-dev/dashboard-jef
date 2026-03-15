<x-app-layout>
    <div class="container mx-auto py-6">
        
        {{-- Header & Back Button --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                Detail Portfolio
            </h1>
            <a href="{{ route('admin.portfolios.index') }}"
                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200 shadow-sm font-medium flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 border border-gray-200 dark:border-gray-700">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                {{-- Bagian Kiri: Thumbnail --}}
                <div class="md:col-span-1 space-y-4">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-2">Thumbnail</h3>
                        @if($portfolio->thumbnail)
                            <img src="{{ Storage::url($portfolio->thumbnail) }}" class="w-full h-auto object-cover rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm" alt="Thumbnail">
                        @else
                            <div class="w-full h-48 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-400 border border-dashed border-gray-300 dark:border-gray-600">
                                No Thumbnail
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Bagian Kanan: Info & Teks --}}
                <div class="md:col-span-2 space-y-6">
                    {{-- Judul & Slug --}}
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $portfolio->title }}</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Slug: <span class="font-mono bg-gray-100 dark:bg-gray-700 px-1 py-0.5 rounded">{{ $portfolio->slug }}</span></p>
                    </div>

                    {{-- Badges Status --}}
                    <div class="flex flex-wrap gap-2">
                        @if($portfolio->is_published)
                            <span class="px-3 py-1 text-sm font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full border border-green-200 dark:border-green-800">
                                ✅ Published
                            </span>
                        @else
                            <span class="px-3 py-1 text-sm font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-full border border-yellow-200 dark:border-yellow-800">
                                📝 Draft
                            </span>
                        @endif

                        @if($portfolio->is_highlight)
                            <span class="px-3 py-1 text-sm font-medium bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400 rounded-full border border-purple-200 dark:border-purple-800 flex items-center gap-1">
                                ✨ Highlighted
                            </span>
                        @endif
                        
                        @if($portfolio->published_at)
                            <span class="px-3 py-1 text-sm font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-full border border-blue-200 dark:border-blue-800">
                                📅 {{ \Carbon\Carbon::parse($portfolio->published_at)->format('d M Y H:i') }}
                            </span>
                        @endif
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-2">Deskripsi</h3>
                        <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg text-gray-800 dark:text-gray-200 whitespace-pre-line border border-gray-200 dark:border-gray-700">
                            {{ $portfolio->description ?: 'Tidak ada deskripsi yang ditambahkan.' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Bawah: Gallery --}}
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Galeri Foto</h3>
                
                @if(!empty($portfolio->gallery))
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        @foreach($portfolio->gallery as $image)
                            <div class="relative group aspect-square">
                                <img src="{{ Storage::url($image) }}" class="w-full h-full object-cover rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm transition-transform duration-300 group-hover:scale-105" alt="Gallery Image">
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="w-full p-8 text-center bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-dashed border-gray-300 dark:border-gray-700">
                        <p class="text-gray-500 dark:text-gray-400 italic">Tidak ada foto galeri untuk portfolio ini.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>