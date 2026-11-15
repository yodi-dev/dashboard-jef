@section('title', 'Studio Overview')

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-serif text-2xl font-bold text-zinc-900 dark:text-zinc-100 leading-tight">
                    Studio Overview
                </h2>
                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                    Live operational telemetry, upcoming client sessions, and content distribution.
                </p>
            </div>
            <a href="{{ rtrim(config('app.frontend_url', env('FRONTEND_URL', 'http://localhost:3000')), '/') }}" target="_blank" rel="noopener noreferrer"
                class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-zinc-600 dark:text-zinc-300 bg-stone-100 dark:bg-zinc-800 hover:bg-stone-200 dark:hover:bg-zinc-700 rounded-lg transition border border-stone-200 dark:border-zinc-700 shadow-sm">
                <span>View Live Site</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">

            {{-- 1. TOP SUMMARY CARDS (Clickable & Contextual) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">

                {{-- Pending Bookings Card --}}
                <a href="{{ route('admin.bookings.index') }}"
                    class="group bg-white dark:bg-zinc-900 overflow-hidden shadow-sm rounded-xl border border-stone-200 dark:border-zinc-800 border-l-4 border-l-amber-500 p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-150 block">
                    <div class="flex items-center justify-between">
                        <div class="text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                            Pending Requests
                        </div>
                        <span class="text-amber-500 text-xs">⏳</span>
                    </div>
                    <div class="mt-2 text-2xl font-bold text-zinc-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">
                        {{ $pendingBookingsCount }}
                    </div>
                    <p class="text-[11px] text-zinc-400 dark:text-zinc-500 mt-1">Requires review</p>
                </a>

                {{-- Confirmed Bookings Card --}}
                <a href="{{ route('admin.bookings.index') }}"
                    class="group bg-white dark:bg-zinc-900 overflow-hidden shadow-sm rounded-xl border border-stone-200 dark:border-zinc-800 border-l-4 border-l-sky-500 p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-150 block">
                    <div class="flex items-center justify-between">
                        <div class="text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                            Confirmed
                        </div>
                        <span class="text-sky-500 text-xs">📅</span>
                    </div>
                    <div class="mt-2 text-2xl font-bold text-zinc-900 dark:text-white group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors">
                        {{ $confirmedBookingsCount }}
                    </div>
                    <p class="text-[11px] text-zinc-400 dark:text-zinc-500 mt-1">Upcoming shoots</p>
                </a>

                {{-- Completed Bookings Card --}}
                <a href="{{ route('admin.bookings.index') }}"
                    class="group bg-white dark:bg-zinc-900 overflow-hidden shadow-sm rounded-xl border border-stone-200 dark:border-zinc-800 border-l-4 border-l-emerald-500 p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-150 block">
                    <div class="flex items-center justify-between">
                        <div class="text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                            Completed
                        </div>
                        <span class="text-emerald-500 text-xs">✅</span>
                    </div>
                    <div class="mt-2 text-2xl font-bold text-zinc-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                        {{ $completedBookingsCount }}
                    </div>
                    <p class="text-[11px] text-zinc-400 dark:text-zinc-500 mt-1">Delivered sessions</p>
                </a>

                {{-- Published Portfolios Card --}}
                <a href="{{ route('admin.portfolios.index') }}"
                    class="group bg-white dark:bg-zinc-900 overflow-hidden shadow-sm rounded-xl border border-stone-200 dark:border-zinc-800 border-l-4 border-l-zinc-800 dark:border-l-zinc-200 p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-150 block">
                    <div class="flex items-center justify-between">
                        <div class="text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                            Published Works
                        </div>
                        <span class="text-zinc-600 dark:text-zinc-400 text-xs">📷</span>
                    </div>
                    <div class="mt-2 text-2xl font-bold text-zinc-900 dark:text-white group-hover:text-zinc-700 dark:group-hover:text-zinc-300 transition-colors">
                        {{ $publishedPortfoliosCount }}
                    </div>
                    <p class="text-[11px] text-zinc-400 dark:text-zinc-500 mt-1">Curated galleries</p>
                </a>

                {{-- Published Articles Card --}}
                <a href="{{ route('admin.articles.index') }}"
                    class="group bg-white dark:bg-zinc-900 overflow-hidden shadow-sm rounded-xl border border-stone-200 dark:border-zinc-800 border-l-4 border-l-stone-600 dark:border-l-stone-400 p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-150 block">
                    <div class="flex items-center justify-between">
                        <div class="text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                            Journal Stories
                        </div>
                        <span class="text-stone-500 text-xs">✍️</span>
                    </div>
                    <div class="mt-2 text-2xl font-bold text-zinc-900 dark:text-white group-hover:text-stone-700 dark:group-hover:text-stone-300 transition-colors">
                        {{ $publishedArticlesCount }}
                    </div>
                    <p class="text-[11px] text-zinc-400 dark:text-zinc-500 mt-1">Essays published</p>
                </a>

                {{-- Total Gallery Photos Card --}}
                <a href="{{ route('admin.portfolios.index') }}"
                    class="group bg-white dark:bg-zinc-900 overflow-hidden shadow-sm rounded-xl border border-stone-200 dark:border-zinc-800 border-l-4 border-l-indigo-500 p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-150 block">
                    <div class="flex items-center justify-between">
                        <div class="text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                            Gallery Assets
                        </div>
                        <span class="text-indigo-500 text-xs">🖼️</span>
                    </div>
                    <div class="mt-2 text-2xl font-bold text-zinc-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                        {{ $totalGalleryPhotosCount }}
                    </div>
                    <p class="text-[11px] text-zinc-400 dark:text-zinc-500 mt-1">Photos in catalog</p>
                </a>

            </div>

            {{-- 2. RECENT BOOKING REQUESTS TABLE --}}
            <div
                class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm rounded-xl border border-stone-200 dark:border-zinc-800">
                <div class="p-6 border-b border-stone-200 dark:border-zinc-800 flex justify-between items-center">
                    <div>
                        <h3 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">
                            Recent Booking Requests
                        </h3>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                            Latest inquiries received from the public portfolio booking form.
                        </p>
                    </div>
                    <a href="{{ route('admin.bookings.index') }}"
                        class="text-xs font-semibold text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-white underline underline-offset-4">
                        View All Bookings &rarr;
                    </a>
                </div>

                {{-- 1. MOBILE RECENT BOOKINGS LIST (< md) --}}
                <div class="md:hidden divide-y divide-stone-200 dark:divide-zinc-800">
                    @forelse ($recentBookings as $booking)
                        <div class="p-4 space-y-2">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <h4 class="text-sm font-semibold text-zinc-900 dark:text-white">
                                        {{ $booking->name }}
                                    </h4>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                                        {{ $booking->package }} &bull; {{ $booking->location }}
                                    </p>
                                </div>
                                <div>
                                    @if ($booking->status === 'pending')
                                        <span class="px-2 py-0.5 inline-flex text-xs font-semibold rounded-full bg-amber-100 text-amber-800 dark:bg-amber-950/40 dark:text-amber-300 border border-amber-300 dark:border-amber-800">Pending</span>
                                    @elseif($booking->status === 'confirmed')
                                        <span class="px-2 py-0.5 inline-flex text-xs font-semibold rounded-full bg-sky-100 text-sky-800 dark:bg-sky-950/40 dark:text-sky-300 border border-sky-300 dark:border-sky-800">Confirmed</span>
                                    @elseif($booking->status === 'completed')
                                        <span class="px-2 py-0.5 inline-flex text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800">Completed</span>
                                    @else
                                        <span class="px-2 py-0.5 inline-flex text-xs font-semibold rounded-full bg-rose-100 text-rose-800 dark:bg-rose-950/40 dark:text-rose-300 border border-rose-300 dark:border-rose-800">Canceled</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center justify-between text-xs pt-1 text-zinc-500 dark:text-zinc-400">
                                <span>📅 {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y, H:i') }}</span>
                                <a href="{{ route('admin.bookings.edit', $booking->id) }}"
                                    class="font-medium text-zinc-900 dark:text-zinc-100 hover:underline">
                                    Manage &rarr;
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-sm text-zinc-500 dark:text-zinc-400">
                            No recent bookings found.
                        </div>
                    @endforelse
                </div>

                {{-- 2. DESKTOP DATA TABLE (>= md) --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-stone-200 dark:divide-zinc-800">
                        <thead class="bg-stone-50 dark:bg-zinc-800/60">
                            <tr>
                                <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Client Name</th>
                                <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Package</th>
                                <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Date & Time</th>
                                <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3.5 text-right text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-zinc-900 divide-y divide-stone-200 dark:divide-zinc-800">
                            @forelse ($recentBookings as $booking)
                                <tr class="hover:bg-stone-50 dark:hover:bg-zinc-800/40 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-white">
                                        {{ $booking->name }}
                                        <span class="block text-xs font-normal text-zinc-400">{{ $booking->phone }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-300">
                                        {{ $booking->package }}
                                        <span class="block text-xs text-zinc-400">{{ $booking->location }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-300">
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($booking->status === 'pending')
                                            <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-amber-100 text-amber-800 dark:bg-amber-950/40 dark:text-amber-300 border border-amber-300 dark:border-amber-800">Pending</span>
                                        @elseif($booking->status === 'confirmed')
                                            <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-sky-100 text-sky-800 dark:bg-sky-950/40 dark:text-sky-300 border border-sky-300 dark:border-sky-800">Confirmed</span>
                                        @elseif($booking->status === 'completed')
                                            <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800">Completed</span>
                                        @else
                                            <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-rose-100 text-rose-800 dark:bg-rose-950/40 dark:text-rose-300 border border-rose-300 dark:border-rose-800">Canceled</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.bookings.edit', $booking->id) }}"
                                            class="inline-flex items-center text-xs font-semibold px-3 py-1.5 rounded-lg bg-stone-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 hover:bg-stone-200 dark:hover:bg-zinc-700 transition border border-stone-200 dark:border-zinc-700">Manage</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                        No recent bookings found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
