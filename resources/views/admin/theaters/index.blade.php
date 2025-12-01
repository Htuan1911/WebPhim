@extends('layouts.admin')

@section('title', 'Quản lý Rạp Chiếu Phim')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Danh sách Rạp chiếu phim</h1>
        <a href="{{ route('admin.theaters.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Thêm rạp mới
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="60">#</th>
                            <th>Hãng rạp</th>
                            <th>Ảnh rạp</th>
                            <th>Tên rạp</th>
                            <th>Số ghế</th>
                            <th width="150">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($theaters as $theater)
                            <tr>
                                <td class="text-center fw-bold">
                                    {{ $loop->iteration + ($theaters->currentPage() - 1) * $theaters->perPage() }}</td>
                                <td>
                                    @if ($theater->cinemaCategory)
                                        <div class="d-flex align-items-center">
                                            {{ $theater->cinemaCategory->name }}
                                        </div>
                                    @else
                                        <span class="text-muted">Chưa chọn hãng</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($theater->image)
                                        <img src="{{ asset('storage/' . $theater->image) }}" alt="{{ $theater->name }}"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-light border rounded d-flex align-items-center justify-content-center"
                                            style="width: 100px; height: 70px;">
                                            <i class="fas fa-image text-muted fa-2x"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    {{ $theater->name }}
                                    @if ($theater->address)
                                        <br><small class="text-muted">{{ Str::limit($theater->address, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    {{ $theater->total_seats }} ghế
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.theaters.edit', $theater) }}"
                                            class="btn btn-warning btn-sm" title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.theaters.destroy', $theater) }}" method="POST"
                                            class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Xóa rạp này? Tất cả phòng chiếu và suất chiếu sẽ bị ảnh hưởng!')"
                                                title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-theater-masks fa-3x mb-3"></i>
                                    <p>Chưa có rạp chiếu phim nào</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $theaters->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
