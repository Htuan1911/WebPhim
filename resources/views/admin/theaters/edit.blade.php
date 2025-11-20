@extends('layouts.admin')

@section('title', 'Sửa Rạp Chiếu Phim')

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="card shadow border-0">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Chỉnh sửa rạp: {{ $theater->name }}
                    </h4>
                </div>
                <div class="card-body p-5">
                    <form action="{{ route('admin.theaters.update', $theater) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Hãng rạp <span class="text-danger">*</span></label>
                                    <select name="cinema_category_id"
                                        class="form-select @error('cinema_category_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn hãng rạp --</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ old('cinema_category_id', $theater->cinema_category_id) == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cinema_category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Tên rạp <span class="text-danger">*</span></label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $theater->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Số ghế tổng</label>
                                    <input type="number" name="total_seats" min="20" max="500"
                                        class="form-control @error('total_seats') is-invalid @enderror"
                                        value="{{ old('total_seats', $theater->total_seats) }}" required>
                                    @error('total_seats')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Địa chỉ</label>
                                    <input type="text" name="address" class="form-control"
                                        value="{{ old('address', $theater->address) }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Ảnh hiện tại</label>
                            <div class="text-center mb-3">
                                @if ($theater->image)
                                    <img src="{{ asset('storage/' . $theater->image) }}" alt="{{ $theater->name }}"
                                        class="img-thumbnail rounded shadow" style="max-height: 250px; object-fit: cover;">
                                @else
                                    <div class="bg-light border rounded d-flex align-items-center justify-content-center"
                                        style="height: 200px;">
                                        <i class="fas fa-image fa-4x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <label class="form-label fw-bold">Thay ảnh mới</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                                accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-warning btn-lg px-5">
                                <i class="fas fa-save me-2"></i> Cập nhật
                            </button>
                            <a href="{{ route('admin.theaters.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i> Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
