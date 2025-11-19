<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|max:255',
            'content'   => 'nullable|string',
            'image'     => 'nullable|image',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Thêm bài viết thành công!');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'     => 'required|max:255',
            'content'   => 'nullable|string',
            'image'     => 'nullable|image',
        ]);

        $post = Post::findOrFail($id);
        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            if ($post->image && Storage::exists('public/'.$post->image)) {
                Storage::delete('public/'.$post->image);
            }
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Cập nhật bài viết thành công!');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->image && Storage::exists('public/'.$post->image)) {
            Storage::delete('public/'.$post->image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Xóa bài viết thành công!');
    }
}
