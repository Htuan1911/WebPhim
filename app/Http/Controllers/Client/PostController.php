<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Post $post)
    {
        $relatedPosts = Post::where('id', '!=', $post->id)
            ->where(function ($query) use ($post) {
                $query->where('user_id', $post->user_id)
                    ->orWhere('created_at', '>=', $post->created_at->copy()->subDays(90));
            })
            ->with('user')
            ->inRandomOrder()
            ->limit(6)
            ->get();

        return view('client.posts.show', compact('post', 'relatedPosts'));
    }
}
