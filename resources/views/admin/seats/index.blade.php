@extends('layouts.admin')

@section('content')
    <h1>Danh sách ghế</h1>

    <a href="{{ route('admin.seats.create') }}" class="btn btn-primary mb-3">Thêm ghế</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Phòng chiếu</th>
                <th>Số ghế</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($seats as $seat)
                <tr>
                    <td>{{ $seat->id }}</td>
                    <td>{{ $seat->cinemaRoom->name }}</td>
                    <td>{{ $seat->seat_number }}</td>
                    <td>
                        <a href="{{ route('admin.seats.edit', $seat->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                        <form action="{{ route('admin.seats.destroy', $seat->id) }}" method="POST"
                              style="display:inline-block;"
                              onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $seats->links('pagination::bootstrap-5') }}
@endsection
