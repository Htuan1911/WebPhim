<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Đặt vé xem phim')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap + Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

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
    <footer class="footer-section pt-5 pb-4" style="background-color: #ffe4ec; color: #333;">
        <div class="container">
            <div class="row g-5">

                <!-- Cột 1: Logo + Giới thiệu -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand mb-4">
                        <h3 class="fw-bold" style="color: #e11d48;">
                            <i class="fas fa-film me-2"></i>MoMo<span style="color: #333;">Cinema</span>
                        </h3>
                        <p class="small text-muted mt-3" style="color: #555 !important;">
                            Đặt vé xem phim nhanh chóng – thanh toán tức thì qua MoMo.<br>
                            Hàng ngàn suất chiếu mỗi ngày tại hơn 100+ cụm rạp toàn quốc.
                        </p>
                        <div class="download-app mt-4">
                            <p class="small fw-bold text-uppercase mb-2" style="color: #e11d48;">Tải ứng dụng</p>
                            <a href="#" class="me-3">
                                <img src="https://homepage.momocdn.net/img/momo-upload-api-230127102243-637790077630000000.svg"
                                    alt="App Store" height="42">
                            </a>
                            <a href="#">
                                <img src="https://homepage.momocdn.net/img/momo-upload-api-230127102301-637790077810000000.svg"
                                    alt="Google Play" height="42">
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Cột 2: Khám phá -->
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <h5 class="fw-bold mb-4" style="color: #e11d48;">Khám phá</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><a href="{{ route('client.movies.index') }}" class="footer-link">Phim đang
                                chiếu</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Phim sắp chiếu</a></li>
                        <li class="mb-2"><a href="{{ route('client.theaters.index') }}" class="footer-link">Rạp chiếu
                                phim</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Ưu đãi & Khuyến mãi</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Tin
                                tức</a></li>
                    </ul>
                </div>

                <!-- Cột 3: Hỗ trợ -->
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <h5 class="fw-bold mb-4" style="color: #e11d48;">Hỗ trợ</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><a href="#" class="footer-link">Hướng dẫn đặt vé</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Chính sách hoàn vé</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Điều khoản sử dụng</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Bảo mật thông tin</a></li>
                        <li class="mb-2"><a href="#" class="footer-link">Câu hỏi thường gặp</a></li>
                    </ul>
                </div>

                <!-- Cột 4: Liên hệ & Mạng xã hội -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-bold mb-4" style="color: #e11d48;">Liên hệ với chúng tôi</h5>
                    <div class="contact-info mb-4 text-muted">
                        <p class="small mb-2">
                            <i class="fas fa-phone-alt me-2" style="color: #e11d48;"></i>
                            Hotline: <strong style="color: #333;">1900 1234</strong> (24/7)
                        </p>
                        <p class="small mb-2">
                            <i class="fas fa-envelope me-2" style="color: #e11d48;"></i>
                            Email: <a href="mailto:support@momocinema.vn"
                                class="footer-link">support@momocinema.vn</a>
                        </p>
                        <p class="small">
                            <i class="fas fa-map-marker-alt me-2" style="color: #e11d48;"></i>
                            Tầng 15, Tòa nhà Viettel, Hà Nội
                        </p>
                    </div>

                    <div class="social-links">
                        <p class="small fw-bold text-uppercase mb-3" style="color: #e11d48;">Theo dõi chúng tôi</p>
                        <a href="#" class="social-icon me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon me-2"><i class="fab fa-tiktok"></i></a>
                        <a href="#" class="social-icon me-2"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="social-icon me-2"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>

            <hr class="my-5" style="border-color: #e11d48; opacity: 0.3;">

            <!-- Bản quyền & Thanh toán -->
            <div class="row align-items-center text-center text-md-start">
                <div class="col-md-6">
                    <p class="small text-muted mb-0">
                        © {{ date('Y') }} <strong style="color: #e11d48;">MoMoCinema</strong> – Phát triển bởi
                        MoMo.
                        Tất cả quyền được bảo lưu.
                    </p>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <span class="small text-muted me-3">Thanh toán an toàn với:</span>
                    <img src="https://www.momo.vn/img/logo-momo.png" alt="MoMo" height="32" class="me-2">
                    <img src="https://www.napasthe.com.vn/assets/frontend/images/vnpay.png" alt="VNPAY"
                        height="32" class="me-2">
                    <img src="https://vietqr.net/portal-data/upload/partners/2023/10/mb.png" alt="MB Bank"
                        height="32">
                </div>
            </div>
        </div>
    </footer>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    @stack('scripts')
    <script src="{{ asset('js/oder.js') }}"></script>
    <script src="{{ asset('js/movie.js') }}"></script>
    <script src="{{ asset('js/home.js') }}"></script>
</body>

</html>
