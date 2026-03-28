{{-- blade-formatter-disable --}}
<x-mail::message>
# Hello Admin, you have a new booking request! 🎉

Someone just requested a photography booking through your portfolio website. Here are the details:

<x-mail::panel>
**Client Name:** {{ $booking->name }}<br>
**Email:** {{ $booking->email }}<br>
**Phone / WA:** {{ $booking->phone }}<br>
**Package:** {{ $booking->package }}<br>
**Location:** {{ $booking->location }}<br>
**Date & Time:** {{ $booking->booking_date->format('l, d F Y - H:i') }} WIB
</x-mail::panel>

**Message from Client:**
> _{{ $booking->message ?: 'No additional message provided.' }}_

Please check your admin dashboard to confirm the schedule and contact the client.

<x-mail::button :url="route('admin.bookings.edit', $booking->id)">
View Details in Dashboard
</x-mail::button>

Happy capturing!<br>
{{ config('app.name') }} Notification System
</x-mail::message>
{{-- blade-formatter-enable --}}
