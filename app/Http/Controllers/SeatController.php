<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use App\Models\CinemaRoom;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function index()
    {
        $seats = Seat::with('cinemaRoom')->paginate(20);
        return view('admin.seats.index', compact('seats'));
    }

    public function create()
    {
        $cinemaRooms = CinemaRoom::all();
        return view('admin.seats.create', compact('cinemaRooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cinema_room_id' => 'required|exists:cinema_rooms,id',
            'seat_number'    => 'required|string|max:10',
        ]);

        Seat::create($request->all());

        return redirect()->route('admin.seats.index')->with('success', 'Thêm ghế thành công!');
    }

    public function edit($id)
    {
        $seat = Seat::findOrFail($id);
        $cinemaRooms = CinemaRoom::all();
        return view('admin.seats.edit', compact('seat', 'cinemaRooms'));
    }

    public function update(Request $request, $id)
    {
        $seat = Seat::findOrFail($id);

        $request->validate([
            'cinema_room_id' => 'required|exists:cinema_rooms,id',
            'seat_number'    => 'required|string|max:10',
        ]);

        $seat->update($request->all());

        return redirect()->route('admin.seats.index')->with('success', 'Cập nhật ghế thành công!');
    }

    public function destroy($id)
    {
        Seat::findOrFail($id)->delete();
        return redirect()->route('admin.seats.index')->with('success', 'Xóa ghế thành công!');
    }
}
