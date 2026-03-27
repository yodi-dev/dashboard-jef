<x-app-layout>
    <div class="container mx-auto px-4 sm:px-8">
        <div class="py-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Manage Bookings
                </h2>
            </div>

            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                <div
                    class="inline-block min-w-full shadow rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full leading-normal bg-white dark:bg-gray-800">
                        <thead>
                            <tr>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Client Info
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Package & Location
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Booking Date
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 text-sm">
                                        <p class="text-gray-900 dark:text-gray-100 font-semibold whitespace-no-wrap">
                                            {{ $booking->name }}</p>
                                        <p class="text-gray-500 dark:text-gray-400 text-xs">{{ $booking->phone }}</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 text-sm">
                                        <p class="text-gray-900 dark:text-gray-100 whitespace-no-wrap">
                                            {{ $booking->package }}</p>
                                        <p class="text-gray-500 dark:text-gray-400 text-xs">{{ $booking->location }}</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 text-sm">
                                        <p class="text-gray-900 dark:text-gray-100 whitespace-no-wrap">
                                            {{ $booking->booking_date->format('d M Y') }}
                                        </p>
                                        <p class="text-gray-500 dark:text-gray-400 text-xs">
                                            {{ $booking->booking_date->format('H:i') }} WIB
                                        </p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 text-sm">
                                        @php
                                            $color = match ($booking->status) {
                                                'pending' => 'bg-yellow-200 text-yellow-800',
                                                'confirmed' => 'bg-blue-200 text-blue-800',
                                                'completed' => 'bg-green-200 text-green-800',
                                                'canceled' => 'bg-red-200 text-red-800',
                                                default => 'bg-gray-200 text-gray-800',
                                            };
                                        @endphp
                                        <span
                                            class="relative inline-block px-3 py-1 font-semibold {{ $color }} rounded-full leading-tight text-xs">
                                            <span class="relative uppercase">{{ $booking->status }}</span>
                                        </span>
                                    </td>
                                    <td
                                        class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 text-sm text-center">
                                        <div class="flex items-center justify-center gap-3">
                                            {{-- Tombol Edit/Show --}}
                                            <a href="{{ route('admin.bookings.edit', $booking->id) }}"
                                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                Manage
                                            </a>

                                            {{-- Form Delete --}}
                                            <form action="{{ route('admin.bookings.destroy', $booking->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this booking?');"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-10 text-center text-gray-500 dark:text-gray-400">
                                        No booking requests found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
