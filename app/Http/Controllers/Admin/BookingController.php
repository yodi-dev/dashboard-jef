<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::query();

        // Search query
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('package', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Status tab filter
        $status = $request->input('status', 'all');
        if (in_array($status, ['pending', 'confirmed', 'completed', 'canceled'])) {
            $query->where('status', $status);
        }

        // Counts for filter tabs
        $counts = [
            'all' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'canceled' => Booking::where('status', 'canceled')->count(),
        ];

        $bookings = $query->latest()->paginate(10)->withQueryString();

        return view('admin.bookings.index', compact('bookings', 'counts', 'status'));
    }

    public function show(Booking $booking)
    {
        return redirect()->route('admin.bookings.edit', $booking);
    }

    public function edit(Booking $booking)
    {
        return view('admin.bookings.edit', compact('booking'));
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $booking->update($request->validated());

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking status successfully updated!');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking data moved to Trash!');
    }

    public function restore(Booking $booking)
    {
        $booking->restore();

        return back()->with('success', 'Booking successfully restored!');
    }

    // Hapus permanen
    public function forceDestroy(Booking $booking)
    {
        $booking->forceDelete();

        return back()->with('success', 'Booking permanently deleted!');
    }
}
