@extends('layouts.master')

@section('content')
<div class="movie-detail-2col container">

    <div class="movie-grid">

        <!-- ====== CỘT TRÁI ====== -->
        <div class="movie-left">
            <img src="{{ asset('storage/' . $movie->poster) }}" class="movie-poster">

            <h2 class="movie-title">{{ $movie->title }}</h2>

            <p class="movie-genre">{{ $movie->genre }}</p>

            <p class="movie-release">
                Ngày chiếu:
                <span>{{ \Carbon\Carbon::parse($movie->release_date)->format('d/m/Y') }}</span>
            </p>

            <a href="#" class="btn-book-ticket">Đặt vé ngay</a>
        </div>

        <!-- ====== CỘT PHẢI ====== -->
        <div class="movie-right">

            <h1 class="review-title">Review phim {{ $movie->title }} trên MoMo</h1>
            <h4 class="review-subtitle">Bình luận từ người xem</h4>

            <div class="reviews-list">
                @forelse ($reviews as $review)
                    <div class="review-item">

                        <div class="review-header">
                            <div class="review-user-info">
                                <img src="{{ $review->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) }}"
                                     class="user-avatar">

                                <div>
                                    <span class="review-username">{{ $review->user->name }}</span>
                                    @if ($review->bought_via_momo ?? false)
                                        <span class="verified-badge">Đã mua qua MoMo</span>
                                    @endif
                                </div>
                            </div>

                            <span class="review-time">{{ $review->created_at->diffForHumans() }}</span>
                        </div>

                        <div class="review-rating">
                            {{ str_repeat('★', $review->rating) }}
                            {{ str_repeat('☆', 10 - $review->rating) }}
                            <span class="rating-number">{{ $review->rating }}/10</span>
                        </div>

                        <p class="review-comment">{{ $review->comment }}</p>
                    </div>

                @empty
                    <p class="text-secondary">Chưa có đánh giá nào.</p>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $reviews->links() }}
            </div>

        </div>

    </div>

</div>
@endsection
