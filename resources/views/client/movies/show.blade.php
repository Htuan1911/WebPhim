@extends('layouts.master')

@section('content')
    <div class="container py-5">
        <div class="row">
            {{-- Cột trái: thông tin phim + bộ lọc + suất chiếu --}}
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ asset('storage/' . $movie->poster) }}" class="img-fluid rounded shadow"
                            alt="{{ $movie->title }}">
                    </div>
                    <div class="col-md-8">
                        <h2 class="mb-3">{{ $movie->title }}</h2>
                        <p><strong>Thể loại:</strong> {{ $movie->genre }}</p>
                        <p><strong>Thời lượng:</strong> {{ $movie->duration }} phút</p>
                        <p><strong>Ngày khởi chiếu:</strong>
                            {{ \Carbon\Carbon::parse($movie->release_date)->format('d/m/Y') }}</p>
                        <p><strong>Mô tả:</strong></p>
                        <p>{{ $movie->description }}</p>

                        {{-- <h5 class="mt-4">📅 Suất chiếu:</h5>
                        @if ($movie->showtimes->isEmpty())
                            <p>Chưa có suất chiếu.</p>
                        @else
                            <ul class="list-group">
                                @foreach ($movie->showtimes as $showtime)
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Phòng: {{ $showtime->cinemaRoom->name ?? 'N/A' }}</span>
                                        <span>{{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i d/m/Y') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif --}}
                    </div>
                </div>

                <h5 class="mt-4">{{ $movie->title }}</h5>

                <form method="GET" id="filterForm" class="mb-4">
                    <input type="hidden" name="date" id="inputDate" value="{{ request('date') }}">
                    <input type="hidden" name="category" id="inputCategory" value="{{ request('category') }}">
                    <input type="hidden" name="theater_id" id="inputTheater" value="{{ request('theater_id') }}">

                    {{-- Nút chọn ngày --}}
                    <div class="mb-3">
                        <strong>Chọn ngày:</strong>
                        <div class="d-flex gap-2 flex-wrap mt-1">
                            @foreach ($weekDates as $date)
                                @php
                                    $carbon = \Carbon\Carbon::parse($date);
                                @endphp
                                <button type="button"
                                    class="btn btn-sm d-flex flex-column align-items-center justify-content-center p-2 dateBtn
                    {{ request('date') == $date ? 'btn-primary text-white' : 'btn-outline-primary' }}"
                                    style="width: 60px; height: 60px;" data-date="{{ $date }}">
                                    <span style="font-size: 18px; font-weight: bold;">{{ $carbon->format('d') }}</span>
                                    <div style="width: 80%; border-top: 1px solid rgba(0,0,0,0.2); margin: 4px 0;"></div>
                                    <span style="font-size: 12px;">{{ $carbon->translatedFormat('D') }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Nút chọn danh mục rạp --}}
                    <div class="mb-3">
                        <strong>Chọn danh mục rạp:</strong>
                        <div class="d-flex flex-wrap gap-3 mt-2">
                            <button type="button"
                                class="btn btn-light border p-2 categoryBtn {{ !request('category') ? 'border-primary' : '' }}"
                                style="min-width: 100px;" data-category="">
                                Tất cả
                            </button>

                            @php
                                $uniqueCategories = $theaters->pluck('category')->unique();
                            @endphp

                            @foreach ($uniqueCategories as $category)
                                <button type="button"
                                    class="btn btn-light border p-2 categoryBtn {{ request('category') == $category ? 'border-primary' : '' }}"
                                    style="min-width: 100px;" data-category="{{ $category }}">
                                    {{ $category ?? 'Chưa có danh mục' }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Nút chọn rạp --}}
                    <div class="mb-3">
                        <strong>Chọn rạp:</strong>
                        <div class="d-flex flex-column gap-2 mt-2">
                            @php
                                $selectedCategory = request('category');
                                $filteredTheaters = $selectedCategory
                                    ? $theaters->where('category', $selectedCategory)
                                    : $theaters;
                            @endphp

                            @foreach ($filteredTheaters as $theater)
                                @php
                                    $theaterShowtimes = $showtimes
                                        ->filter(fn($s) => $s->cinemaRoom->theater_id == $theater->id)
                                        ->sortBy('start_time');
                                @endphp

                                <div class="border rounded p-3 shadow-sm">
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <img src="{{ asset('storage/' . $theater->image) }}" alt="{{ $theater->name }}"
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                        <div>
                                            <strong>{{ $theater->name }}</strong><br>
                                            <small>{{ $theater->address }}</small>
                                        </div>
                                    </div>

                                    {{-- Hiển thị suất chiếu bên dưới --}}
                                    @if ($theaterShowtimes->isEmpty())
                                        <p class="text-muted mb-0">Không có suất chiếu trong ngày.</p>
                                    @else
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($theaterShowtimes as $showtime)
                                                <a href="{{ route('client.order.create', $showtime->id) }}" class="btn btn-outline-primary btn-sm">
                                                    {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}
                                                    - {{ $showtime->cinemaRoom->name ?? 'Phòng?' }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach

                        </div>
                    </div>
                </form>
            </div>

            {{-- Cột phải: danh sách phim đang chiếu --}}
            <div class="col-md-3">
                <h5 class="mb-3">🎬 Phim đang chiếu</h5>
                <div class="d-flex flex-column gap-3">
                    @foreach ($nowShowingMovies as $nowMovie)
                        <a href="{{ route('client.movies.show', $nowMovie->id) }}" class="text-decoration-none text-dark">
                            <div class="d-flex flex-row align-items-center gap-2 border rounded p-2 shadow-sm">
                                <img src="{{ asset('storage/' . $nowMovie->poster) }}" alt="{{ $nowMovie->title }}"
                                    class="rounded" style="width: 60px; height: 90px; object-fit: cover;">
                                <span style="font-size: 14px;">{{ $nowMovie->title }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('filterForm');

        // Các input ẩn giữ giá trị filter
        const inputDate = document.getElementById('inputDate');
        const inputCategory = document.getElementById('inputCategory');
        const inputTheater = document.getElementById('inputTheater');

        // Khi bấm nút chọn ngày
        document.querySelectorAll('.dateBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                inputDate.value = this.dataset.date;
                // Giữ nguyên category và theater
                form.submit();
            });
        });

        // Khi bấm nút chọn danh mục
        document.querySelectorAll('.categoryBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                inputCategory.value = this.dataset.category;
                // Reset theater vì thay đổi category
                inputTheater.value = '';
                form.submit();
            });
        });

        // Khi bấm nút chọn rạp
        document.querySelectorAll('.theaterBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                inputTheater.value = this.dataset.theater;
                // Giữ nguyên date và category
                form.submit();
            });
        });
    });
</script>
