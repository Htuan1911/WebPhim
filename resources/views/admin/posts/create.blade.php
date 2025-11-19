@extends('layouts.admin')

@section('content')
<h2>Thêm bài viết</h2>

<form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Tiêu đề</label>
    <input type="text" name="title" class="form-control">

    <label>Nội dung</label>
    <textarea name="content" class="form-control" rows="5"></textarea>

    <label>Ảnh</label>
    <input type="file" name="image" class="form-control">

    <button class="btn btn-success mt-3">Lưu</button>
</form>
@endsection
