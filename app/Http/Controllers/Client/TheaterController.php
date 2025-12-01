<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Theater;

class TheaterController extends Controller
{
    public function index()
    {
        $theaters = Theater::orderBy('name')->get();
        return view('client.theaters.index', compact('theaters'));
    }

    public function show($id)
    {
        $theater = Theater::with([
            'cinemaRooms.showtimes.movie'
        ])->findOrFail($id);

        return view('client.theaters.show', compact('theater'));
    }
}
