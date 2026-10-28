<x-app-layout>
    <div class="space-y-6">

        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                Manage Bookings
            </h1>
        </div>

        {{-- Flash Message with Close Button --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition
                class="px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded-lg relative flex items-center justify-between shadow-sm"
                role="alert">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="block sm:inline font-medium">{{ session('success') }}</span>
                </div>
                <button @click="show = false"
                    class="text-green-700 hover:text-green-900 focus:outline-none transition-colors">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        {{-- Table Section --}}
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
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
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                        {{ $booking->booking_date->format('H:i') }} WIB
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $badgeClass = match ($booking->status) {
                                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300 border border-yellow-200 dark:border-yellow-800/50',
                                            'confirmed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300 border border-blue-200 dark:border-blue-800/50',
                                            'completed' => 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300 border border-green-200 dark:border-green-800/50',
                                            'canceled' => 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300 border border-red-200 dark:border-red-800/50',
                                            default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                        {{ strtoupper($booking->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.bookings.edit', $booking->id) }}"
                                        class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        Manage
                                    </a>
                                    <span class="text-gray-300 dark:text-gray-600">|</span>
                                    <form action="{{ route('admin.bookings.destroy', $booking->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this booking?');"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center text-sm font-medium text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                            Delete
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
