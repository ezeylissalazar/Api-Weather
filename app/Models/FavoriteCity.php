<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteCity extends Model
{
     protected $fillable = [
        'user_id',
        'city',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
