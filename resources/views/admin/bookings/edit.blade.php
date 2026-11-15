@section('title', 'Manage Booking #' . $booking->id)

<x-app-layout>
    <div class="space-y-6">

        {{-- Header & Back Button --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                    Manage Booking <span class="text-zinc-500 dark:text-zinc-400 font-mono text-xl">#{{ $booking->id }}</span>
                </h1>
                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                    Submitted {{ $booking->created_at->diffForHumans() }} ({{ $booking->created_at->format('d M Y, H:i') }})
                </p>
            </div>
            <a href="{{ route('admin.bookings.index') }}"
                class="px-4 py-2 bg-stone-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 rounded-lg text-sm font-medium hover:bg-stone-200 dark:hover:bg-zinc-700 transition duration-150 inline-flex items-center gap-1.5 w-fit border border-stone-200 dark:border-zinc-700">
                &larr; Back to List
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- KOLOM KIRI: Info Klien & Komunikasi 1-Klik --}}
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white dark:bg-zinc-900 shadow-sm rounded-xl p-6 border border-stone-200 dark:border-zinc-800">
                    <div class="flex items-center justify-between border-b pb-4 mb-5 border-stone-200 dark:border-zinc-800">
                        <h3 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">
                            Client Details & Session Request
                        </h3>
                        @php
                            $dotColor = match ($booking->status) {
                                'pending' => 'bg-amber-500',
                                'confirmed' => 'bg-sky-500',
                                'completed' => 'bg-emerald-500',
                                default => 'bg-zinc-400',
                            };
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-stone-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-stone-200 dark:border-zinc-700">
                            <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                            <span>{{ ucfirst($booking->status) }}</span>
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
                        <div>
                            <p class="text-xs uppercase tracking-wider font-semibold text-zinc-400 dark:text-zinc-500 mb-1">Full Name</p>
                            <p class="font-medium text-base text-zinc-900 dark:text-zinc-100">{{ $booking->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wider font-semibold text-zinc-400 dark:text-zinc-500 mb-1">Contact</p>
                            <p class="font-medium text-zinc-900 dark:text-zinc-100">
                                {{ $booking->phone }} <br>
                                <a href="mailto:{{ $booking->email }}"
                                    class="text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200 underline text-sm">{{ $booking->email }}</a>
                            </p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wider font-semibold text-zinc-400 dark:text-zinc-500 mb-1">Photography Package</p>
                            <p class="font-medium text-zinc-900 dark:text-zinc-100">{{ $booking->package }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wider font-semibold text-zinc-400 dark:text-zinc-500 mb-1">Location</p>
                            <p class="font-medium text-zinc-900 dark:text-zinc-100">{{ $booking->location }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wider font-semibold text-zinc-400 dark:text-zinc-500 mb-1">Requested Session Time</p>
                            <p class="font-medium text-zinc-900 dark:text-zinc-100 text-sm">
                                {{ $booking->booking_date->format('l, d F Y') }} <br>
                                @if ($booking->booking_date->format('H:i') !== '00:00')
                                    <span class="text-xs text-zinc-600 dark:text-zinc-400 font-mono">{{ $booking->booking_date->format('H:i') }}</span>
                                @else
                                    <span class="text-xs text-zinc-400 dark:text-zinc-500 font-normal">Full Day / Schedule to be confirmed</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wider font-semibold text-zinc-400 dark:text-zinc-500 mb-1">Submitted At</p>
                            <p class="font-medium text-zinc-900 dark:text-zinc-100 text-sm font-mono">
                                {{ $booking->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                    </div>

                    {{-- 1-Click Outreach Shortcuts (WhatsApp & Email Direct) --}}
                    @php
                        $cleanPhone = preg_replace('/[^0-9]/', '', (string) ($booking->phone ?? ''));
                        if (str_starts_with($cleanPhone, '08')) {
                            $waPhone = '62' . substr($cleanPhone, 1);
                        } elseif (str_starts_with($cleanPhone, '0')) {
                            $waPhone = '61' . substr($cleanPhone, 1);
                        } else {
                            $waPhone = $cleanPhone;
                        }
                        $waMessage = "Hi {$booking->name}, this is Jef regarding your {$booking->package} photography booking request scheduled for {$booking->booking_date->format('d M Y')}.";
                        $waUrl = !empty($waPhone) ? "https://wa.me/{$waPhone}?text=" . urlencode($waMessage) : '#';
                        $mailSubject = "Photography Session Inquiry ({$booking->package}) - Jef Lee";
                        $mailBody = "Hi {$booking->name},\n\nThank you for reaching out regarding the {$booking->package} photography session on {$booking->booking_date->format('l, d F Y')}.\n\nBest regards,\nJef Lee";
                        $mailUrl = "mailto:{$booking->email}?subject=" . urlencode($mailSubject) . "&body=" . urlencode($mailBody);
                        $gcalStartDate = $booking->booking_date->format('H:i') !== '00:00'
                            ? $booking->booking_date->format('Ymd\THis')
                            : $booking->booking_date->format('Ymd');
                        $gcalEndDate = $booking->booking_date->format('H:i') !== '00:00'
                            ? $booking->booking_date->copy()->addHours(2)->format('Ymd\THis')
                            : $booking->booking_date->copy()->addDay()->format('Ymd');
                        $gcalUrl = "https://calendar.google.com/calendar/render?action=TEMPLATE&text=" . urlencode("Photo Session: {$booking->name} ({$booking->package})") . "&dates={$gcalStartDate}/{$gcalEndDate}&details=" . urlencode("Client: {$booking->name}\nPhone: {$booking->phone}\nEmail: {$booking->email}\nPackage: {$booking->package}") . "&location=" . urlencode($booking->location);
                    @endphp
                    <div class="pt-4 border-t border-stone-200 dark:border-zinc-800">
                        <p class="text-xs uppercase tracking-wider font-semibold text-zinc-400 dark:text-zinc-500 mb-2.5">Quick Client Outreach</p>
                        <div class="flex flex-wrap gap-2.5">
                            <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-stone-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 border border-stone-200 dark:border-zinc-700 hover:bg-stone-200 dark:hover:bg-zinc-700 text-xs font-semibold transition shadow-sm">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                </svg>
                                <span>WhatsApp Client</span>
                            </a>
                            <a href="{{ $mailUrl }}"
                                class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-stone-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 border border-stone-200 dark:border-zinc-700 hover:bg-stone-200 dark:hover:bg-zinc-700 text-xs font-semibold transition shadow-sm">
                                <svg class="w-4 h-4 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span>Send Email</span>
                            </a>
                            <a href="{{ $gcalUrl }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-stone-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 border border-stone-200 dark:border-zinc-700 hover:bg-stone-200 dark:hover:bg-zinc-700 text-xs font-semibold transition shadow-sm">
                                <svg class="w-4 h-4 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>Add to Calendar</span>
                            </a>
                        </div>
                    </div>

                    <div class="mt-6 pt-5 border-t border-stone-200 dark:border-zinc-800">
                        <p class="text-xs uppercase tracking-wider font-semibold text-zinc-400 dark:text-zinc-500 mb-2">Message from Client:</p>
                        <div class="bg-stone-50 dark:bg-zinc-950/60 p-4 rounded-xl text-sm text-zinc-700 dark:text-zinc-300 border border-stone-200 dark:border-zinc-800 whitespace-pre-line leading-relaxed">
                            {{ $booking->message ?: 'No additional message provided.' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: Form Aksi Admin --}}
            <div class="md:col-span-1 bg-white dark:bg-zinc-900 shadow-sm rounded-xl p-6 border border-stone-200 dark:border-zinc-800 h-fit">
                <h3 class="text-base font-semibold text-zinc-900 dark:text-zinc-100 border-b pb-3 mb-5 border-stone-200 dark:border-zinc-800">
                    Session Status & Notes
                </h3>

                <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Update Status --}}
                    <div class="mb-5">
                        <label for="status" class="block text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 mb-2">
                            Session Status
                        </label>
                        <select name="status" id="status"
                            class="w-full rounded-lg border-stone-300 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:focus:border-zinc-100 dark:focus:ring-zinc-100 text-sm py-2.5">
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending (New Request)</option>
                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed (Session Booked)</option>
                            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed (Delivered)</option>
                            <option value="canceled" {{ $booking->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                        @error('status')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Admin Notes --}}
                    <div class="mb-5">
                        <label for="admin_notes" class="block text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 mb-2">
                            Internal Studio Notes <span class="text-zinc-400 font-normal lowercase">(private)</span>
                        </label>
                        <textarea name="admin_notes" id="admin_notes" rows="4"
                            class="w-full rounded-lg border-stone-300 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:focus:border-zinc-100 dark:focus:ring-zinc-100 text-sm"
                            placeholder="E.g. Deposit received, lens prep, location permit...">{{ old('admin_notes', $booking->admin_notes) }}</textarea>
                        @error('admin_notes')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="w-full bg-zinc-900 hover:bg-zinc-800 text-white dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-white font-medium py-2.5 px-4 rounded-lg transition duration-150 shadow-sm focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:ring-offset-2 text-sm">
                        Save Status & Notes
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
