<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomTemplateSeat extends Model
{
    use HasFactory;

    protected $fillable = ['room_template_id', 'seat_number', 'type'];

    public function template()
    {
        return $this->belongsTo(RoomTemplate::class, 'room_template_id');
    }
}

