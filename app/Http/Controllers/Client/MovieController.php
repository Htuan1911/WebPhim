<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Theater;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::query();

        if ($search = $request->get('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($genre = $request->get('genre')) {
            $query->where(function ($q) use ($genre) {
                $q->where('genre', 'like', "%{$genre}%")
                    ->orWhere('genre', 'like', "%\"{$genre}\"%")
                    ->orWhere('genre', 'like', "%|{$genre}|%")
                    ->orWhere('genre', 'like', "%,{$genre},%");
            });
        }

        if ($year = $request->get('year')) {
            $query->whereYear('release_date', $year);
        }

        $movies = $query->latest('release_date')->paginate(20)->withQueryString();

        $nowShowingMovies = Movie::where('status', Movie::STATUS_NOW_SHOWING)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $comingSoonMovies = Movie::where('status', Movie::STATUS_COMING_SOON)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('client.movies.index', compact('movies', 'nowShowingMovies', 'comingSoonMovies'));
    }

    public function show($id, Request $request)
    {
        $movie = Movie::with([
            'showtimes.cinemaRoom.theater.cinemaCategory' 
        ])->findOrFail($id);

        $selectedDate = $request->query('date', now()->format('Y-m-d'));
        $selectedCategoryId = $request->query('category_id', 'all'); 
        $showtimes = $movie->showtimes()
            ->with(['cinemaRoom.theater.cinemaCategory'])
            ->whereDate('start_time', $selectedDate)
            ->when($selectedCategoryId !== 'all', function ($q) use ($selectedCategoryId) {
                $q->whereHas('cinemaRoom.theater', function ($sq) use ($selectedCategoryId) {
                    $sq->where('cinema_category_id', $selectedCategoryId);
                });
            })
            ->orderBy('start_time')
            ->get();

        $groupedShowtimes = $showtimes->groupBy('cinemaRoom.theater_id');

        $theatersQuery = Theater::with('cinemaCategory');
        if ($selectedCategoryId !== 'all') {
            $theatersQuery->where('cinema_category_id', $selectedCategoryId);
        }
        $theaters = $theatersQuery->orderBy('name')->get();

        $weekDates = collect();
        for ($i = 0; $i < 9; $i++) {
            $weekDates->push(now()->addDays($i)->format('Y-m-d'));
        }

        $nowShowingMovies = Movie::where('release_date', '<=', now())
            ->inRandomOrder()
            ->take(12)
            ->get();

        return view('client.movies.show', compact(
            'movie',
            'theaters',
            'selectedDate',
            'selectedCategoryId',     
            'groupedShowtimes',     
            'weekDates',
            'nowShowingMovies'
        ));
    }
}
