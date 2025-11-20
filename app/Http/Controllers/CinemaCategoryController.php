<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CinemaCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CinemaCategoryController extends Controller
{
    public function index()
    {
        $categories = CinemaCategory::latest()->paginate(10);
        return view('admin.cinema-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.cinema-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:cinema_categories,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'nullable|string',
            'priority' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        CinemaCategory::create($data);

        return redirect()->route('admin.cinema-categories.index')
            ->with('success', 'Thêm danh mục rạp thành công!');
    }

    public function edit($id)
    {
        $category = CinemaCategory::findOrFail($id);
        return view('admin.cinema-categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = CinemaCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:cinema_categories,name,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'nullable|string',
            'priority' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('admin.cinema-categories.index')
            ->with('success', 'Cập nhật danh mục rạp thành công!');
    }

    public function destroy($id)
    {
        $category = CinemaCategory::findOrFail($id);

        // Nếu có rạp đang dùng danh mục này → không cho xóa (hoặc có thể chuyển sang "Khác")
        if ($category->theaters()->exists()) {
            return back()->withErrors('Không thể xóa! Đang có rạp chiếu thuộc danh mục này.');
        }

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.cinema-categories.index')
            ->with('success', 'Xóa danh mục rạp thành công!');
    }
}