<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Post;
use App\Models\Showtime;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $nowShowingMovies = Movie::where('status', Movie::STATUS_NOW_SHOWING)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $comingSoonMovies = Movie::where('status', Movie::STATUS_COMING_SOON)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $upcomingShowtimes = Showtime::where('start_time', '>=', now())
            ->orderBy('start_time', 'asc')
            ->take(5)
            ->get();
            
        $posts = Post::latest()->take(10)->get();

        return view('client.home', compact('nowShowingMovies', 'comingSoonMovies', 'upcomingShowtimes', 'posts'));
    }
}
