@extends('layouts.history')

@section('title', 'Lịch sử đặt vé')

@section('content')
    <div class="container py-5">
        <h3 class="mb-4 text-white fw-bold">Lịch sử đặt vé của bạn</h3>
        @if ($orders->isEmpty())
            <div class="text-center py-5">
                <p class="text-secondary fs-5">Bạn chưa có đơn hàng nào.</p>
                <a href="{{ route('client.movies.index') }}" class="btn btn-danger btn-lg px-5 py-3 rounded-pill">
                    Đặt vé ngay
                </a>
            </div>
        @else
            <div class="row">
                @foreach ($orders as $order)
                    @php
                        $movie = $order->showtime->movie;
                        $showtime = $order->showtime;

                        $userReview = auth()->check()
                            ? \App\Models\Review::where('user_id', auth()->id())
                                ->where('movie_id', $movie->id)
                                ->first()
                            : null;

                        $canReview =
                            !$userReview &&
                            $order->payment_status === 'paid' &&
                            $showtime->start_time < now() &&
                            auth()->check();
                    @endphp

                    <div class="col-12 mb-4">
                        <div class="card shadow-sm rounded-4 overflow-hidden">
                            <div class="row g-0">
                                <div class="col-md-3">
                                    <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}"
                                        class="img-fluid w-100" style="object-fit: cover;">
                                </div>

                                <div class="col-md-9">
                                    <div class="card-body p-4">
                                        <h5 class="text-pink fw-bold">{{ $movie->title }}</h5>

                                        <p class="mb-2"><strong>Suất chiếu:</strong>
                                            {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i - d/m/Y') }}
                                            <span class="text-muted ms-2">
                                                ({{ $showtime->cinemaHall->name ?? 'Rạp' }})
                                            </span>
                                        </p>

                                        <p class="mb-2"><strong>Ghế:</strong>
                                            <span class="text-warning fw-bold">
                                                {{ $order->orderSeats->pluck('seat.seat_number')->join(', ') }}
                                            </span>
                                        </p>

                                        <p class="mb-2"><strong>Tổng tiền:</strong>
                                            <span class="text-success fw-bold fs-5">
                                                {{ number_format($order->total_price) }}₫
                                            </span>
                                        </p>

                                        <p class="mb-2"><strong>Trạng thái:</strong>
                                            <span class="badge bg-success fs-6">
                                                {{ ucfirst($order->payment_method) }} -
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </p>

                                        <p class="mb-3"><strong>Mã vé:</strong>
                                            <code class="bg-secondary text-white px-3 py-1 rounded">
                                                {{ $order->booking_code }}
                                            </code>
                                        </p>

                                        <!-- VÙNG ĐÁNH GIÁ -->
                                        <div class="review-section mt-4">

                                            {{-- ĐÃ ĐÁNH GIÁ --}}
                                            @if ($userReview)
                                                <div class="reviewed-box p-4 rounded"
                                                    style="background:rgba(0,200,0,0.1); border-left:4px solid #0f0;">
                                                    <p class="mb-2 text-success fw-bold">Bạn đã đánh giá phim này</p>

                                                    <div class="star-display mb-2">
                                                        @for ($i = 1; $i <= 10; $i++)
                                                            <span
                                                                class="{{ $i <= $userReview->rating ? 'filled' : 'empty' }}">
                                                                ★
                                                            </span>
                                                        @endfor
                                                        <span
                                                            class="ms-2 text-warning fw-bold">{{ $userReview->rating }}/10</span>
                                                    </div>

                                                    @if ($userReview->comment)
                                                        <p class="mb-1"><strong>Nhận xét:</strong>
                                                            {{ $userReview->comment }}</p>
                                                    @endif

                                                    <small
                                                        class="text-muted">{{ $userReview->created_at->diffForHumans() }}</small>
                                                </div>

                                                {{-- CHƯA ĐÁNH GIÁ – HIỆN FORM LUÔN --}}
                                            @elseif ($canReview)
                                                <div class="review-form mt-4 p-4 rounded"
                                                    style="background:rgba(255,255,255,0.06); border:1px solid #444;">

                                                    <h6 class="text-pink mb-3 fw-bold">
                                                        Đánh giá phim: {{ $movie->title }}
                                                    </h6>

                                                    <form action="{{ route('client.reviews.store', $order->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                                                        <input type="hidden" name="rating"
                                                            id="rating-{{ $order->id }}">

                                                        <div class="star-rating mb-4 text-center"
                                                            data-order="{{ $order->id }}">
                                                            @for ($i = 10; $i >= 1; $i--)
                                                                <input type="radio" name="temp_rating"
                                                                    value="{{ $i }}"
                                                                    id="star{{ $i }}-{{ $order->id }}">
                                                                <label
                                                                    for="star{{ $i }}-{{ $order->id }}">★</label>
                                                            @endfor
                                                        </div>

                                                        <textarea name="comment" class="form-control mb-3" rows="4" placeholder="Chia sẻ cảm nhận của bạn về bộ phim..."></textarea>

                                                        <div class="text-end">
                                                            <button type="submit" class="btn-submit-review">
                                                                Gửi đánh giá
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            @endif

                                        </div> <!-- end review-section -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection


@section('scripts')
    <script>
        // Bắt sao và gán vào input hidden
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.star-rating input[type="radio"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    const container = this.closest('.star-rating');
                    const orderId = container.dataset.order;
                    document.getElementById('rating-' + orderId).value = this.value;
                });
            });
        });
    </script>
@endsection
