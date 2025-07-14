@extends('layouts.admin')

@section('content')
    <h4>Thêm combo mới</h4>

    <form action="{{ route('admin.combos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name">Tên combo</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="price">Giá</label>
            <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
        </div>

        <div class="mb-3">
            <label for="image">Ảnh minh họa</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button class="btn btn-primary">Lưu</button>
        <a href="{{ route('admin.combos.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection
