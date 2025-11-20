@extends('layouts.admin')

@section('title', 'Chỉnh sửa Danh mục Rạp')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="fas fa-edit me-2"></i>
            Chỉnh sửa: {{ $category->name }}
        </h5>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.cinema-categories.update', $category) }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Tên danh mục <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $category->name) }}" 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Mô tả</label>
                        <textarea name="description" 
                                  rows="4" 
                                  class="form-control" 
                                  placeholder="Ví dụ: Hệ thống rạp chiếu phim cao cấp hàng đầu Việt Nam...">{{ old('description', $category->description) }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Thứ tự hiển thị</label>
                                <input type="number" 
                                       name="priority" 
                                       class="form-control" 
                                       value="{{ old('priority', $category->priority) }}" 
                                       min="0">
                                <small class="text-muted">Số càng lớn → hiển thị trước</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class

="form-label fw-bold">Trạng thái</label><br>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           name="is_active" 
                                           id="is_active" 
                                           value="1" 
                                           {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        <span class="text-success fw-bold">Hiển thị công khai</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Logo hiện tại</label>
                        <div class="text-center">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" 
                                     alt="{{ $category->name }}" 
                                     class="img-thumbnail rounded" 
                                     style="max-height: 180px; object-fit: contain;">
                                <div class="mt-2">
                                    <small class="text-success">Đã có logo</small>
                                </div>
                            @else
                                <div class="border border-dashed rounded p-5 text-muted">
                                    <i class="fas fa-image fa-3x mb-3"></i>
                                    <p>Chưa có logo</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Thay logo mới</label>
                        <input type="file" 
                               name="image" 
                               class="form-control @error('image') is-invalid @enderror" 
                               accept="image/jpeg,image/png,image/webp">
                        <small class="text-muted">Khuyến nghị: 300x150px, định dạng JPG/PNG/WebP</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-2"></i>
                    Cập nhật
                </button>
                <a href="{{ route('admin.cinema-categories.index') }}" class="btn btn-secondary px-4">
                    <i class="fas fa-arrow-left me-2"></i>
                    Quay lại
                </a>
            </div>
        </form>
    </div>
</div>
@endsection