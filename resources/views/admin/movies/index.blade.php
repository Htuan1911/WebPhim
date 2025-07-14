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
                <th>Title</th>
                <th>Genre</th>
                <th>Duration (phút)</th>
                <th>Release Date</th>
                <th>Status</th>
                <th>Poster</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movies as $movie)
                <tr>
                    <td>{{ $movie->id }}</td>
                    <td>{{ $movie->title }}</td>
                    <td>{{ $movie->genre }}</td>
                    <td>{{ $movie->duration }}</td>
                    <td>{{ $movie->release_date }}</td>
                    <td>{{ $movie->status }}</td>
                    <td>
                        @if ($movie->poster)
                            <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" width="100px">
                        @endif

                    </td>
                    <td>
                        <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('admin.movies.destroy', $movie->id) }}" method="POST"
                            style="display:inline-block" onsubmit="return confirm('Bạn chắc chắn muốn xóa?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $movies->links() }}
@endsection
