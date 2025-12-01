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

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function combo()
    {
        return $this->belongsTo(Combo::class);
    }
}
