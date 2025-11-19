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

    // Quan hệ: 1 đơn hàng thuộc về 1 người dùng
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ: 1 đơn hàng thuộc về 1 suất chiếu
    public function showtime()
    {
        return $this->belongsTo(Showtime::class);
    }

    // Quan hệ: 1 đơn hàng có nhiều ghế được đặt
    public function orderSeats()
    {
        return $this->hasMany(OrderSeat::class);
    }

    // Lấy danh sách ghế thông qua bảng trung gian
    public function seats()
    {
        return $this->belongsToMany(Seat::class, 'order_seats');
    }

    public function movie()
    {
        return $this->hasOneThrough(Movie::class, Showtime::class, 'id', 'id', 'showtime_id', 'movie_id');
    }
}
