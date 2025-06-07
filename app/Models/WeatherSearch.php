<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherSearch extends Model
{
    protected $fillable = [
        'user_id',
        'city',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
