@extends('layouts.admin')

@section('content')
    <h1>Sửa Phim</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Tiêu đề</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $movie->title) }}" required>
        </div>
        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="description" class="form-control">{{ old('description', $movie->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label>Thể loại</label>
            <input type="text" name="genre" class="form-control" value="{{ old('genre', $movie->genre) }}">
        </div>
        <div class="mb-3">
            <label>Thời lượng (phút)</label>
            <input type="number" name="duration" class="form-control" value="{{ old('duration', $movie->duration) }}">
        </div>
        <div class="mb-3">
            <label>Ngày phát hành</label>
            <input type="date" name="release_date" class="form-control"
                value="{{ old('release_date', $movie->release_date) }}">
        </div>
        <div class="mb-3">
            <label>Poster</label>
            <input type="file" name="poster" class="form-control">
            @if ($movie->poster)
                <div class="mt-2">
                    <img src="{{ asset('storage/posters/' . $movie->poster) }}" alt="Poster" width="100">
                </div>
            @endif
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
