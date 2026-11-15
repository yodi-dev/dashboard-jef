@section('title', 'Manage Bookings')

<x-app-layout>
    <div class="space-y-6">

        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                Manage Bookings
            </h1>
        </div>

        {{-- Main Container Card --}}
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700">

            {{-- 1. MOBILE CARD LIST VIEW (Visible on mobile/tablet < md) --}}
            <div class="md:hidden divide-y divide-gray-200 dark:divide-gray-700">
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
                                <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                                    {{ $booking->name }}
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    {{ $booking->phone }}
                                </p>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-stone-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-stone-200 dark:border-zinc-700">
                                <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                                <span>{{ ucfirst($booking->status) }}</span>
                            </span>
                        </div>

                        {{-- Middle: Details Grid --}}
                        <div class="grid grid-cols-2 gap-2 text-xs pt-1 text-gray-600 dark:text-gray-300">
                            <div>
                                <span class="text-gray-400 block mb-0.5">Package</span>
                                <span class="font-medium text-gray-800 dark:text-gray-200">{{ $booking->package }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400 block mb-0.5">Location</span>
                                <span class="font-medium text-gray-800 dark:text-gray-200">{{ $booking->location }}</span>
                            </div>
                            <div class="col-span-2 pt-1 border-t border-gray-100 dark:border-gray-700/60">
                                <span class="text-gray-400">Date: </span>
                                <span class="font-medium text-gray-800 dark:text-gray-200">
                                    {{ $booking->booking_date->format('l, d M Y') }}
                                    @if ($booking->booking_date->format('H:i') !== '00:00')
                                        - <span class="font-mono">{{ $booking->booking_date->format('H:i') }}</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        {{-- Bottom: Action Buttons --}}
                        <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-100 dark:border-gray-700/60 text-xs font-medium">
                            <a href="{{ route('admin.bookings.edit', $booking->id) }}"
                                class="px-3 py-1.5 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                                Manage
                            </a>
                            <form action="{{ route('admin.bookings.destroy', $booking->id) }}"
                                method="POST"
                                onsubmit="return confirm('Move this booking to trash?');"
                                class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1.5 rounded-lg text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-stone-100 dark:hover:bg-zinc-800 transition">
                                    Trash
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-lg font-medium">No booking requests found</p>
                    </div>
                @endforelse
            </div>

            {{-- 2. DESKTOP DATA TABLE (Visible on screen >= md) --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full whitespace-nowrap text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold uppercase tracking-wider text-xs">Client Info</th>
                            <th scope="col" class="px-6 py-4 font-semibold uppercase tracking-wider text-xs">Package & Location</th>
                            <th scope="col" class="px-6 py-4 font-semibold uppercase tracking-wider text-xs">Booking Date</th>
                            <th scope="col" class="px-6 py-4 font-semibold uppercase tracking-wider text-xs">Status</th>
                            <th scope="col" class="px-6 py-4 font-semibold uppercase tracking-wider text-xs text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition duration-150">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900 dark:text-white text-base">
                                        {{ $booking->name }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                        {{ $booking->phone }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-900 dark:text-gray-100 font-medium">
                                        {{ $booking->package }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                        {{ $booking->location }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-900 dark:text-gray-100 font-medium">
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
                                    @php
                                        $dotColor = match ($booking->status) {
                                            'pending' => 'bg-amber-500',
                                            'confirmed' => 'bg-sky-500',
                                            'completed' => 'bg-emerald-500',
                                            default => 'bg-zinc-400',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-stone-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-stone-200 dark:border-zinc-700">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                                        <span>{{ ucfirst($booking->status) }}</span>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-1.5">
                                    <a href="{{ route('admin.bookings.edit', $booking->id) }}"
                                        class="inline-flex items-center text-xs font-semibold px-2.5 py-1.5 rounded-lg bg-stone-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 hover:bg-stone-200 dark:hover:bg-zinc-700 transition">
                                        Manage
                                    </a>
                                    <form action="{{ route('admin.bookings.destroy', $booking->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Move this booking to trash?');"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center text-xs font-semibold px-2.5 py-1.5 rounded-lg text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-stone-100 dark:hover:bg-zinc-800 transition">
                                            Trash
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-lg font-medium">No booking requests found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($bookings->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
