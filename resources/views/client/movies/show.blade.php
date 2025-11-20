@extends('layouts.master')

@section('content')
    <div class="movie-detail-hero"
        style="background-image: url('{{ asset('storage/' . $movie->banner) }}'); 
            background-size: cover; 
            background-position: center;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 title">
                    <div class="movie-poster-wrapper text-center">
                        <img src="{{ asset('storage/' . $movie->poster) }}" class="movie-poster img-fluid"
                            alt="{{ $movie->title }}">

                        <div class="play-trailer-btn" onclick="alert('Chức năng xem trailer đang phát triển')">
                            <!-- Icon play -->
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 col-md-7">
                    <div class="movie-info-card">
                        <div class="badge-age">{{ $movie->age_rating ?? 'P' }}</div>
                        <h1 class="display-9 fw-bold">{{ $movie->title }}</h1>
                        <small>
                            {{ $movie->title }} • {{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }} •
                            {{ $movie->duration }} phút
                        </small>

                        <h5 class="mt-2">Nội dung</h5>
                        <div class="description-full" id="descriptionText">
                            {!! nl2br(e($movie->description)) !!}
                        </div>
                        @if (strlen($movie->description) > 200)
                            <span class="description-toggle" onclick="toggleDescription()">
                                ...Xem thêm
                            </span>
                        @endif

                        <div class="row mb-4 mt2">
                            <div class="col-6">
                                <strong>Ngày chiếu</strong><br>
                                <span class="text-white">
                                    {{ \Carbon\Carbon::parse($movie->release_date)->format('d/m/Y') }}
                                </span>
                            </div>
                            <div class="col-6">
                                <strong>Thể loại</strong><br>
                                <span class="text-white">{{ $movie->genre }}</span>
                            </div>
                        </div>

                        <!-- Nút hành động -->
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="{{ $movie->trailer }}" target="_blank" class="btn-trailer">
                                Xem trailer
                            </a>
                            <a href="{{ route('client.reviews.list', $movie->id) }}" class="btn-review">
                                Xem review
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col-md-8 showtime-filter-wrapper">
                <h5>{{ $movie->title }}</h5>

                <form method="GET" id="filterForm">
                    <input type="hidden" name="date" id="inputDate" value="{{ request('date') }}">
                    <input type="hidden" name="category" id="inputCategory" value="{{ request('category') }}">

                    {{-- Chọn ngày --}}
                    <div class="mb-3">
                        <strong class="filter-label">Chọn ngày:</strong>
                        <div class="d-flex gap-2 flex-wrap mt-1">
                            @foreach ($weekDates as $date)
                                @php $c = \Carbon\Carbon::parse($date); @endphp
                                <button type="button"
                                    class="dateBtn {{ request('date') == $date ? 'active' : 'default' }}"
                                    data-date="{{ $date }}">
                                    <span class="day-number">{{ $c->format('d') }}</span>
                                    <div class="divider-line"></div>
                                    <span class="weekday">{{ $c->translatedFormat('D') }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Chọn danh mục rạp --}}
                    <div class="mb-3">
                        <strong class="filter-label d-block mb-3 fs-5 text-primary">
                            Chọn hãng rạp:
                        </strong>

                        <div class="d-flex flex-wrap gap-3 justify-content-start">
                            <!-- Nút "Tất cả" – màu hồng giống ảnh -->
                            <button type="button"
                                class="categoryBtn cinema-brand-btn {{ !request('category_id') || request('category_id') === 'all' ? 'active' : '' }}"
                                data-category-id="all">
                                <div class="position-relative mb-1">
                                    <svg width="30" height="30" viewBox="0 0 38 38" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19 2L23.5 14.5H36L26 21.5L29.5 34L19 27L8.5 34L12 21.5L2 14.5H14.5L19 2Z"
                                            fill="#f5c518" stroke="#f5c518" stroke-width="3" />
                                    </svg>
                                </div>
                                <span class="brand-name fw-bold">Tất cả</span>
                            </button>

                            <!-- Các hãng rạp -->
                            @foreach (\App\Models\CinemaCategory::where('is_active', true)->orderBy('priority', 'desc')->orderBy('name')->get() as $cat)
                                <button type="button"
                                    class="categoryBtn cinema-brand-btn {{ request('category_id') == $cat->id ? 'active' : '' }}"
                                    data-category-id="{{ $cat->id }}" title="{{ $cat->name }}">

                                    <div class="brand-icon-wrapper">
                                        @if ($cat->image)
                                            <img src="{{ asset('storage/' . $cat->image) }}" alt="{{ $cat->name }}"
                                                class="brand-logo">
                                        @else
                                            <i class="fas fa-film fa-2x text-secondary"></i>
                                        @endif
                                    </div>

                                    <span class="brand-name">{{ $cat->name }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Danh sách rạp --}}
                    {{-- Danh sách rạp có suất chiếu --}}
                    <div class="mb-3">
                        <strong class="filter-label">Chọn rạp:</strong>
                        <div class="d-flex flex-column gap-3 mt-3">

                            @forelse($groupedShowtimes as $theaterId => $showtimesGroup)
                                @php
                                    $theater = $showtimesGroup->first()->cinemaRoom->theater;
                                @endphp

                                <div class="theater-collapse-card">
                                    <div class="theater-collapse-header" data-bs-toggle="collapse"
                                        data-bs-target="#showtimes-{{ $theater->id }}" aria-expanded="false">
                                        <div class="d-flex align-items-center gap-3 flex-grow-1">
                                            <img src="{{ $theater->image ? asset('storage/' . $theater->image) : asset('images/default-theater.jpg') }}"
                                                alt="{{ $theater->name }}" class="theater-img rounded"
                                                style="width:60px;height:60px;object-fit:cover;">
                                            <div>
                                                <strong class="theater-name">{{ $theater->name }}</strong>
                                                @if ($theater->cinemaCategory)
                                                @endif
                                            </div>
                                        </div>
                                        <span class="collapse-arrow">
                                            <i class="bi bi-chevron-down"></i>
                                        </span>
                                    </div>

                                    <div class="collapse" id="showtimes-{{ $theater->id }}">
                                        <div class="theater-showtimes-body p-3">
                                            <div class="d-flex flex-wrap gap-3">
                                                @foreach ($showtimesGroup as $showtime)
                                                    <a href="{{ route('client.order.create', $showtime->id) }}"
                                                        class="btn btn-outline-danger btn-sm px-4">
                                                        {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}
                                                        <br>
                                                        <small class="text-dark">{{ $showtime->cinemaRoom->name }}</small>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @empty
                                <div class="text-center py-5 text-muted">
                                    <i class="fas fa-calendar-times fa-3x mb-3"></i>
                                    <p class="fs-5">Không có suất chiếu nào trong ngày này</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </form>
            </div>

            {{-- Cột phải: danh sách phim đang chiếu --}}
            <div class="col-md-4 movie-sidebar">
                <h5 class="mb-4">Phim đang chiếu</h5>

                <div class="now-showing-list">
                    @foreach ($nowShowingMovies as $movie)
                        <a href="{{ route('client.movies.show', $movie->id) }}"
                            class="now-showing-item text-decoration-none text-dark d-block">

                            <div class="d-flex align-items-start gap-3 py-3">
                                <!-- Poster -->
                                <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}"
                                    class="now-showing-poster rounded">

                                <!-- Thông tin -->
                                <div class="flex-grow-1">
                                    <!-- Độ tuổi (đậm, nổi bật) -->
                                    <div class="age-rating">
                                        {{ $movie->age_rating ?? 'P' }}
                                    </div>

                                    <!-- Tên phim -->
                                    <div class="movie-title">
                                        {{ $movie->title }}
                                    </div>

                                    <!-- Thể loại -->
                                    <div class="movie-genre">
                                        {{ $movie->genre ?? 'Đang cập nhật' }}
                                    </div>
                                </div>
                            </div>
                        </a>

                        <!-- Đường kẻ phân cách (trừ phim cuối) -->
                        @if (!$loop->last)
                            <hr class="list-divider">
                        @endif
                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Lưu vị trí cuộn vào sessionStorage khi trang unload
        window.addEventListener('beforeunload', function() {
            sessionStorage.setItem('scrollPosition', window.scrollY);
        });

        // 2. Khi trang load xong → cuộn về vị trí cũ (nếu có)
        const savedPosition = sessionStorage.getItem('scrollPosition');
        if (savedPosition) {
            window.scrollTo(0, parseInt(savedPosition));
            // Xóa để lần sau reload không bị cuộn nhầm
            sessionStorage.removeItem('scrollPosition');
        }

        // 3. Xử lý bấm nút ngày + danh mục → submit form (reload trang)
        document.querySelectorAll('.dateBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('inputDate').value = this.dataset.date;
                document.getElementById('filterForm').submit(); // reload trang
            });
        });

        document.querySelectorAll('.categoryBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('inputCategory').value = this.dataset.category || '';
                document.getElementById('filterForm').submit(); // reload trang
            });
        });
    });
</script>
