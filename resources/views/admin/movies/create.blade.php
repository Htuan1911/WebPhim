@extends('layouts.admin')

@section('content')
    <h1>Thêm Phim Mới</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Tiêu đề</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>
        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label>Thể loại</label>
            <input type="text" name="genre" class="form-control" value="{{ old('genre') }}">
        </div>
        <div class="mb-3">
            <label>Thời lượng (phút)</label>
            <input type="number" name="duration" class="form-control" value="{{ old('duration') }}">
        </div>
        <div class="mb-3">
            <label>Ngày phát hành</label>
            <input type="date" name="release_date" class="form-control" value="{{ old('release_date') }}">
        </div>
        <div class="mb-3">
            <label>Poster (Tên file ảnh)</label>
            <input type="file" name="poster" class="form-control" value="{{ old('poster') }}">
            <small class="text-muted">Bạn có thể upload ảnh ra thư mục storage/app/public/posters và nhập tên file ở
                đây</small>
        </div>
        <div class="mb-3">
            <label for="status">Trạng thái</label>
            <select name="status" class="form-control" required>
                <option value="now_showing" {{ old('status', $movie->status ?? '') == 'now_showing' ? 'selected' : '' }}>
                    Đang chiếu</option>
                <option value="coming_soon" {{ old('status', $movie->status ?? '') == 'coming_soon' ? 'selected' : '' }}>Sắp
                    chiếu</option>
                <option value="ended" {{ old('status', $movie->status ?? '') == 'ended' ? 'selected' : '' }}>Ngừng chiếu
                </option>
            </select>
        </div>


        <button type="submit" class="btn btn-success">Lưu</button>
        <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection
