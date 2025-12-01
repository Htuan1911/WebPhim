<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'showtime_id',
        'total_price',
        'payment_status',
        'payment_method',
        'booking_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function showtime()
    {
        return $this->belongsTo(Showtime::class);
    }

    public function orderSeats()
    {
        return $this->hasMany(OrderSeat::class);
    }

    public function seats()
    {
        return $this->belongsToMany(Seat::class, 'order_seats');
    }

    public function movie()
    {
        return $this->hasOneThrough(Movie::class, Showtime::class, 'id', 'id', 'showtime_id', 'movie_id');
    }
}
