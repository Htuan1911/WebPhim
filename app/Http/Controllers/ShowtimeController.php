<?php

namespace App\Http\Controllers;

use App\Models\Showtime;
use App\Models\Movie;
use App\Models\Theater;
use App\Models\CinemaRoom;
use Illuminate\Http\Request;

class ShowtimeController extends Controller
{
    public function index()
    {
        $showtimes = Showtime::with(['movie', 'theater', 'cinemaRoom'])->paginate(10);
        return view('admin.showtimes.index', compact('showtimes'));
    }

    public function create()
    {
        $movies = Movie::all();
        $theaters = Theater::all();
        $cinemaRooms = CinemaRoom::all();

        return view('admin.showtimes.create', compact('movies', 'theaters', 'cinemaRooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'movie_id'      => 'required|exists:movies,id',
            'theater_id'    => 'required|exists:theaters,id',
            'cinema_room_id'=> 'required|exists:cinema_rooms,id',
            'ticket_price'  => 'required|numeric|min:0',
            'start_time'    => 'required|date',
        ]);

        Showtime::create($request->all());

        return redirect()->route('admin.showtimes.index')->with('success', 'Thêm lịch chiếu thành công!');
    }

    public function edit($id)
    {
        $showtime = Showtime::findOrFail($id);
        $movies = Movie::all();
        $theaters = Theater::all();
        $cinemaRooms = CinemaRoom::all();

        return view('admin.showtimes.edit', compact('showtime', 'movies', 'theaters', 'cinemaRooms'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'movie_id'      => 'required|exists:movies,id',
            'theater_id'    => 'required|exists:theaters,id',
            'cinema_room_id'=> 'required|exists:cinema_rooms,id',
            'ticket_price'  => 'required|numeric|min:0',
            'start_time'    => 'required|date',
        ]);

        $showtime = Showtime::findOrFail($id);
        $showtime->update($request->all());

        return redirect()->route('admin.showtimes.index')->with('success', 'Cập nhật lịch chiếu thành công!');
    }

    public function destroy($id)
    {
        $showtime = Showtime::findOrFail($id);
        $showtime->delete();

        return redirect()->route('admin.showtimes.index')->with('success', 'Xóa lịch chiếu thành công!');
    }
}
