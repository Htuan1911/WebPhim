@extends('layouts.master')

@section('content')
    <div class="container py-4">
        <style>
    .card-img-top {
        transition: transform 0.3s ease-in-out;
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    .card-img-top:hover {
        transform: scale(1.1);
    }
    .card {
        overflow: hidden;
        position: relative;
    }
    .image-container {
        position: relative;
        width: 100%;
        overflow: hidden;
    }
    .play-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50px;
        height: 50px;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
    }
    .play-button::before {
        content: '';
        display: block;
        width: 0;
        height: 0;
        border-left: 20px solid white;
        border-top: 12px solid transparent;
        border-bottom: 12px solid transparent;
    }
    .movie-scroll-container {
        position: relative;
        overflow: hidden;
        padding: 0 30px;
    }
    .movie-row {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: scroll;
        scroll-behavior: smooth;
        scrollbar-width: none;
        -ms-overflow-style: none;
        gap: 16px;
    }
    .movie-row::-webkit-scrollbar {
        display: none;
    }
    .scroll-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.8);
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        z-index: 10;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    .scroll-btn.prev {
        left: 0;
    }
    .scroll-btn.next {
        right: 0;
    }
    .scroll-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    /* Hiển thị đúng 5 phim mỗi lần */
    .movie-row .col {
        flex: 0 0 calc((100% - 64px) / 5); /* 5 phim mỗi hàng, 4 khoảng cách = 4*16 = 64px */
        max-width: calc((100% - 64px) / 5);
    }
</style>


        {{-- Phim đang chiếu --}}
        <h2 class="text-center mt-5 mb-4">🎬 Phim đang chiếu</h2>
        <div class="py-5"
            style="background: url('https://png.pngtree.com/background/20211216/original/pngtree-real-shots-of-the-empty-and-spacious-theater-movie-theater-scenes-picture-image_1517322.jpg') center center / cover no-repeat;">
            <div class="container">
                <div class="movie-scroll-container">
                    <button class="scroll-btn prev" data-target="now-showing-row" disabled><</button>
                    <div class="movie-row" id="now-showing-row">
                        @forelse($nowShowingMovies as $movie)
                            <div class="col">
                                <div class="card h-100 shadow-sm">
                                    <a href="{{ route('client.movies.show', $movie->id) }}">
                                        <div class="image-container">
                                            <img src="{{ asset('storage/' . $movie->poster) }}" class="card-img-top"
                                                alt="{{ $movie->title }}" onerror="this.src='https://via.placeholder.com/200x300';">
                                            <div class="play-button"></div>
                                        </div>
                                    </a>
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="card-title text-truncate">{{ $movie->title }}</h6>
                                        <p class="text-muted small mb-2">{{ $movie->genre }} • {{ $movie->duration }} phút</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-white">Không có phim đang chiếu.</p>
                        @endforelse
                    </div>
                    <button class="scroll-btn next" data-target="now-showing-row">></button>
                </div>
            </div>
        </div>

        {{-- Phim sắp chiếu --}}
        <h2 class="text-center mt-5 mb-4">🎥 Phim sắp chiếu</h2>
        <div class="container">
            <div class="movie-scroll-container">
                <button class="scroll-btn prev" data-target="coming-soon-row" disabled><</button>
                <div class="movie-row" id="coming-soon-row">
                    @forelse($comingSoonMovies as $movie)
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <a href="{{ route('client.movies.show', $movie->id) }}">
                                    <div class="image-container">
                                        <img src="{{ asset('storage/' . $movie->poster) }}" class="card-img-top" alt="{{ $movie->title }}"
                                            onerror="this.src='https://via.placeholder.com/200x300';">
                                        <div class="play-button"></div>
                                    </div>
                                </a>
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title text-truncate">{{ $movie->title }}</h6>
                                    <p class="text-muted small mb-2">{{ $movie->genre }} • {{ $movie->duration }} phút</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">Không có phim sắp chiếu.</p>
                    @endforelse
                </div>
                <button class="scroll-btn next" data-target="coming-soon-row">></button>
            </div>
        </div>

        {{-- Suất chiếu sắp tới --}}
        <h2 class="text-center mt-5 mb-4">📅 Suất chiếu sắp tới</h2>
        <ul class="list-group">
            @forelse($upcomingShowtimes as $showtime)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $showtime->movie->title ?? 'Không xác định' }}
                    <span>{{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i d/m/Y') }}</span>
                </li>
            @empty
                <li class="list-group-item text-center">Không có suất chiếu sắp tới.</li>
            @endforelse
        </ul>
    </div>

    <script>
        console.log('Scroll buttons initialized');
        document.querySelectorAll('.scroll-btn').forEach(button => {
            console.log('Button found:', button);
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-target');
                const row = document.getElementById(targetId);
                const card = row.querySelector('.col');
                if (!card) {
                    console.log('No cards found in row:', targetId);
                    return;
                }
                const cardWidth = card.offsetWidth + 16; // Include gap
                const scrollAmount = cardWidth * 5; // Scroll by 5 cards
                const isNext = button.classList.contains('next');

                console.log('Scrolling', isNext ? 'next' : 'prev', 'by', scrollAmount);
                row.scrollBy({
                    left: isNext ? scrollAmount : -scrollAmount,
                    behavior: 'smooth'
                });

                setTimeout(() => {
                    const prevButton = row.parentElement.querySelector('.prev');
                    const nextButton = row.parentElement.querySelector('.next');
                    if (prevButton && nextButton) {
                        prevButton.disabled = row.scrollLeft <= 0;
                        nextButton.disabled = row.scrollLeft + row.clientWidth >= row.scrollWidth - 1;
                        console.log('Button states updated:', {
                            prevDisabled: prevButton.disabled,
                            nextDisabled: nextButton.disabled
                        });
                    }
                }, 300);
            });
        });

        document.querySelectorAll('.movie-row').forEach(row => {
            const updateButtonStates = () => {
                const prevButton = row.parentElement.querySelector('.prev');
                const nextButton = row.parentElement.querySelector('.next');
                if (prevButton && nextButton) {
                    prevButton.disabled = row.scrollLeft <= 0;
                    nextButton.disabled = row.scrollLeft + row.clientWidth >= row.scrollWidth - 1;
                    console.log('Scroll state:', {
                        scrollLeft: row.scrollLeft,
                        clientWidth: row.clientWidth,
                        scrollWidth: row.scrollWidth
                    });
                }
            };
            row.addEventListener('scroll', updateButtonStates);
            updateButtonStates();
        });
    </script>
@endsection