@extends('layouts.master')

@section('content')
<div class="container py-5">
    <h3>Lịch sử đặt vé</h3>

    @if ($orders->isEmpty())
        <p>Không có đơn hàng nào.</p>
    @else
        @foreach ($orders as $order)
            <div class="card my-3 p-3">
                <div class="d-flex">
                    {{-- Ảnh phim --}}
                    <div class="me-3" style="width: 120px;">
                        <img src="{{ asset('storage/' . $order->showtime->movie->poster) }}" 
                             alt="{{ $order->showtime->movie->title }}" 
                             class="img-fluid rounded" 
                             style="height: 160px; object-fit: cover; width: 100%;">
                    </div>

                    {{-- Thông tin đơn --}}
                    <div>
                        <p><strong>Phim:</strong> {{ $order->showtime->movie->title }}</p>
                        <p><strong>Suất chiếu:</strong> {{ $order->showtime->start_time }}</p>
                        <p><strong>Ghế:</strong> {{ $order->orderSeats->pluck('seat.seat_number')->join(', ') }}</p>
                        <p><strong>Tổng tiền:</strong> {{ number_format($order->total_price) }} đ</p>
                        <p><strong>Thanh toán:</strong> {{ ucfirst($order->payment_method) }} - {{ ucfirst($order->payment_status) }}</p>
                        <p><strong>Mã vé:</strong> {{ $order->booking_code }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
