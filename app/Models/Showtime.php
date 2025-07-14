<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
    protected $fillable = [
        'movie_id',
        'theater_id',
        'cinema_room_id',
        'ticket_price',
        'start_time',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function theater()
    {
        return $this->belongsTo(Theater::class);
    }

    public function cinemaRoom()
    {
        return $this->belongsTo(CinemaRoom::class);
    }
}
