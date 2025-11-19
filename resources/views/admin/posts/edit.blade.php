@extends('layouts.admin')

@section('content')
<h2>Sửa bài viết</h2>

<form action="{{ route('admin.posts.update', $post->id) }}" 
      method="POST" 
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    {{-- Tiêu đề --}}
    <div class="mb-3">
        <label class="form-label">Tiêu đề</label>
        <input type="text" name="title" value="{{ old('title', $post->title) }}" class="form-control">
    </div>

    {{-- Nội dung --}}
    <div class="mb-3">
        <label class="form-label">Nội dung</label>
        <textarea name="content" rows="6" class="form-control">{{ old('content', $post->content) }}</textarea>
    </div>

    {{-- Ảnh --}}
    <div class="mb-3">
        <label class="form-label">Ảnh hiện tại</label><br>
        @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" width="150">
        @else
            <p>Không có ảnh</p>
        @endif
    </div>

    <div class="mb-3">
        <label class="form-label">Chọn ảnh mới</label>
        <input type="file" name="image" class="form-control">
    </div>

    <button class="btn btn-primary">Cập nhật</button>
</form>
@endsection
