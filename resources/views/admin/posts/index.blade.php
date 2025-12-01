@extends('layouts.admin')

@section('content')
<h2>Danh sách bài viết</h2>

<a href="{{ route('admin.posts.create') }}" class="btn btn-primary mb-3">Thêm bài viết</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tiêu đề</th>
            <th>Ảnh</th>
            <th>Ngày đăng</th>
            <th width="150px">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($posts as $post)
        <tr>
            <td>{{ $post->id }}</td>
            <td>{{ $post->title }}</td>
            <td>
                @if($post->image)
                    <img src="{{ asset('storage/'.$post->image) }}" width="80">
                @endif
            </td>
            <td>{{ $post->created_at }}</td>
            <td>
                <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Xóa?')" class="btn btn-sm btn-danger">Xóa</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $posts->links('pagination::bootstrap-5') }}
@endsection
