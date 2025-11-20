<?php

namespace App\Http\Controllers;

use App\Models\Theater;
use App\Models\CinemaCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TheaterController extends Controller
{
    public function index()
    {
        $theaters = Theater::with('cinemaCategory')->latest()->paginate(12);
        return view('admin.theaters.index', compact('theaters'));
    }

    public function create()
    {
        $categories = CinemaCategory::where('is_active', true)->orderBy('priority', 'desc')->get();
        return view('admin.theaters.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'cinema_category_id'=> 'required|exists:cinema_categories,id',
            'total_seats'       => 'required|integer|min:20|max:500',
            'image'             => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048',
            'address'           => 'nullable|string|max:500',
            'phone'             => 'nullable|string|max:20',
        ]);

        $data = $request->only([
            'name', 'cinema_category_id', 'total_seats', 'address', 'phone'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('theaters', 'public');
        }

        Theater::create($data);

        return redirect()->route('admin.theaters.index')
            ->with('success', 'Thêm rạp chiếu thành công!');
    }

    public function edit($id)
    {
        $theater = Theater::findOrFail($id);
        $categories = CinemaCategory::where('is_active', true)
            ->orderBy('priority', 'desc')
            ->get();

        return view('admin.theaters.edit', compact('theater', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $theater = Theater::findOrFail($id);

        $request->validate([
            'name'              => 'required|string|max:255',
            'cinema_category_id'=> 'required|exists:cinema_categories,id',
            'total_seats'       => 'required|integer|min:20|max:500',
            'image'             => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048',
            'address'           => 'nullable|string|max:500',
            'phone'             => 'nullable|string|max:20',
        ]);

        $data = $request->only([
            'name', 'cinema_category_id', 'total_seats', 'address', 'phone'
        ]);

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ
            if ($theater->image) {
                Storage::disk('public')->delete($theater->image);
            }
            $data['image'] = $request->file('image')->store('theaters', 'public');
        }

        $theater->update($data);

        return redirect()->route('admin.theaters.index')
            ->with('success', 'Cập nhật rạp thành công!');
    }

    public function destroy($id)
    {
        $theater = Theater::findOrFail($id);

        // Kiểm tra nếu rạp đang có phòng chiếu hoặc suất chiếu → không cho xóa
        if ($theater->cinemaRooms()->exists() || $theater->showtimes()->exists()) {
            return back()->withErrors('Không thể xóa rạp này vì đang có phòng chiếu hoặc suất chiếu!');
        }

        if ($theater->image) {
            Storage::disk('public')->delete($theater->image);
        }

        $theater->delete();

        return redirect()->route('admin.theaters.index')
            ->with('success', 'Xóa rạp thành công!');
    }
}