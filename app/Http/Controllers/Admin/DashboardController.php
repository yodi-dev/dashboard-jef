<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data untuk Top Summary Cards
        $pendingBookingsCount = Booking::where('status', 'pending')->count();
        $confirmedBookingsCount = Booking::where('status', 'confirmed')->count();
        $completedBookingsCount = Booking::where('status', 'completed')->count();
        $publishedPortfoliosCount = Portfolio::where('is_published', true)->count();

        // 2. Data untuk Tabel Recent Bookings (Ambil 5 terbaru)
        $recentBookings = Booking::latest()->take(5)->get();

        return view('dashboard', compact(
            'pendingBookingsCount',
            'confirmedBookingsCount',
            'completedBookingsCount',
            'publishedPortfoliosCount',
            'recentBookings'
        ));
    }
}
