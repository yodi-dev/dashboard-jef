<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Services\BookingNotificationService;

class BookingController extends Controller
{
    public function store(StoreBookingRequest $request, BookingNotificationService $notificationService)
    {
        $booking = Booking::create($request->validated());

        // Dispatch dual-channel notifications (Email & WhatsApp to Public Profile targets)
        $notificationService->notify($booking);

        return (new BookingResource($booking))
            ->response()
            ->setStatusCode(201);
    }
}
