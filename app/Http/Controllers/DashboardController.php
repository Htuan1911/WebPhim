<?php

namespace App\Http\Controllers;

use App\Models\Combo;
use App\Models\Movie;
use App\Models\Order;
use App\Models\Theater;
use App\Models\User;


class DashboardController extends Controller
{
    public function index()
    {
        $chartData = [
            'movies'   => Movie::count(),
            'users'    => User::count(),
            'orders'   => Order::count(),
            'theaters' => Theater::count(),
            'combos'   => Combo::count(),
        ];

        return view('admin.dashboard', compact('chartData'));
    }
}
