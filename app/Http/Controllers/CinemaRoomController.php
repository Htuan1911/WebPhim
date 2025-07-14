<?php

namespace App\Http\Controllers;

use App\Models\CinemaRoom;
use App\Models\Theater;
use Illuminate\Http\Request;

class CinemaRoomController extends Controller
{
    public function index()
    {
        $rooms = CinemaRoom::with('theater')->latest()->paginate(10);
        return view('admin.cinema-rooms.index', compact('rooms'));
    }

    public function create()
    {
        $theaters = Theater::all();
        return view('admin.cinema-rooms.create', compact('theaters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'total_seats' => 'required|integer|min:1',
            'theater_id' => 'required|exists:theaters,id',
        ]);

        CinemaRoom::create($request->all());
        return redirect()->route('admin.cinema-rooms.index')->with('success', 'Thêm phòng chiếu thành công!');
    }

    public function edit($id)
    {
        $room = CinemaRoom::findOrFail($id);
        $theaters = Theater::all();
        return view('admin.cinema-rooms.edit', compact('room', 'theaters'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'total_seats' => 'required|integer|min:1',
            'theater_id' => 'required|exists:theaters,id',
        ]);

        $room = CinemaRoom::findOrFail($id);
        $room->update($request->all());
        return redirect()->route('admin.cinema-rooms.index')->with('success', 'Cập nhật phòng chiếu thành công!');
    }

    public function destroy($id)
    {
        $room = CinemaRoom::findOrFail($id);
        $room->delete();
        return redirect()->route('admin.cinema-rooms.index')->with('success', 'Xóa phòng chiếu thành công!');
    }
}
