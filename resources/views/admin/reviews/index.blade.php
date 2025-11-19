@extends('layouts.admin')

@section('content')
<h2>Danh sách đánh giá</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Phim</th>
            <th>User</th>
            <th>Rating</th>
            <th>Bình luận</th>
            <th width="120px">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reviews as $r)
        <tr>
            <td>{{ $r->id }}</td>
            <td>{{ $r->movie->title }}</td>
            <td>{{ $r->user->name }}</td>
            <td>{{ $r->rating }}/5</td>
            <td>{{ $r->comment }}</td>
            <td>
                <form action="{{ route('admin.reviews.destroy', $r->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Xóa?')">Xóa</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $reviews->links() }}
@endsection
