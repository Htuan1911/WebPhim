@extends('layouts.admin')

@section('content')
    <h4>Danh sách combo</h4>
    <a href="{{ route('admin.combos.create') }}" class="btn btn-success mb-3">+ Thêm combo</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên</th>
                <th>Giá</th>
                <th>Ảnh</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($combos as $combo)
                <tr>
                    <td>{{ $combo->name }}</td>
                    <td>{{ number_format($combo->price) }} đ</td>
                    <td>
                        @if ($combo->image)
                            <img src="{{ asset('storage/' . $combo->image) }}" width="60">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.combos.edit', $combo->id) }}" class="btn btn-primary btn-sm">Sửa</a>
                        <form action="{{ route('admin.combos.destroy', $combo->id) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Xóa combo này?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
