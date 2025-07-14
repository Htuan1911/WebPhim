<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = ['cinema_room_id', 'seat_number'];

    public function cinemaRoom()
    {
        return $this->belongsTo(CinemaRoom::class);
    }
}
