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
    <style>
        body {
            background-color: #ffffff;
            color: #333;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            background-color: #ffe4ec;
        }

        .navbar-brand {
            font-weight: bold;
            color: #e91e63 !important;
        }

        .nav-link {
            color: #333 !important;
            margin-right: 1rem;
            transition: color 0.3s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #e91e63 !important;
        }

        .section-title {
            font-size: 1.6rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            color: #e91e63;
        }

        .movie-card {
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #f8cdd8;
            border-radius: 8px;
            overflow: hidden;
            background: #fff;
        }

        .movie-card:hover {
            transform: scale(1.03);
            box-shadow: 0 4px 20px rgba(233, 30, 99, 0.2);
        }

        .movie-card .age-label {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #e91e63;
            color: #fff;
            font-weight: bold;
            font-size: 0.75rem;
            padding: 2px 6px;
            border-radius: 4px;
        }

        .movie-card .play-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 2rem;
            color: #e91e63;
            opacity: 0.8;
        }

        .movie-card .ranking {
            position: absolute;
            bottom: 10px;
            left: 10px;
            font-size: 1.2rem;
            font-weight: bold;
            color: #e91e63;
        }

        footer {
            background: #ffe4ec;
            padding: 20px 0;
            text-align: center;
            font-size: 0.9rem;
            color: #555;
        }

        .btn-primary {
            background-color: #e91e63;
            border-color: #e91e63;
        }

        .btn-primary:hover {
            background-color: #d81b60;
            border-color: #d81b60;
        }

        .swiper {
            padding-bottom: 30px;
        }

        .swiper-slide {
            width: 200px;
        }
    </style>



    @stack('styles')
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
    <main class="container py-5">
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
</body>

</html>
