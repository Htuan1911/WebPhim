@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">🧾 Chi tiết đơn hàng #{{ $order->id }}</h2>

    <div class="card mb-3">
        <div class="card-header bg-dark text-white">Thông tin đơn hàng</div>
        <div class="card-body">
            <p><strong>Người đặt:</strong> {{ $order->user->name ?? 'N/A' }}</p>
            <p><strong>Phim:</strong> {{ $order->showtime->movie->title ?? 'N/A' }}</p>
            <p><strong>Suất chiếu:</strong> {{ $order->showtime->start_time }}</p>
            <p><strong>Ghế:</strong> {{ $order->orderSeats->pluck('seat.seat_number')->join(', ') }}</p>
            <p><strong>Tổng tiền:</strong> {{ number_format($order->total_price) }} đ</p>
            <p><strong>Thanh toán:</strong> {{ ucfirst($order->payment_method) }} - {{ ucfirst($order->payment_status) }}</p>
            <p><strong>Mã vé:</strong> {{ $order->booking_code }}</p>
        </div>
    </div>

    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">← Quay lại</a>
</div>
@endsection
