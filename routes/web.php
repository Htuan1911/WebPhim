
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CinemaRoomController;
use App\Http\Controllers\TheaterController;
use App\Http\Controllers\ComboController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\ShowtimeController;
use App\Http\Controllers\OrderController;

use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\OrderController as ClientOrderController;
use App\Http\Controllers\Client\TheaterController as ClientTheaterController;
use App\Http\Controllers\Client\MovieController as ClientMovieController;
use App\Http\Controllers\ReviewController as ClientReviewController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    // Các đường dẫn trong nhóm admin sẽ đặt trong đây
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Route quản lý phim
    Route::prefix('movies')->name('movies.')->group(function () {
        Route::get('/',                     [MovieController::class, 'index'])->name('index');
        Route::get('/create',               [MovieController::class, 'create'])->name('create');
        Route::post('/store',               [MovieController::class, 'store'])->name('store');
        Route::get('/{id}/edit',            [MovieController::class, 'edit'])->name('edit');
        Route::put('/{id}/update',          [MovieController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy',      [MovieController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('showtimes')->name('showtimes.')->group(function () {
        Route::get('/',                     [ShowtimeController::class, 'index'])->name('index');
        Route::get('/create',               [ShowtimeController::class, 'create'])->name('create');
        Route::post('/store',               [ShowtimeController::class, 'store'])->name('store');
        Route::get('/{id}/edit',            [ShowtimeController::class, 'edit'])->name('edit');
        Route::put('/{id}/update',          [ShowtimeController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy',      [ShowtimeController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('theaters')->name('theaters.')->group(function () {
        Route::get('/',                     [TheaterController::class, 'index'])->name('index');
        Route::get('/create',               [TheaterController::class, 'create'])->name('create');
        Route::post('/store',               [TheaterController::class, 'store'])->name('store');
        Route::get('/{id}/edit',            [TheaterController::class, 'edit'])->name('edit');
        Route::put('/{id}/update',          [TheaterController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy',      [TheaterController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('cinema-rooms')->name('cinema-rooms.')->group(function () {
        Route::get('/',                     [CinemaRoomController::class, 'index'])->name('index');
        Route::get('/create',               [CinemaRoomController::class, 'create'])->name('create');
        Route::post('/store',               [CinemaRoomController::class, 'store'])->name('store');
        Route::get('/{id}/edit',            [CinemaRoomController::class, 'edit'])->name('edit');
        Route::put('/{id}/update',          [CinemaRoomController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy',      [CinemaRoomController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('seats')->name('seats.')->group(function () {
        Route::get('/', [SeatController::class, 'index'])->name('index');
        Route::get('/create', [SeatController::class, 'create'])->name('create');
        Route::post('/store', [SeatController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [SeatController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [SeatController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [SeatController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('combos')->name('combos.')->group(function () {
        Route::get('/', [ComboController::class, 'index'])->name('index');
        Route::get('/create', [ComboController::class, 'create'])->name('create');
        Route::post('/store', [ComboController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ComboController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [ComboController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [ComboController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/show/{id}', [OrderController::class, 'show'])->name('show');
        Route::delete('/{id}/destroy', [OrderController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/',                     [PostController::class, 'index'])->name('index');
        Route::get('/create',               [PostController::class, 'create'])->name('create');
        Route::post('/store',               [PostController::class, 'store'])->name('store');
        Route::get('/{id}/edit',            [PostController::class, 'edit'])->name('edit');
        Route::put('/{id}/update',          [PostController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy',      [PostController::class, 'destroy'])->name('destroy');
    });

    // Route quản lý đánh giá
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/',                     [ReviewController::class, 'index'])->name('index');
        Route::delete('/{id}/destroy',      [ReviewController::class, 'destroy'])->name('destroy');
    });
});


Route::prefix('client')->name('client.')->group(function () {

    // Trang chủ
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Danh sách phim
    Route::get('/movies', [ClientMovieController::class, 'index'])->name('movies.index');

    // Chi tiết phim
    Route::get('/movies/{id}', [ClientMovieController::class, 'show'])->name('movies.show');
    Route::get('/order/{showtime}', [ClientOrderController::class, 'create'])->name('order.create');
    Route::get('/order', [ClientOrderController::class, 'handleMomoReturn'])->name('order.momo_return');
    Route::post('/order/ipn', [ClientOrderController::class, 'handleMomoIpn'])->name('order.momo_ipn');
    Route::get('/orders/history', [ClientOrderController::class, 'history'])->name('orders.history');

    // Cổng thanh toán
    Route::post('/client/momo_payment', [ClientOrderController::class, 'momo_payment'])->name('order.momo_payment');

    Route::get('/rap-chieu', [ClientTheaterController::class, 'index'])->name('theaters.index');
    Route::get('/rap-chieu/{id}', [ClientTheaterController::class, 'show'])->name('theaters.show');

    Route::post('/orders/{order}/reviews', [\App\Http\Controllers\Client\ReviewController::class, 'store'])
        ->name('reviews.store')
        ->middleware('auth');

    // Trang xem tất cả đánh giá của 1 phim
    Route::get('/movies/{movie}/reviews', [\App\Http\Controllers\Client\ReviewController::class, 'list'])
        ->name('reviews.list');;
});
