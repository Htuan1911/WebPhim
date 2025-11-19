<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Order $order)
    {
        // LỖI 1: Bạn dùng $order->movie nhưng model Order không có relation movie
        // → Phải lấy qua showtime
        $movie = $order->showtime?->movie;

        if (!$movie) {
            return back()->with('error', 'Không tìm thấy phim.');
        }

        // Kiểm tra quyền
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Kiểm tra đã xem phim chưa
        if ($order->showtime->start_time > now()) {
            return back()->with('error', 'Chỉ được đánh giá sau khi xem phim.');
        }

        // LỖI 2: Kiểm tra đã đánh giá chưa – bạn dùng order_id → sai logic
        // → Phải kiểm tra theo user + movie (1 người chỉ được đánh giá 1 phim 1 lần)
        $hasReviewed = Review::where('user_id', auth()->id())
            ->where('movie_id', $movie->id)
            ->exists();

        if ($hasReviewed) {
            return back()->with('error', 'Bạn đã đánh giá phim này rồi!');
        }

        $request->validate([
            'rating'  => 'required|integer|min:1|max:10', // bạn đang dùng sao 1-10 đúng không?
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'user_id'  => auth()->id(),
            'movie_id' => $movie->id,
            'order_id' => $order->id,
            'rating'   => $request->rating,
            'comment'  => $request->comment,
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá phim!');
    }

    public function list(Movie $movie)
    {
        $reviews = $movie->reviews()->with('user')->latest()->paginate(10);
        return view('client.reviews.list', compact('movie', 'reviews'));
    }
}
