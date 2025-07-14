@extends('layouts.admin')

@section('content')
    <h1>Sửa phòng chiếu</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.cinema-rooms.update', $room->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Tên phòng</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $room->name) }}" required>
        </div>
        <div class="mb-3">
            <label>Số ghế</label>
            <input type="number" name="total_seats" class="form-control" value="{{ old('total_seats', $room->total_seats) }}" required min="1">
        </div>
        <div class="mb-3">
            <label>Rạp chiếu</label>
            <select name="theater_id" class="form-select" required>
                <option value="">-- Chọn rạp chiếu --</option>
                @foreach ($theaters as $theater)
                    <option value="{{ $theater->id }}" 
                        {{ old('theater_id', $room->theater_id) == $theater->id ? 'selected' : '' }}>
                        {{ $theater->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('admin.cinema-rooms.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection
