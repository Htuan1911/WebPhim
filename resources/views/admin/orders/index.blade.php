@extends('layouts.admin')

@section('title', 'Quản lý đơn hàng')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">📦 Danh sách đơn hàng</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Người đặt</th>
                <th>Phim</th>
                <th>Suất chiếu</th>
                <th>Ghế</th>
                <th>Tổng tiền</th>
                <th>Thanh toán</th>
                <th>Mã vé</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                    <td>{{ $order->showtime->movie->title ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->showtime->start_time)->format('H:i d/m/Y') }}</td>
                    <td>{{ $order->orderSeats->pluck('seat.seat_number')->join(', ') }}</td>
                    <td>{{ number_format($order->total_price) }} đ</td>
                    <td>{{ ucfirst($order->payment_method) }} - {{ ucfirst($order->payment_status) }}</td>
                    <td>{{ $order->booking_code }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">Chi tiết</a>
                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Xóa đơn hàng này?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-center">Không có đơn hàng nào.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $orders->links() }}
    </div>
</div>
@endsection
