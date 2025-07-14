<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Theater;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MovieController extends Controller
{

    // Hiển thị danh sách tất cả các phim
    public function index(Request $request)
    {
        $query = Movie::query();

        // Tùy chọn lọc theo tên phim nếu có từ khóa tìm kiếm
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', '%' . $search . '%');
        }

        // Lấy danh sách phim, phân trang 12 phim mỗi trang
        $movies = $query->latest()->paginate(12);

        return view('client.movies.index', compact('movies'));
    }

    public function show($id, Request $request)
    {
        $movie = Movie::with(['showtimes.cinemaRoom.theater'])->findOrFail($id);

        $theaters = Theater::all();

        // Lấy ngày được chọn (nếu không có thì lấy ngày hôm nay)
        $selectedDate = $request->query('date', now()->format('Y-m-d'));

        // Lấy rạp được chọn (mặc định all)
        $selectedTheaterId = $request->query('theater_id', 'all');

        // Lọc showtimes theo ngày và rạp
        $showtimes = $movie->showtimes()
            ->whereDate('start_time', $selectedDate)
            ->when($selectedTheaterId !== 'all', function ($query) use ($selectedTheaterId) {
                $query->whereHas('cinemaRoom', function ($q) use ($selectedTheaterId) {
                    $q->where('theater_id', $selectedTheaterId);
                });
            })
            ->get();

        // Tạo danh sách các ngày trong tuần (ví dụ 7 ngày từ hôm nay)
        $weekDates = collect();
        for ($i = 0; $i < 7; $i++) {
            $weekDates->push(now()->addDays($i)->format('Y-m-d'));
        }

        // Lấy danh sách phim đang chiếu (ví dụ lấy 8 phim gần đây, hoặc có thể thêm điều kiện phù hợp)
        $nowShowingMovies = Movie::where('release_date', '<=', now())
            ->orderByDesc('release_date')
            ->take(12)
            ->get();

        return view('client.movies.show', compact(
            'movie',
            'theaters',
            'selectedDate',
            'selectedTheaterId',
            'showtimes',
            'weekDates',
            'nowShowingMovies'
        ));
    }
}
