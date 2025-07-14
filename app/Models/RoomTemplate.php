<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomTemplate extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'rows', 'columns'];

    public function seats()
    {
        return $this->hasMany(RoomTemplateSeat::class);
    }
}
