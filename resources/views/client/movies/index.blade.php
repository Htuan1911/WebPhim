@extends('layouts.master')

@section('title', 'Danh sách phim')

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
        <div class="py-5">
            <h2 class="title-1">🎥 Phim sắp chiếu</h2>
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
        </div>

        <div class="container">
            <div class="header-filter">
                <h2 class="text-pink">Tìm phim chiếu trên rạp</h2>
                <form method GET action="{{ route('client.movies.index') }}">
                    <div>
                        <select name="genre">
                            <option value="">Thể loại</option>
                            @foreach (['Hành động', 'Hài', 'Kinh dị', 'Tình cảm', 'Viễn tưởng', 'Hoạt hình', 'Tâm lý', 'Phiêu lưu', 'Khoa học', 'Tội phạm crime'] as $g)
                                <option value="{{ $g }}" {{ request('genre') === $g ? 'selected' : '' }}>
                                    {{ $g }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select name="year">
                            <option value="">Năm</option>
                            @for ($y = now()->year + 1; $y >= 2020; $y--)
                                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                    {{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <input type="text" name="search" placeholder="Nhập tên phim..."
                            value="{{ request('search') }}">
                    </div>
                    <!-- 4. Nút tìm & reset -->
                    <div class="flex items-end gap-3">
                        <button type="submit">
                            Tìm kiếm
                        </button>

                        @if (request()->filled(['search', 'genre', 'year']))
                            <a href="{{ route('client.movies.index') }}">
                                Xóa lọc
                            </a>
                        @endif
                    </div>
                </form>
            </div>
            <div class="row">
                @forelse ($movies as $movie)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="movie-poster-container">
                                <a href="{{ route('client.movies.show', $movie->id) }}">
                                    <img src="{{ asset('storage/' . $movie->poster) }}" class="card-img-top movie-poster"
                                        alt="{{ $movie->title }}">
                                </a>
                            </div>
                            <div class="card-body text-center d-flex flex-column">
                                <a href="{{ route('client.movies.show', $movie->id) }}" class="text-decoration-none text-dark">
                                    <h5 class="card-title">{{ $movie->title }}</h5>
                                </a>
                                <p class="mb-1"><strong>Thể loại:</strong> {{ $movie->genre }}</p>
                                <p class="mb-1"><strong>Thời lượng:</strong> {{ $movie->duration }} phút</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">Không tìm thấy phim nào.</p>
                @endforelse
            </div>
        </div>
    </div>
    {{-- Phân trang --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $movies->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    </div>
@endsection
