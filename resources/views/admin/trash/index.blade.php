@section('title', 'Recycle Bin')

<x-app-layout>
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">Recycle Bin</h1>
            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                Safely recover soft-deleted items or permanently remove them from the system.
            </p>
        </div>

        {{-- Alpine.js Component for Tabs --}}
        <div x-data="{ activeTab: 'portfolios' }" class="bg-white dark:bg-zinc-900 shadow-sm rounded-xl overflow-hidden border border-stone-200 dark:border-zinc-800">

            {{-- Tabs Header --}}
            <div class="flex border-b border-stone-200 dark:border-zinc-800">
                <button @click="activeTab = 'portfolios'"
                    :class="activeTab === 'portfolios' ? 'border-zinc-900 text-zinc-900 dark:border-zinc-100 dark:text-zinc-100 font-semibold' :
                        'border-transparent text-zinc-500 hover:text-zinc-700 hover:border-zinc-300 dark:text-zinc-400 dark:hover:text-zinc-300 font-medium'"
                    class="flex-1 py-4 px-4 sm:px-6 text-center border-b-2 text-sm transition-colors duration-150">
                    Portfolios ({{ $trashedPortfolios->count() }})
                </button>
                <button @click="activeTab = 'articles'"
                    :class="activeTab === 'articles' ? 'border-zinc-900 text-zinc-900 dark:border-zinc-100 dark:text-zinc-100 font-semibold' :
                        'border-transparent text-zinc-500 hover:text-zinc-700 hover:border-zinc-300 dark:text-zinc-400 dark:hover:text-zinc-300 font-medium'"
                    class="flex-1 py-4 px-4 sm:px-6 text-center border-b-2 text-sm transition-colors duration-150">
                    Articles ({{ $trashedArticles->count() }})
                </button>
                <button @click="activeTab = 'bookings'"
                    :class="activeTab === 'bookings' ? 'border-zinc-900 text-zinc-900 dark:border-zinc-100 dark:text-zinc-100 font-semibold' :
                        'border-transparent text-zinc-500 hover:text-zinc-700 hover:border-zinc-300 dark:text-zinc-400 dark:hover:text-zinc-300 font-medium'"
                    class="flex-1 py-4 px-4 sm:px-6 text-center border-b-2 text-sm transition-colors duration-150">
                    Bookings ({{ $trashedBookings->count() }})
                </button>
            </div>

            {{-- Tab Content: Portfolios --}}
            <div x-show="activeTab === 'portfolios'" class="p-6">
                @if ($trashedPortfolios->isEmpty())
                    <p class="text-zinc-500 dark:text-zinc-400 text-center italic py-8">No trashed portfolios found.</p>
                @else
                    <ul class="divide-y divide-stone-200 dark:divide-zinc-800">
                        @foreach ($trashedPortfolios as $portfolio)
                            <li class="py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div>
                                    <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $portfolio->title }}</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Deleted at:
                                        {{ $portfolio->deleted_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <form action="{{ route('admin.portfolios.restore', $portfolio->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-zinc-900 hover:bg-zinc-800 text-white dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-white text-xs font-semibold rounded-lg transition shadow-sm">
                                            Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.portfolios.forceDestroy', $portfolio->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold rounded-lg transition shadow-sm">
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
                    <p class="text-zinc-500 dark:text-zinc-400 text-center italic py-8">No trashed articles found.</p>
                @else
                    <ul class="divide-y divide-stone-200 dark:divide-zinc-800">
                        @foreach ($trashedArticles as $article)
                            <li class="py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div>
                                    <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $article->title }}</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Deleted at:
                                        {{ $article->deleted_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <form action="{{ route('admin.articles.restore', $article->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-zinc-900 hover:bg-zinc-800 text-white dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-white text-xs font-semibold rounded-lg transition shadow-sm">
                                            Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.articles.forceDestroy', $article->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold rounded-lg transition shadow-sm">
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
                    <p class="text-zinc-500 dark:text-zinc-400 text-center italic py-8">No trashed bookings found.</p>
                @else
                    <ul class="divide-y divide-stone-200 dark:divide-zinc-800">
                        @foreach ($trashedBookings as $booking)
                            <li class="py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div>
                                    <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $booking->name }} - {{ $booking->package }}</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Deleted at:
                                        {{ $booking->deleted_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <form action="{{ route('admin.bookings.restore', $booking->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-zinc-900 hover:bg-zinc-800 text-white dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-white text-xs font-semibold rounded-lg transition shadow-sm">
                                            Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.bookings.forceDestroy', $booking->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold rounded-lg transition shadow-sm">
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
