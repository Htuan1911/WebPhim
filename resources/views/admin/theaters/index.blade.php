@extends('layouts.admin')

@section('content')
    <h1>Danh sách rạp</h1>
    <a href="{{ route('admin.theaters.create') }}" class="btn btn-primary mb-3">Thêm rạp</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Danh mục</th>
                <th>Ảnh</th>
                <th>Tên rạp</th>
                <th>Số ghế</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($theaters as $theater)
                <tr>
                    <td>{{ $theater->id }}</td>
                    <td>{{ $theater->category }}</td>
                    <td style="width: 100px;">
                        @if($theater->image)
                            <img src="{{ asset('storage/' . $theater->image) }}" alt="{{ $theater->name }}" class="img-fluid rounded" style="max-height: 80px;">
                        @else
                            <span class="text-muted">Chưa có ảnh</span>
                        @endif
                    </td>
                    <td>{{ $theater->name }}</td>
                    <td>{{ $theater->total_seats }}</td>
                    <td>
                        <a href="{{ route('admin.theaters.edit', $theater->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('admin.theaters.destroy', $theater->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Bạn chắc chắn muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $theaters->links() }}
@endsection
