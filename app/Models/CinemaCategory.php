<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CinemaCategory extends Model
{
    
    protected $fillable = ['name', 'slug', 'image', 'description', 'priority', 'is_active'];

    public function theaters()
    {
        return $this->hasMany(Theater::class);
    }
}
