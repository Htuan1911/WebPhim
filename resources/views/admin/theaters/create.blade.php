@extends('layouts.admin')

@section('content')
    <h1>
        Thêm rạp</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.theaters.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="category" class="form-label">Danh mục</label>
            <input type="text" name="category" id="category" class="form-control"
                value="{{ old('category', $theater->category ?? '') }}">
        </div>
        <div class="mb-3">
            <label>Tên rạp</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label>Số ghế</label>
            <input type="number" name="total_seats" class="form-control" value="{{ old('total_seats') }}" required>
        </div>
        <div class="mb-3">
            <label>Ảnh rạp (tùy chọn)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-success">Lưu</button>
        <a href="{{ route('admin.theaters.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection
