<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Đặt vé xem phim')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap + Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    {{-- SwiperJS (slider) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    {{-- Custom CSS --}}



    @stack('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/master.css') }}">
    <link rel="stylesheet" href="{{ asset('css/oder.css') }}">
    <link rel="stylesheet" href="{{ asset('css/movie.css') }}">
    <link rel="stylesheet" href="{{ asset('css/review.css') }}">
</head>

<body>

    {{-- HEADER --}}
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('client.home') }}">
                <i class="bi bi-film fs-4 me-1"></i> Đặt vé xem phim
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('client.home') }}">Lịch chiếu</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('client.theaters.index') }}">Rạp chiếu</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('client.movies.index') }}">Phim chiếu</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#">Top phim</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('client.orders.history') }}">Lịch sử đặt
                            vé</a></li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- NỘI DUNG --}}
    <main class="containerr">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer>
        <div class="container">
            &copy; {{ date('Y') }} MomoCinema. Đặt vé xem phim mọi lúc mọi nơi.
        </div>
    </footer>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    @stack('scripts')
    <script src="{{ asset('js/review.js') }}"></script>
</body>

</html>
