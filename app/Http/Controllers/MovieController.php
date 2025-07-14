<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    // Hiển thị danh sách phim
    public function index()
    {
        $movies = Movie::orderBy('id', 'asc')->paginate(10);
        return view('admin.movies.index', compact('movies'));
    }
    // Form tạo phim mới
    public function create()
    {
        return view('admin.movies.create');
    }

    // Lưu phim mới
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'genre'       => 'nullable|string|max:100',
            'duration'    => 'nullable|integer',
            'poster'      => 'nullable|image|mimes:jpg,png,jpeg,gif,webp',
            'release_date' => 'nullable|date',
            'status' => 'required|in:now_showing,coming_soon,ended',

        ]);

        $data = $request->all();

        if ($request->hasFile('poster')) {
            $imagePath = $request->file('poster')->store('posters', 'public');
            $data['poster'] = $imagePath;
        }

        Movie::create($data);

        return redirect()->route('admin.movies.index')->with('success', 'Thêm phim thành công!');
    }

    // Form sửa phim
    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        return view('admin.movies.edit', compact('movie'));
    }

    // Cập nhật phim
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'genre' => 'nullable|string|max:100',
            'duration' => 'nullable|integer',
            'poster' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp',
            'release_date' => 'nullable|date',
        ]);

        $movie = Movie::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('poster')) {
            // Xóa file cũ nếu cần
            if ($movie->poster && \Illuminate\Support\Facades\Storage::exists('public/' . $movie->poster)) {
                \Illuminate\Support\Facades\Storage::delete('public/' . $movie->poster);
            }

            $imagePath = $request->file('poster')->store('posters', 'public');
            $data['poster'] = $imagePath; // Lưu đường dẫn đầy đủ: posters/image.jpg
        }

        $movie->update($data);

        return redirect()->route('admin.movies.index')->with('success', 'Cập nhật phim thành công!');
    }


    // Xóa phim
    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        $movie->delete($id);
        return redirect()->route('admin.movies.index')->with('success', 'Xóa phim thành công!');
    }
}
