<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theater extends Model
{
    protected $fillable = [
        'name',
        'cinema_category_id',
        'total_seats',
        'image',
    ];

    public function cinemaCategory()
    {
        return $this->belongsTo(CinemaCategory::class, 'cinema_category_id');
    }

    public function cinemaRooms()
    {
        return $this->hasMany(CinemaRoom::class);
    }

    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }
}
