@extends('layouts.admin')

@section('content')
    <h4>Chỉnh sửa combo</h4>

    <form action="{{ route('admin.combos.update', $combo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name">Tên combo</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $combo->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="price">Giá</label>
            <input type="number" name="price" class="form-control" value="{{ old('price', $combo->price) }}" required>
        </div>

        <div class="mb-3">
            <label for="image">Ảnh minh họa</label>
            <input type="file" name="image" class="form-control">
            @if ($combo->image)
                <img src="{{ asset('storage/' . $combo->image) }}" width="80" class="mt-2">
            @endif
        </div>

        <button class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.combos.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection
