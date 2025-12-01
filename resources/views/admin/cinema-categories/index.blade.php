@extends('layouts.admin')

@section('title', 'Quản lý Danh mục Rạp')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Danh sách Danh mục Rạp</h5>
        <a href="{{ route('admin.cinema-categories.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Thêm mới
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Logo</th>
                        <th>Tên</th>
                        <th>Số rạp</th>
                        <th>Thứ tự</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                        <td>
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="" width="60" class="rounded">
                            @else
                                <span class="text-muted">Chưa có</span>
                            @endif
                        </td>
                        <td><strong>{{ $category->name }}</strong></td>
                        <td>{{ $category->theaters->count() }}</td>
                        <td>{{ $category->priority }}</td>
                        <td>
                            <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $category->is_active ? 'Hoạt động' : 'Tạm ẩn' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.cinema-categories.edit', $category) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.cinema-categories.destroy', $category) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xóa thật chứ?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center">Chưa có danh mục nào</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $categories->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection