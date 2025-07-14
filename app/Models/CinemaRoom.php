<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CinemaRoom extends Model
{
    protected $fillable = [
        'name',
        'total_seats',
        'theater_id',
    ];

    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }

    public function theater()
    {
        return $this->belongsTo(Theater::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}
