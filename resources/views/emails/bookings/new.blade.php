{{-- blade-formatter-disable --}}
<x-mail::message>
# Hello Admin, you have a new booking request

Someone just requested a photography booking through your portfolio website. Here are the details:

<x-mail::panel>
**Client Name:** {{ $booking->name }}<br>
**Email:** {{ $booking->email }}<br>
**Phone / WA:** {{ $booking->phone }}<br>
**Package:** {{ $booking->package }}<br>
**Location:** {{ $booking->location }}<br>
**Date & Time:** {{ $booking->booking_date->format('l, d F Y - H:i') }}
</x-mail::panel>

**Message from Client:**
> _{{ $booking->message ?: 'No additional message provided.' }}_

Please check your admin dashboard to confirm the schedule and contact the client.

@php
    $cleanClientPhone = preg_replace('/[^0-9]/', '', $booking->phone);
    if (str_starts_with($cleanClientPhone, '08')) {
        $cleanClientPhone = '62' . substr($cleanClientPhone, 1);
    }
    $waChatUrl = 'https://wa.me/' . $cleanClientPhone . '?text=' . urlencode("Hello {$booking->name}, thank you for your booking request for {$booking->package} with Jef Lee Studio.");
@endphp

<x-mail::button :url="$waChatUrl">
Chat with Client on WhatsApp
</x-mail::button>

<x-mail::button :url="route('admin.bookings.edit', $booking->id)">
View Details in Dashboard
</x-mail::button>

Happy capturing!<br>
{{ config('app.name') }} Notification System
</x-mail::message>
{{-- blade-formatter-enable --}}
