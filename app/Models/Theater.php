<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theater extends Model
{
    protected $fillable = [
        'name',
        'category',
        'total_seats',
        'image',
    ];

    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }

    public function cinemaRooms()
    {
        // 1 theater có nhiều phòng chiếu (cinema rooms)
        return $this->hasMany(CinemaRoom::class);
    }
}
