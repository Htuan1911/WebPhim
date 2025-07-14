@extends('layouts.admin')

@section('content')
    <h1>
        Thêm lịch chiếu mới</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.showtimes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Phim</label>
            <select name="movie_id" class="form-control" required>
                <option value="">-- Chọn phim --</option>
                @foreach ($movies as $movie)
                    <option value="{{ $movie->id }}" {{ old('movie_id') == $movie->id ? 'selected' : '' }}>
                        {{ $movie->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Rạp</label>
            <select name="theater_id" class="form-control" required>
                <option value="">-- Chọn rạp --</option>
                @foreach ($theaters as $theater)
                    <option value="{{ $theater->id }}" {{ old('theater_id') == $theater->id ? 'selected' : '' }}>
                        {{ $theater->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Phòng chiếu</label>
            <select name="cinema_room_id" class="form-control" required>
                <option value="">-- Chọn phòng chiếu --</option>
                @foreach ($cinemaRooms as $room)
                    <option value="{{ $room->id }}" {{ old('cinema_room_id') == $room->id ? 'selected' : '' }}>
                        {{ $room->name }} ({{ $room->total_seats }} ghế)
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Giá vé</label>
            <input type="text" name="ticket_price" class="form-control" value="{{ old('ticket_price') }}" required>
        </div>

        <div class="mb-3">
            <label>Thời gian bắt đầu</label>
            <input type="datetime-local" name="start_time" class="form-control" value="{{ old('start_time') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('admin.showtimes.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
@endsection
