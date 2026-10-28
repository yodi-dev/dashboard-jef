<x-app-layout>
    <div class="space-y-6">

        {{-- Header & Back Button --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                Manage Booking #{{ $booking->id }}
            </h1>
            <a href="{{ route('admin.bookings.index') }}"
                class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg text-sm font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150 inline-flex items-center gap-1 w-fit">
                &larr; Back to List
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- KOLOM KIRI: Info Klien (Read-Only) --}}
            <div class="md:col-span-2 bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b pb-3 mb-4 dark:border-gray-700">
                    Client Details & Request
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-xs uppercase tracking-wider font-semibold text-gray-500 dark:text-gray-400 mb-1">Full Name</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $booking->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider font-semibold text-gray-500 dark:text-gray-400 mb-1">Contact</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $booking->phone }} <br>
                            <a href="mailto:{{ $booking->email }}"
                                class="text-green-600 dark:text-green-400 hover:underline text-sm">{{ $booking->email }}</a>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider font-semibold text-gray-500 dark:text-gray-400 mb-1">Photography Package</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $booking->package }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider font-semibold text-gray-500 dark:text-gray-400 mb-1">Location</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $booking->location }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider font-semibold text-gray-500 dark:text-gray-400 mb-1">Requested Date & Time</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $booking->booking_date->format('l, d F Y') }} <br>
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $booking->booking_date->format('H:i') }} WIB</span>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider font-semibold text-gray-500 dark:text-gray-400 mb-1">Submitted At</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100 text-sm">
                            {{ $booking->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-wider font-semibold text-gray-500 dark:text-gray-400 mb-2">Message from Client:</p>
                    <div class="bg-gray-50 dark:bg-gray-900/60 p-4 rounded-lg text-sm text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 whitespace-pre-line leading-relaxed">
                        {{ $booking->message ?: 'No additional message provided.' }}
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: Form Aksi Admin --}}
            <div class="md:col-span-1 bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 border border-gray-200 dark:border-gray-700 h-fit">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b pb-3 mb-4 dark:border-gray-700">
                    Admin Action
                </h3>

                <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Update Status --}}
                    <div class="mb-5">
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Booking Status
                        </label>
                        <select name="status" id="status"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 text-sm py-2">
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="canceled" {{ $booking->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Admin Notes --}}
                    <div class="mb-5">
                        <label for="admin_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Internal Notes <span class="text-xs text-gray-400 font-normal">(Admin only)</span>
                        </label>
                        <textarea name="admin_notes" id="admin_notes" rows="4"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 text-sm"
                            placeholder="E.g. DP 50% paid, needs specific lens...">{{ old('admin_notes', $booking->admin_notes) }}</textarea>
                        @error('admin_notes')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 px-4 rounded-lg transition duration-150 shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        Save Changes
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
