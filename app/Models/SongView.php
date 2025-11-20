<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SongView extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'viewed_at',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];
}
