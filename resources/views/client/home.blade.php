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
                    <button class="scroll-btn prev" data-target="now-showing-row" disabled>
                        <</button>
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
                                                <p class="text-muted small mb-2">{{ $movie->genre }} •
                                                    {{ $movie->duration }} phút
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
                    <button class="scroll-btn prev" data-target="coming-soon-row" disabled>
                        <</button>
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
                                                <p class="text-muted small mb-2">{{ $movie->genre }} •
                                                    {{ $movie->duration }}
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

        {{-- Bài viết mới --}}
        <div class="container py-5">
            <h2 class="title text-dark text-center mb-5" style="font-size: 2.5rem;">
                Tin tức & Khuyến mãi
            </h2>

            @if ($posts->count() > 0)
                <div class="row g-4">
                    @foreach ($posts as $post)
                        <div class="col-md-6 col-lg-4">
                            <article
                                class="post-grid-card h-100 shadow-lg rounded-3 overflow-hidden bg-dark text-white border-0 
                                        transition-all hover-lift">
                                <a href="{{ route('client.posts.show', $post) }}"
                                    class="text-decoration-none text-white">
                                    <div class="position-relative overflow-hidden">
                                        @if ($post->image)
                                            <img src="{{ asset('storage/' . $post->image) }}" class="w-100"
                                                alt="{{ $post->title }}"
                                                style="height: 240px; object-fit: cover; transition: transform 0.5s ease;">
                                        @else
                                            <div class="bg-gradient-primary d-flex align-items-center justify-content-center"
                                                style="height: 240px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                <h4 class="mb-0 text-white px-4 text-center">{{ $post->title }}</h4>
                                            </div>
                                        @endif

                                        <!-- Overlay khi hover -->
                                        <div class="post-overlay position-absolute top-0 start-0 end-0 bottom-0 d-flex align-items-end p-4"
                                            style="background: linear-gradient(transparent, rgba(0,0,0,0.8)); opacity: 0; transition: opacity 0.4s;">
                                            <h5 class="mb-0 fw-bold">{{ $post->title }}</h5>
                                        </div>
                                    </div>

                                    <div class="p-4">
                                        <h5 class="fw-bold mb-3 line-clamp-2">
                                            {{ Str::limit($post->title, 60) }}
                                        </h5>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-warning">
                                                {{ $post->created_at->format('d/m/Y') }}
                                            </small>
                                            <span class="text-danger fw-bold small">
                                                Xem thêm →
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </article>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <p class="text-white-50 fs-4">Chưa có bài viết nào.</p>
                </div>
            @endif
        </div>

    </div>
@endsection
