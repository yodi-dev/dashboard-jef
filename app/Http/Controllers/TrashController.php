<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Booking;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function __invoke(Request $request)
    {
        $trashedPortfolios = Portfolio::onlyTrashed()->latest()->get();
        $trashedArticles = Article::onlyTrashed()->latest()->get();
        $trashedBookings   = Booking::onlyTrashed()->latest()->get();

        return view('admin.trash.index', compact('trashedPortfolios', 'trashedArticles', 'trashedBookings'));
    }
}
