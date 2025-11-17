@extends('layouts.master')

@section('content')
    <div class="container py-4">
        {{-- Phim đang chiếu --}}
        <h2 class="text-center mt-5 mb-4">🎬 Phim đang chiếu</h2>
        <div class="py-5"
            style="background: url('https://png.pngtree.com/background/20211216/original/pngtree-real-shots-of-the-empty-and-spacious-theater-movie-theater-scenes-picture-image_1517322.jpg') center center / cover no-repeat;">
            <div class="container">
                <div class="movie-scroll-container">
                    <button class="scroll-btn prev" data-target="now-showing-row" disabled></button>
                    <div class="movie-row" id="now-showing-row">
                        @forelse($nowShowingMovies as $movie)
                            <div class="col">
                                <div class="card h-100 shadow-sm">
                                    <a href="{{ route('client.movies.show', $movie->id) }}">
                                        <div class="image-container">
                                            <img src="{{ asset('storage/' . $movie->poster) }}" class="card-img-top"
                                                alt="{{ $movie->title }}"
                                                onerror="this.src='https://via.placeholder.com/200x300';">
                                            <div class="play-button"></div>
                                        </div>
                                    </a>
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="card-title text-truncate">{{ $movie->title }}</h6>
                                        <p class="text-muted small mb-2">{{ $movie->genre }} • {{ $movie->duration }} phút
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-white">Không có phim đang chiếu.</p>
                        @endforelse
                    </div>
                    <button class="scroll-btn next" data-target="now-showing-row">></button>
                </div>
            </div>
        </div>

        {{-- Phim sắp chiếu --}}
        <h2 class="text-center mt-5 mb-4">🎥 Phim sắp chiếu</h2>
        <div class="container">
            <div class="movie-scroll-container">
                <button class="scroll-btn prev" data-target="coming-soon-row" disabled>
                </button>
                <div class="movie-row" id="coming-soon-row">
                    @forelse($comingSoonMovies as $movie)
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <a href="{{ route('client.movies.show', $movie->id) }}">
                                    <div class="image-container">
                                        <img src="{{ asset('storage/' . $movie->poster) }}" class="card-img-top"
                                            alt="{{ $movie->title }}"
                                            onerror="this.src='https://via.placeholder.com/200x300';">
                                        <div class="play-button"></div>
                                    </div>
                                </a>
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title text-truncate">{{ $movie->title }}</h6>
                                    <p class="text-muted small mb-2">{{ $movie->genre }} • {{ $movie->duration }}
                                        phút</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">Không có phim sắp chiếu.</p>
                    @endforelse
                </div>
                <button class="scroll-btn next" data-target="coming-soon-row">></button>
            </div>
        </div>

        {{-- Suất chiếu sắp tới --}}
        <h2 class="text-center mt-5 mb-4">📅 Suất chiếu sắp tới</h2>
        <ul class="list-group">
            @forelse($upcomingShowtimes as $showtime)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $showtime->movie->title ?? 'Không xác định' }}
                    <span>{{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i d/m/Y') }}</span>
                </li>
            @empty
                <li class="list-group-item text-center">Không có suất chiếu sắp tới.</li>
            @endforelse
        </ul>
    </div>
@endsection
