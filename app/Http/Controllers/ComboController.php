<?php

namespace App\Http\Controllers;

use App\Models\Combo;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class ComboController extends Controller
{
    public function index()
    {
        $combos = Combo::orderBy('id', 'asc')->paginate(10);
        return view('admin.combos.index', compact('combos'));
    }

    public function create()
    {
        return view('admin.combos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('combos', 'public');
            $data['image'] = $imagePath;
        }

        Combo::create($data);

        return redirect()->route('admin.combos.index')->with('success', 'Thêm combo thành công!');
    }

    public function edit($id)
    {
        $combo = Combo::findOrFail($id);
        return view('admin.combos.edit', compact('combo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
        ]);

        $combo = Combo::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($combo->image && FacadesStorage::exists('public/' . $combo->image)) {
                FacadesStorage::delete('public/' . $combo->image);
            }

            $imagePath = $request->file('image')->store('combos', 'public');
            $data['image'] = $imagePath;
        }

        $combo->update($data);

        return redirect()->route('admin.combos.index')->with('success', 'Cập nhật combo thành công!');
    }

    public function destroy($id)
    {
        $combo = Combo::findOrFail($id);

        if ($combo->image && FacadesStorage::exists('public/' . $combo->image)) {
            FacadesStorage::delete('public/' . $combo->image);
        }

        $combo->delete();

        return redirect()->route('admin.combos.index')->with('success', 'Xóa combo thành công!');
    }
}
