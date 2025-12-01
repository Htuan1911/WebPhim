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
        $movie = $order->showtime?->movie;

        if (!$movie) {
            return back()->with('error', 'Không tìm thấy phim.');
        }

        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->showtime->start_time > now()) {
            return back()->with('error', 'Chỉ được đánh giá sau khi xem phim.');
        }

        $hasReviewed = Review::where('user_id', auth()->id())
            ->where('movie_id', $movie->id)
            ->exists();

        if ($hasReviewed) {
            return back()->with('error', 'Bạn đã đánh giá phim này rồi!');
        }

        $request->validate([
            'rating'  => 'required|integer|min:1|max:10',
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
