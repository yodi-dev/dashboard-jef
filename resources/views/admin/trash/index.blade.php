<x-app-layout>
    <div class="space-y-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Recycle Bin</h1>

        {{-- Flash Message --}}
        @if (session('success'))
            <div
                class="p-4 bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300 border border-green-200 dark:border-green-800/50 rounded-lg transition">
                {{ session('success') }}
            </div>
        @endif

        {{-- Alpine.js Component for Tabs --}}
        <div x-data="{ activeTab: 'portfolios' }" class="bg-white dark:bg-gray-800 shadow-sm rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700">

            {{-- Tabs Header --}}
            <div class="flex border-b border-gray-200 dark:border-gray-700">
                <button @click="activeTab = 'portfolios'"
                    :class="activeTab === 'portfolios' ? 'border-green-600 text-green-600 dark:text-green-400 font-semibold' :
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 font-medium'"
                    class="flex-1 py-4 px-4 sm:px-6 text-center border-b-2 text-sm transition-colors duration-150">
                    Portfolios ({{ $trashedPortfolios->count() }})
                </button>
                <button @click="activeTab = 'articles'"
                    :class="activeTab === 'articles' ? 'border-green-600 text-green-600 dark:text-green-400 font-semibold' :
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 font-medium'"
                    class="flex-1 py-4 px-4 sm:px-6 text-center border-b-2 text-sm transition-colors duration-150">
                    Articles ({{ $trashedArticles->count() }})
                </button>
                <button @click="activeTab = 'bookings'"
                    :class="activeTab === 'bookings' ? 'border-green-600 text-green-600 dark:text-green-400 font-semibold' :
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 font-medium'"
                    class="flex-1 py-4 px-4 sm:px-6 text-center border-b-2 text-sm transition-colors duration-150">
                    Bookings ({{ $trashedBookings->count() }})
                </button>
            </div>

            {{-- Tab Content: Portfolios --}}
            <div x-show="activeTab === 'portfolios'" class="p-6">
                @if ($trashedPortfolios->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400 text-center italic py-8">No trashed portfolios found.</p>
                @else
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($trashedPortfolios as $portfolio)
                            <li class="py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $portfolio->title }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Deleted at:
                                        {{ $portfolio->deleted_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <form action="{{ route('admin.portfolios.restore', $portfolio->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-lg transition shadow-sm">
                                            Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.portfolios.forceDestroy', $portfolio->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-lg transition shadow-sm">
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
                    <p class="text-gray-500 dark:text-gray-400 text-center italic py-8">No trashed articles found.</p>
                @else
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($trashedArticles as $article)
                            <li class="py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $article->title }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Deleted at:
                                        {{ $article->deleted_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <form action="{{ route('admin.articles.restore', $article->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-lg transition shadow-sm">
                                            Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.articles.forceDestroy', $article->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-lg transition shadow-sm">
                                            Delete Permanently
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Tab Content: Bookings --}}
            <div x-show="activeTab === 'bookings'" class="p-6" style="display: none;">
                @if ($trashedBookings->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400 text-center italic py-8">No trashed bookings found.</p>
                @else
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($trashedBookings as $booking)
                            <li class="py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $booking->name }} - {{ $booking->package }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Deleted at:
                                        {{ $booking->deleted_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <form action="{{ route('admin.bookings.restore', $booking->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-lg transition shadow-sm">
                                            Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.bookings.forceDestroy', $booking->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-lg transition shadow-sm">
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
