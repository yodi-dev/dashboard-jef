<x-app-layout>
    <div class="container mx-auto px-4 sm:px-8 py-8">

        {{-- Header & Back Button --}}
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Manage Booking #{{ $booking->id }}
            </h2>
            <a href="{{ route('admin.bookings.index') }}"
                class="text-sm bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 py-2 px-4 rounded transition">
                &larr; Back to List
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- KOLOM KIRI: Info Klien (Read-Only) --}}
            <div
                class="md:col-span-2 bg-white dark:bg-gray-800 shadow rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3
                    class="text-lg font-semibold text-gray-800 dark:text-gray-200 border-b pb-3 mb-4 dark:border-gray-700">
                    Client Details & Request
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Full Name</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $booking->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Contact</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $booking->phone }} <br>
                            <a href="mailto:{{ $booking->email }}"
                                class="text-blue-500 hover:underline">{{ $booking->email }}</a>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Photography Package</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $booking->package }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Location</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $booking->location }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Requested Date & Time</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $booking->booking_date->format('l, d F Y') }} <br>
                            {{ $booking->booking_date->format('H:i') }} WIB
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Submitted At</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $booking->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Message from Client:</p>
                    <div
                        class="bg-gray-50 dark:bg-gray-900 p-4 rounded text-sm text-gray-700 dark:text-gray-300 border dark:border-gray-700">
                        {{ $booking->message ?: 'No additional message provided.' }}
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: Form Aksi Admin --}}
            <div
                class="md:col-span-1 bg-white dark:bg-gray-800 shadow rounded-lg p-6 border border-gray-200 dark:border-gray-700 h-fit">
                <h3
                    class="text-lg font-semibold text-gray-800 dark:text-gray-200 border-b pb-3 mb-4 dark:border-gray-700">
                    Admin Action
                </h3>

                <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Update Status --}}
                    <div class="mb-5">
                        <label for="status"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Booking
                            Status</label>
                        <select name="status" id="status"
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed
                            </option>
                            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="canceled" {{ $booking->status == 'canceled' ? 'selected' : '' }}>Canceled
                            </option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Admin Notes --}}
                    <div class="mb-5">
                        <label for="admin_notes"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Internal Notes <span class="text-xs text-gray-400 font-normal">(Hidden from client)</span>
                        </label>
                        <textarea name="admin_notes" id="admin_notes" rows="4"
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="E.g. DP 50% paid, needs specific lens...">{{ old('admin_notes', $booking->admin_notes) }}</textarea>
                        @error('admin_notes')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                        Save Changes
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
