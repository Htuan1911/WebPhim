@extends('layouts.admin')

@section('title', 'Danh sách phòng chiếu')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">Danh sách phòng chiếu</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.cinema-rooms.create') }}" class="btn btn-primary mb-3">Thêm phòng chiếu mới</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên phòng chiếu</th>
                <th>Tổng số ghế</th>
                <th>Rạp chiếu</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rooms as $room)
                <tr>
                    <td>{{ $room->id }}</td>
                    <td>{{ $room->name }}</td>
                    <td>{{ $room->total_seats }}</td>
                    <td>{{ $room->theater ? $room->theater->name : 'Chưa gán' }}</td>
                    <td>
                        <a href="{{ route('admin.cinema-rooms.edit', $room->id) }}" class="btn btn-sm btn-warning">Sửa</a>

                        <form action="{{ route('admin.cinema-rooms.destroy', $room->id) }}" method="POST" style="display:inline-block"
                            onsubmit="return confirm('Bạn có chắc muốn xóa phòng chiếu này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Chưa có phòng chiếu nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $rooms->links() }}
    </div>
</div>
@endsection
