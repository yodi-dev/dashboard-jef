@section('title', 'Manage Bookings')

<x-app-layout>
    <div class="space-y-6">

        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                    Client Session Inquiries
                </h1>
                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                    Track reservation dates, client requests, and shooting schedules.
                </p>
            </div>
        </div>

        {{-- Filter & Search Toolbar --}}
        <div class="space-y-4">
            {{-- Status Tabs --}}
            <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none border-b border-stone-200 dark:border-zinc-800">
                @php
                    $activeStatus = request('status', 'all');
                @endphp
                <a href="{{ route('admin.bookings.index', array_merge(request()->except('page', 'status'), ['status' => 'all'])) }}"
                    class="inline-flex items-center gap-2 px-3 py-2 text-xs font-medium rounded-t-lg border-b-2 transition-all whitespace-nowrap {{ $activeStatus === 'all' ? 'border-zinc-900 text-zinc-900 dark:border-zinc-100 dark:text-zinc-100 font-semibold' : 'border-transparent text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200' }}">
                    <span>All Bookings</span>
                    <span class="px-1.5 py-0.5 text-[10px] rounded-full {{ $activeStatus === 'all' ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'bg-stone-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400' }}">
                        {{ $counts['all'] ?? 0 }}
                    </span>
                </a>
                <a href="{{ route('admin.bookings.index', array_merge(request()->except('page', 'status'), ['status' => 'pending'])) }}"
                    class="inline-flex items-center gap-2 px-3 py-2 text-xs font-medium rounded-t-lg border-b-2 transition-all whitespace-nowrap {{ $activeStatus === 'pending' ? 'border-zinc-900 text-zinc-900 dark:border-zinc-100 dark:text-zinc-100 font-semibold' : 'border-transparent text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200' }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    <span>Pending</span>
                    <span class="px-1.5 py-0.5 text-[10px] rounded-full {{ $activeStatus === 'pending' ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'bg-stone-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400' }}">
                        {{ $counts['pending'] ?? 0 }}
                    </span>
                </a>
                <a href="{{ route('admin.bookings.index', array_merge(request()->except('page', 'status'), ['status' => 'confirmed'])) }}"
                    class="inline-flex items-center gap-2 px-3 py-2 text-xs font-medium rounded-t-lg border-b-2 transition-all whitespace-nowrap {{ $activeStatus === 'confirmed' ? 'border-zinc-900 text-zinc-900 dark:border-zinc-100 dark:text-zinc-100 font-semibold' : 'border-transparent text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200' }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                    <span>Confirmed</span>
                    <span class="px-1.5 py-0.5 text-[10px] rounded-full {{ $activeStatus === 'confirmed' ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'bg-stone-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400' }}">
                        {{ $counts['confirmed'] ?? 0 }}
                    </span>
                </a>
                <a href="{{ route('admin.bookings.index', array_merge(request()->except('page', 'status'), ['status' => 'completed'])) }}"
                    class="inline-flex items-center gap-2 px-3 py-2 text-xs font-medium rounded-t-lg border-b-2 transition-all whitespace-nowrap {{ $activeStatus === 'completed' ? 'border-zinc-900 text-zinc-900 dark:border-zinc-100 dark:text-zinc-100 font-semibold' : 'border-transparent text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200' }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span>Completed</span>
                    <span class="px-1.5 py-0.5 text-[10px] rounded-full {{ $activeStatus === 'completed' ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'bg-stone-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400' }}">
                        {{ $counts['completed'] ?? 0 }}
                    </span>
                </a>
                <a href="{{ route('admin.bookings.index', array_merge(request()->except('page', 'status'), ['status' => 'canceled'])) }}"
                    class="inline-flex items-center gap-2 px-3 py-2 text-xs font-medium rounded-t-lg border-b-2 transition-all whitespace-nowrap {{ $activeStatus === 'canceled' ? 'border-zinc-900 text-zinc-900 dark:border-zinc-100 dark:text-zinc-100 font-semibold' : 'border-transparent text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200' }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-zinc-400"></span>
                    <span>Canceled</span>
                    <span class="px-1.5 py-0.5 text-[10px] rounded-full {{ $activeStatus === 'canceled' ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'bg-stone-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400' }}">
                        {{ $counts['canceled'] ?? 0 }}
                    </span>
                </a>
            </div>

            {{-- Search Bar --}}
            <form method="GET" action="{{ route('admin.bookings.index') }}" class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center justify-between">
                <input type="hidden" name="status" value="{{ request('status', 'all') }}">

                <div class="flex-1 flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search bookings by client name, email, phone, location..."
                            class="block w-full pl-9 pr-9 py-2 text-xs sm:text-sm rounded-lg border-stone-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-800 dark:focus:ring-zinc-200 transition">
                        @if (request('search'))
                            <a href="{{ route('admin.bookings.index', request()->except('search', 'page')) }}"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200" title="Clear search">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </div>

                    <button type="submit"
                        class="px-3.5 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 dark:bg-zinc-800 dark:hover:bg-zinc-700 dark:text-zinc-200 text-xs sm:text-sm font-medium rounded-lg border border-stone-200 dark:border-zinc-700 transition">
                        Search
                    </button>

                    @if (request('search') || (request('status') && request('status') !== 'all'))
                        <a href="{{ route('admin.bookings.index') }}"
                            class="px-3 py-2 text-xs sm:text-sm text-zinc-500 hover:text-red-600 dark:text-zinc-400 dark:hover:text-red-400 transition inline-flex items-center gap-1 self-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Main Container Card --}}
        <div class="bg-white dark:bg-zinc-900 shadow-sm rounded-xl overflow-hidden border border-stone-200 dark:border-zinc-800">

            {{-- 1. MOBILE CARD LIST VIEW (Visible on mobile/tablet < md) --}}
            <div class="md:hidden divide-y divide-stone-200 dark:divide-zinc-800">
                @forelse($bookings as $booking)
                    <div class="p-4 space-y-3">
                        @php
                            $dotColor = match ($booking->status) {
                                'pending' => 'bg-amber-500',
                                'confirmed' => 'bg-sky-500',
                                'completed' => 'bg-emerald-500',
                                default => 'bg-zinc-400',
                            };
                        @endphp

                        {{-- Top: Client & Status --}}
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="text-base font-semibold text-zinc-900 dark:text-white">
                                    {{ $booking->name }}
                                </h3>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                                    {{ $booking->phone }}
                                </p>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-stone-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-stone-200 dark:border-zinc-700">
                                <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                                <span>{{ ucfirst($booking->status) }}</span>
                            </span>
                        </div>

                        {{-- Middle: Details Grid --}}
                        <div class="grid grid-cols-2 gap-2 text-xs pt-1 text-zinc-600 dark:text-zinc-300">
                            <div>
                                <span class="text-zinc-400 block mb-0.5">Package</span>
                                <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $booking->package }}</span>
                            </div>
                            <div>
                                <span class="text-zinc-400 block mb-0.5">Location</span>
                                <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $booking->location }}</span>
                            </div>
                            <div class="col-span-2 pt-1 border-t border-stone-100 dark:border-zinc-800">
                                <span class="text-zinc-400">Date: </span>
                                <span class="font-medium text-zinc-800 dark:text-zinc-200">
                                    {{ $booking->booking_date->format('l, d M Y') }}
                                    @if ($booking->booking_date->format('H:i') !== '00:00')
                                        - <span class="font-mono">{{ $booking->booking_date->format('H:i') }}</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        {{-- Bottom: Action Buttons --}}
                        <div class="flex items-center justify-end gap-2 pt-2 border-t border-stone-100 dark:border-zinc-800 text-xs font-medium">
                            <a href="{{ route('admin.bookings.edit', $booking->id) }}"
                                class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-stone-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 hover:bg-stone-200 dark:hover:bg-zinc-700 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                <span>Manage</span>
                            </a>
                            <button type="button"
                                @click.prevent="$dispatch('confirm-delete', { action: '{{ route('admin.bookings.destroy', $booking->id) }}', title: '{{ addslashes($booking->name) }} ({{ addslashes($booking->package) }})', itemType: 'booking' })"
                                class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-zinc-500 hover:text-red-600 hover:bg-red-50 dark:text-zinc-400 dark:hover:text-red-400 dark:hover:bg-red-950/30 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                <span>Trash</span>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-16 text-center">
                        <div class="mx-auto w-12 h-12 rounded-full bg-stone-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-400 mb-3">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-base font-semibold text-zinc-900 dark:text-zinc-100">No booking requests found</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1 max-w-sm mx-auto">
                            @if(request('search') || request('status'))
                                No reservations matched your active filter or search terms. Try clearing parameters.
                            @else
                                There are no incoming booking requests at this time.
                            @endif
                        </p>
                        @if(request('search') || request('status'))
                            <div class="mt-4">
                                <a href="{{ route('admin.bookings.index') }}"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-stone-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 text-xs font-medium hover:bg-stone-200 dark:hover:bg-zinc-700 transition">
                                    Clear all filters
                                </a>
                            </div>
                        @endif
                    </div>
                @endforelse
            </div>

            {{-- 2. DESKTOP DATA TABLE (Visible on screen >= md) --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full whitespace-nowrap text-left text-sm text-zinc-500 dark:text-zinc-400">
                    <thead class="bg-stone-50 dark:bg-zinc-800/60 text-zinc-700 dark:text-zinc-300 border-b border-stone-200 dark:border-zinc-800">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold uppercase tracking-wider text-xs">Client Info</th>
                            <th scope="col" class="px-6 py-4 font-semibold uppercase tracking-wider text-xs">Package & Location</th>
                            <th scope="col" class="px-6 py-4 font-semibold uppercase tracking-wider text-xs">Booking Date</th>
                            <th scope="col" class="px-6 py-4 font-semibold uppercase tracking-wider text-xs">Status</th>
                            <th scope="col" class="px-6 py-4 font-semibold uppercase tracking-wider text-xs text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-200 dark:divide-zinc-800">
                        @forelse($bookings as $booking)
                            @php
                                $dotColor = match ($booking->status) {
                                    'pending' => 'bg-amber-500',
                                    'confirmed' => 'bg-sky-500',
                                    'completed' => 'bg-emerald-500',
                                    default => 'bg-zinc-400',
                                };
                            @endphp
                            <tr class="hover:bg-stone-50 dark:hover:bg-zinc-800/40 transition duration-150">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-zinc-900 dark:text-white text-base">
                                        {{ $booking->name }}
                                    </div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                                        {{ $booking->phone }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-zinc-900 dark:text-zinc-100 font-medium">
                                        {{ $booking->package }}
                                    </div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                                        {{ $booking->location }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-zinc-900 dark:text-zinc-100 font-medium">
                                        {{ $booking->booking_date->format('d M Y') }}
                                    </div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                                        @if ($booking->booking_date->format('H:i') !== '00:00')
                                            <span class="font-mono">{{ $booking->booking_date->format('H:i') }}</span>
                                        @else
                                            <span class="text-zinc-400">Flexible</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-stone-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 border border-stone-200 dark:border-zinc-700">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                                        <span>{{ ucfirst($booking->status) }}</span>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-1 bg-stone-100 dark:bg-zinc-800 p-1 rounded-lg border border-stone-200 dark:border-zinc-700">
                                        <a href="{{ route('admin.bookings.edit', $booking->id) }}"
                                            class="p-1.5 rounded-md text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-white dark:hover:bg-zinc-700 transition"
                                            title="Manage Booking">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <button type="button"
                                            @click.prevent="$dispatch('confirm-delete', { action: '{{ route('admin.bookings.destroy', $booking->id) }}', title: '{{ addslashes($booking->name) }} ({{ addslashes($booking->package) }})', itemType: 'booking' })"
                                            class="p-1.5 rounded-md text-zinc-500 hover:text-red-600 hover:bg-white dark:hover:bg-zinc-700 dark:text-zinc-400 dark:hover:text-red-400 transition"
                                            title="Move to Trash">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="mx-auto w-12 h-12 rounded-full bg-stone-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-400 mb-3">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-base font-semibold text-zinc-900 dark:text-zinc-100">No booking requests found</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1 max-w-sm mx-auto">
                                        @if(request('search') || request('status'))
                                            No reservations matched your active filter or search terms. Try clearing parameters.
                                        @else
                                            There are no incoming booking requests at this time.
                                        @endif
                                    </p>
                                    @if(request('search') || request('status'))
                                        <div class="mt-4">
                                            <a href="{{ route('admin.bookings.index') }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-stone-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 text-xs font-medium hover:bg-stone-200 dark:hover:bg-zinc-700 transition">
                                                Clear all filters
                                            </a>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($bookings->hasPages())
                <div class="px-6 py-4 border-t border-stone-200 dark:border-zinc-800 bg-white dark:bg-zinc-900">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
