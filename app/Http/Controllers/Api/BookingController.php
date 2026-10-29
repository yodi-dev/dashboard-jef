<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\BookingResource;
use App\Mail\NewBookingNotification;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function store(StoreBookingRequest $request)
    {
        $booking = Booking::create($request->validated());

        // Send email notification to admin with fail-safe error handling
        $adminEmail = config('mail.admin_address', 'admin@jef.com');

        try {
            Mail::to($adminEmail)->send(new NewBookingNotification($booking));
        } catch (\Throwable $e) {
            Log::warning('Failed to send booking notification email: ' . $e->getMessage(), [
                'booking_id' => $booking->id,
                'client_email' => $booking->email,
            ]);
        }

        return (new BookingResource($booking))
            ->response()
            ->setStatusCode(201);
    }
}
