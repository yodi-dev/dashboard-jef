<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200">Recycle Bin</h1>

        {{-- Flash Message --}}
        @if (session('success'))
            <div
                class="mb-4 p-4 bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300 border border-green-200 dark:border-green-800/50 rounded transition">
                {{ session('success') }}
            </div>
        @endif

        {{-- Alpine.js Component for Tabs --}}
        <div x-data="{ activeTab: 'portfolios' }" class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">

            {{-- Tabs Header --}}
            <div class="flex border-b border-gray-200 dark:border-gray-700">
                <button @click="activeTab = 'portfolios'"
                    :class="activeTab === 'portfolios' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' :
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                    class="w-1/2 py-4 px-6 text-center border-b-2 font-medium text-sm transition-colors duration-200">
                    Portfolios ({{ $trashedPortfolios->count() }})
                </button>
                <button @click="activeTab = 'articles'"
                    :class="activeTab === 'articles' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' :
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                    class="w-1/2 py-4 px-6 text-center border-b-2 font-medium text-sm transition-colors duration-200">
                    Articles ({{ $trashedArticles->count() }})
                </button>
            </div>

            {{-- Tab Content: Portfolios --}}
            <div x-show="activeTab === 'portfolios'" class="p-6">
                @if ($trashedPortfolios->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400 text-center italic py-4">No trashed portfolios found.</p>
                @else
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($trashedPortfolios as $portfolio)
                            <li class="py-4 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $portfolio->title }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Deleted at:
                                        {{ $portfolio->deleted_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    {{-- Tombol Restore --}}
                                    <form action="{{ route('admin.portfolios.restore', $portfolio->id) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-xs rounded transition">
                                            Restore
                                        </button>
                                    </form>
                                    {{-- Tombol Force Delete --}}
                                    <form action="{{ route('admin.portfolios.forceDestroy', $portfolio->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to permanently delete this? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs rounded transition">
                                            Delete Permanently
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Tab Content: Articles --}}
            <div x-show="activeTab === 'articles'" class="p-6" style="display: none;">
                @if ($trashedArticles->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400 text-center italic py-4">No trashed articles found.</p>
                @else
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($trashedArticles as $article)
                            <li class="py-4 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $article->title }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Deleted at:
                                        {{ $article->deleted_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    {{-- Tombol Restore --}}
                                    <form action="{{ route('admin.articles.restore', $article->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-xs rounded transition">
                                            Restore
                                        </button>
                                    </form>
                                    {{-- Tombol Force Delete --}}
                                    <form action="{{ route('admin.articles.forceDestroy', $article->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to permanently delete this? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs rounded transition">
                                            Delete Permanently
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
