@extends('layouts.master')

@section('content')
    <div class="containerr">
        <div class="banner">
            <div class="banner-content">
                <h1>Mua vé xem phim Online <br>trên <span>MoMo</span></h1>
                <p>Với nhiều ưu đãi hấp dẫn và kết nối với tất cả các rạp lớn phủ rộng khắp Việt Nam. Đặt vé ngay tại MoMo!
                </p>

                <ul class="features">
                    <li>Mua vé Online, trải nghiệm phim hay</li>
                    <li>Đặt vé an toàn trên MoMo</li>
                    <li>Tha hồ chọn chỗ ngồi, mua bắp nước tiện lợi</li>
                    <li>Lịch sử đặt vé được lưu lại ngay</li>
                </ul>

                <a href="{{ route('client.movies.index') }}" class="btn1">
                    ĐẶT VÉ NGAY
                </a>
            </div>

            <div class="banner-image">
                <div class="illustration"></div>
            </div>
        </div>
        {{-- Phim đang chiếu --}}
        <div class="py-5"
            style="background: url('https://homepage.momocdn.net/img/momo-upload-api-210701105436-637607336767432408.jpg') center center / cover no-repeat;">
            <h2 class="title">🎬 Phim đang chiếu</h2>
            <div class="container">
                <div class="movie-scroll-container">
                    <button class="scroll-btn prev" data-target="now-showing-row" disabled><</button>
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
        <div class="py-5">
            <h2 class="title-1">🎥 Phim sắp chiếu</h2>
            <div class="container">
                <div class="movie-scroll-container">
                    <button class="scroll-btn prev" data-target="coming-soon-row" disabled><</button>
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
        </div>

        {{-- Suất chiếu sắp tới --}}
        {{-- <h2 class="text-center mt-5 mb-4">📅 Suất chiếu sắp tới</h2>
        <ul class="list-group">
            @forelse($upcomingShowtimes as $showtime)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $showtime->movie->title ?? 'Không xác định' }}
                    <span>{{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i d/m/Y') }}</span>
                </li>
            @empty
                <li class="list-group-item text-center">Không có suất chiếu sắp tới.</li>
            @endforelse
        </ul> --}}
    </div>
@endsection
