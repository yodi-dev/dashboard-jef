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

        {{-- Quick Actions Toolbar --}}
        <div class="p-4 bg-white dark:bg-zinc-900 border border-stone-200 dark:border-zinc-800 rounded-xl shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-xs font-mono uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Quick Actions</span>
            </div>
            <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.portfolios.create') }}"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900 text-xs font-medium rounded-lg hover:bg-zinc-800 dark:hover:bg-white transition shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Upload Work</span>
                </a>
                <a href="{{ route('admin.articles.create') }}"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 dark:bg-zinc-800 dark:hover:bg-zinc-700 dark:text-zinc-200 text-xs font-medium rounded-lg border border-stone-200 dark:border-zinc-700 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    <span>Write Essay</span>
                </a>
                <a href="{{ route('admin.bookings.index') }}"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 dark:bg-zinc-800 dark:hover:bg-zinc-700 dark:text-zinc-200 text-xs font-medium rounded-lg border border-stone-200 dark:border-zinc-700 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Bookings</span>
                </a>
                <a href="{{ route('admin.photographer-profile.edit') }}"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 dark:bg-zinc-800 dark:hover:bg-zinc-700 dark:text-zinc-200 text-xs font-medium rounded-lg border border-stone-200 dark:border-zinc-700 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>Edit Bio</span>
                </a>
            </div>
        </div>

        {{-- 1. TOP SUMMARY CARDS (Clickable & Contextual) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">

            {{-- Pending Bookings Card --}}
            <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}"
                class="group bg-white dark:bg-zinc-900 overflow-hidden shadow-sm rounded-xl border border-stone-200 dark:border-zinc-800 p-5 hover:border-zinc-400 dark:hover:border-zinc-600 hover:-translate-y-0.5 transition-all duration-150 block">
                <div class="flex items-center justify-between">
                    <div class="text-[11px] font-mono uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        Pending Requests
                    </div>
                    <svg class="w-4 h-4 text-zinc-400 dark:text-zinc-500 group-hover:text-zinc-700 dark:group-hover:text-zinc-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="mt-2 text-2xl font-bold font-serif text-zinc-900 dark:text-white group-hover:text-zinc-700 dark:group-hover:text-zinc-300 transition-colors">
                    {{ $pendingBookingsCount }}
                </div>
                <p class="text-[11px] text-zinc-400 dark:text-zinc-500 mt-1">Requires review</p>
            </a>

            {{-- Confirmed Bookings Card --}}
            <a href="{{ route('admin.bookings.index', ['status' => 'confirmed']) }}"
                class="group bg-white dark:bg-zinc-900 overflow-hidden shadow-sm rounded-xl border border-stone-200 dark:border-zinc-800 p-5 hover:border-zinc-400 dark:hover:border-zinc-600 hover:-translate-y-0.5 transition-all duration-150 block">
                <div class="flex items-center justify-between">
                    <div class="text-[11px] font-mono uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        Confirmed
                    </div>
                    <svg class="w-4 h-4 text-zinc-400 dark:text-zinc-500 group-hover:text-zinc-700 dark:group-hover:text-zinc-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="mt-2 text-2xl font-bold font-serif text-zinc-900 dark:text-white group-hover:text-zinc-700 dark:group-hover:text-zinc-300 transition-colors">
                    {{ $confirmedBookingsCount }}
                </div>
                <p class="text-[11px] text-zinc-400 dark:text-zinc-500 mt-1">Upcoming shoots</p>
            </a>

            {{-- Completed Bookings Card --}}
            <a href="{{ route('admin.bookings.index', ['status' => 'completed']) }}"
                class="group bg-white dark:bg-zinc-900 overflow-hidden shadow-sm rounded-xl border border-stone-200 dark:border-zinc-800 p-5 hover:border-zinc-400 dark:hover:border-zinc-600 hover:-translate-y-0.5 transition-all duration-150 block">
                <div class="flex items-center justify-between">
                    <div class="text-[11px] font-mono uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        Completed
                    </div>
                    <svg class="w-4 h-4 text-zinc-400 dark:text-zinc-500 group-hover:text-zinc-700 dark:group-hover:text-zinc-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="mt-2 text-2xl font-bold font-serif text-zinc-900 dark:text-white group-hover:text-zinc-700 dark:group-hover:text-zinc-300 transition-colors">
                    {{ $completedBookingsCount }}
                </div>
                <p class="text-[11px] text-zinc-400 dark:text-zinc-500 mt-1">Delivered sessions</p>
            </a>

            {{-- Published Portfolios Card --}}
            <a href="{{ route('admin.portfolios.index', ['status' => 'published']) }}"
                class="group bg-white dark:bg-zinc-900 overflow-hidden shadow-sm rounded-xl border border-stone-200 dark:border-zinc-800 p-5 hover:border-zinc-400 dark:hover:border-zinc-600 hover:-translate-y-0.5 transition-all duration-150 block">
                <div class="flex items-center justify-between">
                    <div class="text-[11px] font-mono uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        Published Works
                    </div>
                    <svg class="w-4 h-4 text-zinc-400 dark:text-zinc-500 group-hover:text-zinc-700 dark:group-hover:text-zinc-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/>
                    </svg>
                </div>
                <div class="mt-2 text-2xl font-bold font-serif text-zinc-900 dark:text-white group-hover:text-zinc-700 dark:group-hover:text-zinc-300 transition-colors">
                    {{ $publishedPortfoliosCount }}
                </div>
                <p class="text-[11px] text-zinc-400 dark:text-zinc-500 mt-1">Curated galleries</p>
            </a>

            {{-- Published Articles Card --}}
            <a href="{{ route('admin.articles.index', ['status' => 'published']) }}"
                class="group bg-white dark:bg-zinc-900 overflow-hidden shadow-sm rounded-xl border border-stone-200 dark:border-zinc-800 p-5 hover:border-zinc-400 dark:hover:border-zinc-600 hover:-translate-y-0.5 transition-all duration-150 block">
                <div class="flex items-center justify-between">
                    <div class="text-[11px] font-mono uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        Journal Stories
                    </div>
                    <svg class="w-4 h-4 text-zinc-400 dark:text-zinc-500 group-hover:text-zinc-700 dark:group-hover:text-zinc-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                    </svg>
                </div>
                <div class="mt-2 text-2xl font-bold font-serif text-zinc-900 dark:text-white group-hover:text-zinc-700 dark:group-hover:text-zinc-300 transition-colors">
                    {{ $publishedArticlesCount }}
                </div>
                <p class="text-[11px] text-zinc-400 dark:text-zinc-500 mt-1">Essays published</p>
            </a>

            {{-- Total Gallery Photos Card --}}
            <a href="{{ route('admin.portfolios.index') }}"
                class="group bg-white dark:bg-zinc-900 overflow-hidden shadow-sm rounded-xl border border-stone-200 dark:border-zinc-800 p-5 hover:border-zinc-400 dark:hover:border-zinc-600 hover:-translate-y-0.5 transition-all duration-150 block">
                <div class="flex items-center justify-between">
                    <div class="text-[11px] font-mono uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        Gallery Assets
                    </div>
                    <svg class="w-4 h-4 text-zinc-400 dark:text-zinc-500 group-hover:text-zinc-700 dark:group-hover:text-zinc-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                    </svg>
                </div>
                <div class="mt-2 text-2xl font-bold font-serif text-zinc-900 dark:text-white group-hover:text-zinc-700 dark:group-hover:text-zinc-300 transition-colors">
                    {{ $totalGalleryPhotosCount }}
                </div>
                <p class="text-[11px] text-zinc-400 dark:text-zinc-500 mt-1">Photos in catalog</p>
            </a>

        </div>

        {{-- 2-COLUMN OPERATIONAL DASHBOARD --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            {{-- LEFT COLUMN: Recent Booking Requests (8 cols on lg) --}}
            <div class="lg:col-span-8 bg-white dark:bg-zinc-900 overflow-hidden shadow-sm rounded-xl border border-stone-200 dark:border-zinc-800">
                <div class="p-5 sm:p-6 border-b border-stone-200 dark:border-zinc-800 flex justify-between items-center">
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
                        View All ({{ $pendingBookingsCount + $confirmedBookingsCount + $completedBookingsCount }}) &rarr;
                    </a>
                </div>

                {{-- Mobile Recent Bookings (< md) --}}
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
                                    @php
                                        $dotColor = match ($booking->status) {
                                            'pending' => 'bg-amber-500',
                                            'confirmed' => 'bg-sky-500',
                                            'completed' => 'bg-emerald-500',
                                            default => 'bg-zinc-400',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-xs font-medium rounded-full bg-stone-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 border border-stone-200 dark:border-zinc-700">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                                        <span>{{ ucfirst($booking->status) }}</span>
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between text-xs pt-1 text-zinc-500 dark:text-zinc-400">
                                <span>
                                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                                    @if (\Carbon\Carbon::parse($booking->booking_date)->format('H:i') !== '00:00')
                                        &bull; <span class="font-mono">{{ \Carbon\Carbon::parse($booking->booking_date)->format('H:i') }}</span>
                                    @endif
                                </span>
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

                {{-- Desktop Data Table (>= md) --}}
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
                                @php
                                    $dotColor = match ($booking->status) {
                                        'pending' => 'bg-amber-500',
                                        'confirmed' => 'bg-sky-500',
                                        'completed' => 'bg-emerald-500',
                                        default => 'bg-zinc-400',
                                    };
                                @endphp
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
                                        <div>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</div>
                                        @if (\Carbon\Carbon::parse($booking->booking_date)->format('H:i') !== '00:00')
                                            <div class="text-xs text-zinc-400 font-mono">{{ \Carbon\Carbon::parse($booking->booking_date)->format('H:i') }}</div>
                                        @else
                                            <div class="text-xs text-zinc-400">Flexible</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium rounded-full bg-stone-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 border border-stone-200 dark:border-zinc-700">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                                            <span>{{ ucfirst($booking->status) }}</span>
                                        </span>
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

            {{-- RIGHT COLUMN: Content Activity & Telemetry (4 cols on lg) --}}
            <div class="lg:col-span-4 space-y-6">

                {{-- Recent Portfolios Activity --}}
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-stone-200 dark:border-zinc-800 p-5 shadow-sm">
                    <div class="flex items-center justify-between pb-3 border-b border-stone-200 dark:border-zinc-800">
                        <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            Recent Portfolios
                        </h3>
                        <a href="{{ route('admin.portfolios.index') }}" class="text-xs text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white transition">
                            View All &rarr;
                        </a>
                    </div>
                    <div class="divide-y divide-stone-100 dark:divide-zinc-800 mt-2">
                        @forelse($latestPortfolios ?? [] as $portfolio)
                            <div class="py-3 flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3 min-w-0">
                                    @if($portfolio->thumbnail_url)
                                        <img src="{{ $portfolio->thumbnail_url }}" alt="" class="w-10 h-10 rounded-lg object-cover flex-shrink-0 border border-stone-200 dark:border-zinc-700">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-stone-100 dark:bg-zinc-800 flex items-center justify-center text-[10px] text-zinc-400 flex-shrink-0">
                                            No Img
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="text-xs font-medium text-zinc-900 dark:text-zinc-100 truncate">
                                            {{ $portfolio->title }}
                                        </p>
                                        <p class="text-[11px] text-zinc-400 mt-0.5">
                                            {{ $portfolio->category ?? 'Portrait' }} &bull; {{ $portfolio->created_at->format('d M') }}
                                        </p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center gap-1 text-[11px] px-2 py-0.5 rounded-full {{ $portfolio->is_published ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300' : 'bg-stone-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $portfolio->is_published ? 'bg-emerald-500' : 'bg-zinc-400' }}"></span>
                                    <span>{{ $portfolio->is_published ? 'Live' : 'Draft' }}</span>
                                </span>
                            </div>
                        @empty
                            <p class="text-xs text-zinc-400 text-center py-4">No portfolios uploaded yet.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Recent Journal Stories Activity --}}
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-stone-200 dark:border-zinc-800 p-5 shadow-sm">
                    <div class="flex items-center justify-between pb-3 border-b border-stone-200 dark:border-zinc-800">
                        <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            Journal Stories
                        </h3>
                        <a href="{{ route('admin.articles.index') }}" class="text-xs text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white transition">
                            View All &rarr;
                        </a>
                    </div>
                    <div class="divide-y divide-stone-100 dark:divide-zinc-800 mt-2">
                        @forelse($latestArticles ?? [] as $article)
                            <div class="py-3 flex items-center justify-between gap-3">
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-medium text-zinc-900 dark:text-zinc-100 truncate">
                                        {{ $article->title }}
                                    </p>
                                    <p class="text-[11px] text-zinc-400 mt-0.5">
                                        {{ $article->created_at->format('d M Y') }}
                                    </p>
                                </div>
                                <span class="inline-flex items-center gap-1 text-[11px] px-2 py-0.5 rounded-full {{ $article->is_published ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300' : 'bg-stone-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $article->is_published ? 'bg-emerald-500' : 'bg-zinc-400' }}"></span>
                                    <span>{{ $article->is_published ? 'Live' : 'Draft' }}</span>
                                </span>
                            </div>
                        @empty
                            <p class="text-xs text-zinc-400 text-center py-4">No journal stories written yet.</p>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>

    </div>
</x-app-layout>
