<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\BookingResource;
use App\Mail\NewBookingNotification;
use App\Models\Booking;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function store(StoreBookingRequest $request)
    {
        $booking = Booking::create($request->validated());

        Mail::to('dykhazta@gmail.com')->send(new NewBookingNotification($booking));

        return new BookingResource($booking);
    }
}
