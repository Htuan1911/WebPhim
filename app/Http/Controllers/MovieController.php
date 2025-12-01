<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::orderBy('id', 'asc')->paginate(10);
        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        return view('admin.movies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'genre'         => 'nullable|string|max:100',
            'duration'      => 'nullable|integer',
            'poster'        => 'nullable|image|mimes:jpg,png,jpeg,gif,webp',
            'banner'        => 'nullable|image|mimes:jpg,png,jpeg,gif,webp',
            'trailer'       => 'nullable|string|max:255',
            'age_rating'    => 'nullable|string|max:10',
            'release_date'  => 'nullable|date',
            'status'        => 'required|in:now_showing,coming_soon,ended',
        ]);

        $data = $request->all();

        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('banners', 'public');
        }

        Movie::create($data);

        return redirect()->route('admin.movies.index')->with('success', 'Thêm phim thành công!');
    }

    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        return view('admin.movies.edit', compact('movie'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'genre'         => 'nullable|string|max:100',
            'duration'      => 'nullable|integer',
            'poster'        => 'nullable|image|mimes:jpg,png,jpeg,gif,webp',
            'banner'        => 'nullable|image|mimes:jpg,png,jpeg,gif,webp',
            'trailer'       => 'nullable|string|max:255',
            'age_rating'    => 'nullable|string|max:10',
            'release_date'  => 'nullable|date',
            'status'        => 'required|in:now_showing,coming_soon,ended',
        ]);

        $movie = Movie::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('poster')) {
            if ($movie->poster && Storage::exists('public/' . $movie->poster)) {
                Storage::delete('public/' . $movie->poster);
            }

            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        if ($request->hasFile('banner')) {
            if ($movie->banner && Storage::exists('public/' . $movie->banner)) {
                Storage::delete('public/' . $movie->banner);
            }

            $data['banner'] = $request->file('banner')->store('banners', 'public');
        }

        $movie->update($data);

        return redirect()->route('admin.movies.index')->with('success', 'Cập nhật phim thành công!');
    }

    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);

        if ($movie->poster && Storage::exists('public/' . $movie->poster)) {
            Storage::delete('public/' . $movie->poster);
        }

        if ($movie->banner && Storage::exists('public/' . $movie->banner)) {
            Storage::delete('public/' . $movie->banner);
        }

        $movie->delete();

        return redirect()->route('admin.movies.index')->with('success', 'Xóa phim thành công!');
    }
}
