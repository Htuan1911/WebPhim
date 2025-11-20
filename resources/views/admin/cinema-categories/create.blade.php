@extends('layouts.admin')
@section('title', 'Thêm Danh mục Rạp')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Thêm Danh mục Rạp mới</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.cinema-categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Logo (khuyến khích 300x150px)</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                @error('image') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Thứ tự hiển thị</label>
                        <input type="number" name="priority" class="form-control" value="{{ old('priority', 0) }}" min="0">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">Hiển thị công khai</label>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Thêm mới</button>
            <a href="{{ route('admin.cinema-categories.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</div>
@endsection