<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderSeat extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'seat_id',
    ];

    // Quan hệ: ghế thuộc về 1 đơn hàng
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Quan hệ: ghế đặt là 1 ghế cụ thể
    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function combos()
    {
        return $this->belongsToMany(Combo::class)->withPivot('quantity')->withTimestamps();
    }
}
