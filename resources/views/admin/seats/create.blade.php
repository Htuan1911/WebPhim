@extends('layouts.admin')

@section('content')
    <h1>Thêm ghế</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.seats.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Phòng chiếu</label>
            <select name="cinema_room_id" class="form-control" required>
                @foreach ($cinemaRooms as $room)
                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Số ghế</label>
            <input type="text" name="seat_number" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Lưu</button>
        <a href="{{ route('admin.seats.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
@endsection
