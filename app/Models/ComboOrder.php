<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComboOrder extends Model
{
    use HasFactory;

    protected $table = 'combo_orders';

    protected $fillable = [
        'order_id',
        'combo_id',
        'quantity',
        'subtotal',
    ];

    // Mối quan hệ: mỗi combo_order thuộc về một đơn hàng
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Mối quan hệ: mỗi combo_order thuộc về một combo
    public function combo()
    {
        return $this->belongsTo(Combo::class);
    }
}
