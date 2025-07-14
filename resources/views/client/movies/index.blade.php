@extends('layouts.master')

@section('title', 'Danh sách phim')

@section('content')
<div class="container my-4">
    <h2 class="mb-4 text-center text-pink">Danh sách phim</h2>

    {{-- Tìm kiếm --}}
    <form method="GET" action="{{ route('client.movies.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Tìm phim theo tên..."
                value="{{ request('search') }}">
            <button class="btn btn-pink" type="submit">Tìm</button>
        </div>
    </form>

    {{-- Danh sách phim --}}
    <div class="row">
        @forelse ($movies as $movie)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="movie-poster-container">
                        <img src="{{ asset('storage/' . $movie->poster) }}" class="card-img-top movie-poster" alt="{{ $movie->title }}">
                    </div>
                    <div class="card-body text-center d-flex flex-column">
                        <h5 class="card-title">{{ $movie->title }}</h5>
                        <p class="mb-1"><strong>Thể loại:</strong> {{ $movie->genre }}</p>
                        <p class="mb-3"><strong>Thời lượng:</strong> {{ $movie->duration }} phút</p>
                        
                        <a href="{{ route('client.movies.show', $movie->id) }}" class="btn btn-pink mt-auto">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Không tìm thấy phim nào.</p>
        @endforelse
    </div>

    {{-- Phân trang --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $movies->withQueryString()->links() }}
    </div>
</div>
@endsection
