<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    const STATUS_NOW_SHOWING = 'now_showing';
    const STATUS_COMING_SOON = 'coming_soon';
    const STATUS_ENDED = 'ended';

    protected $fillable = [
        'title',
        'description',
        'genre',
        'duration',
        'poster',
        'release_date',
        'status',
    ];

    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }
}
