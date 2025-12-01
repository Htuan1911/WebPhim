@extends('layouts.admin')

@section('content')
    <h1>Danh sách suất chiếu</h1>
    <a href="{{ route('admin.showtimes.create') }}" class="btn btn-primary mb-3">Thêm suất chiếu</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Phim</th>
                <th>Rạp</th>
                <th>Phòng</th>
                <th>Giá vé</th>
                <th>Thời gian bắt đầu</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($showtimes as $showtime)
                <tr>
                    <td>{{ $showtime->id }}</td>
                    <td>{{ $showtime->movie->title ?? 'N/A' }}</td>
                    <td>{{ $showtime->theater->name ?? 'N/A' }}</td>
                    <td>{{ $showtime->cinemaRoom->name ?? 'N/A' }}</td>
                    <td>{{ number_format($showtime->ticket_price, 0, ',', '.') }} VND </td>
                    <td>{{ $showtime->start_time }}</td>
                    <td>
                        <a href="{{ route('admin.showtimes.edit', $showtime->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('admin.showtimes.destroy', $showtime->id) }}" method="POST"
                            style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $showtimes->links('pagination::bootstrap-5') }}
@endsection
