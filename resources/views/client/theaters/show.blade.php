@extends('layouts.master')

@section('title', $theater->name)

@section('content')
    <div class="container py-5">
        <a href="{{ route('client.theaters.index') }}" class="btn btn-outline-secondary mb-4">
            ← Quay lại danh sách rạp
        </a>

        {{-- Thông tin rạp --}}
        <div class="rounded-3 overflow-hidden mb-5 shadow-sm"
            style="background: url('https://png.pngtree.com/background/20211216/original/pngtree-real-shots-of-the-empty-and-spacious-theater-movie-theater-scenes-picture-image_1517322.jpg') center center / cover no-repeat;">

            <div class="row align-items-center p-4" style="background-color: rgba(0, 0, 0, 0.5); color: white;">
                <div class="col-md-4">
                    <img src="{{ asset('storage/' . $theater->image) }}" alt="{{ $theater->name }}"
                        class="img-fluid rounded shadow">
                </div>
                <div class="col-md-8">
                    <h2 class="fw-bold">{{ $theater->name }}</h2>
                    <p class="mb-1"><strong>Loại rạp:</strong> {{ $theater->category }}</p>
                    <p class="mb-1"><strong>Tổng số ghế:</strong> {{ $theater->total_seats }}</p>
                    <p class="mb-1"><strong>Số phòng chiếu:</strong> {{ $theater->cinemaRooms->count() }}</p>
                </div>
            </div>
        </div>

        {{-- Danh sách phòng chiếu & suất chiếu --}}
        <h4 class="mb-3">🎬 Danh sách phòng & suất chiếu</h4>

        @forelse ($theater->cinemaRooms as $room)
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Phòng: {{ $room->name ?? 'Không tên' }} (ID: {{ $room->id }})</h5>
                </div>
                <div class="card-body">
                    @if ($room->showtimes->isEmpty())
                        <p class="text-muted">Không có suất chiếu nào trong phòng này.</p>
                    @else
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                            @foreach ($room->showtimes->sortBy('start_time') as $showtime)
                                <div class="col">
                                    <div class="card h-100 border-light shadow-sm">
                                        <div class="row g-0">
                                            <div class="col-4">
                                                <img src="{{ asset('storage/' . $showtime->movie->poster) }}"
                                                    alt="{{ $showtime->movie->title }}" class="img-fluid rounded-start"
                                                    style="height: 100%; object-fit: cover;">
                                            </div>
                                            <div class="col-8">
                                                <div class="card-body">
                                                    <h6 class="card-title mb-1">{{ $showtime->movie->title }}</h6>
                                                    <p class="card-text mb-2 text-muted" style="font-size: 14px;">
                                                        🕒
                                                        {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i d/m/Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="alert alert-warning">Rạp chưa có phòng chiếu nào.</div>
        @endforelse
    </div>
@endsection
