<div class="d-flex flex-column p-3 text-white bg-dark" style="height: 100vh;">
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link text-white">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('admin.movies.index') }}" class="nav-link text-white">
                <i class="fas fa-film me-2"></i> Quản lý phim
            </a>
        </li>
        <li>
            <a href="{{ route('admin.theaters.index') }}" class="nav-link text-white">
                <i class="fas fa-building me-2"></i> Quản lý rạp chiếu
            </a>
        </li>
        <li>
            <a href="{{ route('admin.cinema-rooms.index') }}" class="nav-link text-white">
                <i class="fas fa-door-open me-2"></i> Quản lý phòng chiếu
            </a>
        </li>
        <li>
            <a href="{{ route('admin.seats.index') }}" class="nav-link text-white">
                <i class="fas fa-chair me-2"></i> Quản lý ghế
            </a>
        </li>
        <li>
            <a href="{{ route('admin.showtimes.index') }}" class="nav-link text-white">
                <i class="fas fa-clock me-2"></i> Quản lý suất chiếu
            </a>
        </li>
        <li>
            <a href="{{ route('admin.combos.index') }}" class="nav-link text-white">
                <i class="fas fa-hamburger me-2"></i> Quản lý đồ ăn
            </a>
        </li>
        <li>
            <a href="{{ route('admin.orders.index') }}" class="nav-link text-white">
                <i class="fas fa-hamburger me-2"></i> Quản lý đặt hàng
            </a>
        </li>
    </ul>

    <div class="sidebar-footer text-center py-3">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger w-75">
                <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
            </button>
        </form>
    </div>
</div>
