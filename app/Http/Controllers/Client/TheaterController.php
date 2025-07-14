<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Theater;

class TheaterController extends Controller
{
    // Hiển thị danh sách tất cả các rạp chiếu
    public function index()
    {
        $theaters = Theater::orderBy('name')->get();
        return view('client.theaters.index', compact('theaters'));
    }

    // Hiển thị chi tiết 1 rạp, kèm các phòng và suất chiếu trong rạp
    public function show($id)
    {
        $theater = Theater::with([
            'cinemaRooms.showtimes.movie'
        ])->findOrFail($id);

        return view('client.theaters.show', compact('theater'));
    }
}
