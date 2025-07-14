@extends('layouts.master')

@section('title', 'Danh sách rạp chiếu')

@section('content')
    <div class="container py-5">
        <h2 class="text-center mb-4 text-light">🎬 Danh sách rạp chiếu theo hệ thống</h2>

        @php
            $groupedTheaters = $theaters->groupBy('category');
        @endphp

        @forelse ($groupedTheaters as $category => $group)
            <div class="mb-5">
                <h3 class="text-center mb-4 py-3 rounded fw-bold" style="background-color: #c71585; color: white;">
                    {{ $category }}
                </h3>

                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3">
                    @foreach ($group as $theater)
                        <div class="col">
                            <div class="card h-100 shadow-sm border-0">
                                <img src="{{ asset('storage/' . $theater->image) }}" alt="{{ $theater->name }}"
                                    class="card-img-top" style="height: 140px; object-fit: cover;">

                                <div class="card-body p-2">
                                    <h6 class="card-title text-truncate mb-1">{{ $theater->name }}</h6>
                                    <p class="text-muted small mb-1">
                                        🪑 {{ $theater->total_seats }} ghế
                                    </p>
                                    <a href="{{ route('client.theaters.show', $theater->id) }}"
                                        class="btn btn-sm btn-outline-primary w-100">
                                        Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-center text-white">Không có rạp chiếu nào.</p>
        @endforelse
    </div>
@endsection
