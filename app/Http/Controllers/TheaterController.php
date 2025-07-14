<?php

namespace App\Http\Controllers;

use App\Models\Theater;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TheaterController extends Controller
{
    public function index()
    {
        $theaters = Theater::latest()->paginate(10);
        return view('admin.theaters.index', compact('theaters'));
    }

    public function create()
    {
        return view('admin.theaters.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',  // thêm dòng này
            'total_seats' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp',
        ]);

        $data = $request->only(['name', 'category', 'total_seats']); // lấy thêm category

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('theaters', 'public');
        }

        Theater::create($data);

        return redirect()->route('admin.theaters.index')->with('success', 'Thêm rạp thành công!');
    }

    public function edit($id)
    {
        $theater = Theater::findOrFail($id);
        return view('admin.theaters.edit', compact('theater'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255', // thêm dòng này
            'total_seats' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp',
        ]);

        $theater = Theater::findOrFail($id);
        $data = $request->only(['name', 'category', 'total_seats']); // lấy thêm category

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('theaters', 'public');
        }

        $theater->update($data);

        return redirect()->route('admin.theaters.index')->with('success', 'Cập nhật rạp thành công!');
    }
    public function destroy($id)
    {
        $theater = Theater::findOrFail($id);

        // Xóa ảnh nếu có
        if ($theater->image && Storage::disk('public')->exists($theater->image)) {
            Storage::disk('public')->delete($theater->image);
        }

        $theater->delete();

        return redirect()->route('admin.theaters.index')->with('success', 'Xóa rạp thành công!');
    }
}
