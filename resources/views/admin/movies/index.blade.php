@extends('layouts.admin')

@section('content')
    <h1>Danh sách Phim</h1>

    <a href="{{ route('admin.movies.create') }}" class="btn btn-primary mb-3">Thêm Phim Mới</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Thể loại</th>
                <th>Độ tuổi</th>
                <th>Thời lượng</th>
                <th>Ngày phát hành</th>
                <th>Trailer</th>
                <th>Poster</th>
                <th>Banner</th>
                <th>Status</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movies as $movie)
                <tr>
                    <td>{{ $movie->id }}</td>
                    <td>{{ $movie->title }}</td>
                    <td>{{ $movie->genre }}</td>
                    <td>{{ $movie->age_rating }}</td>
                    <td>{{ $movie->duration }} phút</td>
                    <td>{{ $movie->release_date }}</td>

                    <td>
                        @if ($movie->trailer)
                            <a href="{{ $movie->trailer }}" target="_blank">Xem trailer</a>
                        @else
                            ---
                        @endif
                    </td>

                    <td>
                        @if ($movie->poster)
                            <img src="{{ asset('storage/' . $movie->poster) }}" width="90">
                        @endif
                    </td>

                    <td>
                        @if ($movie->banner)
                            <img src="{{ asset('storage/' . $movie->banner) }}" width="120">
                        @endif
                    </td>

                    <td>{{ $movie->status }}</td>

                    <td>
                        <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('admin.movies.destroy', $movie->id) }}" method="POST"
                              style="display:inline-block"
                              onsubmit="return confirm('Bạn chắc chắn muốn xóa?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $movies->links('pagination::bootstrap-5') }}
@endsection
