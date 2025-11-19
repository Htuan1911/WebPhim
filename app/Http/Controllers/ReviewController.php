<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['movie', 'user'])
                    ->orderBy('id', 'desc')
                    ->paginate(10);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Xóa đánh giá thành công!');
    }
}
