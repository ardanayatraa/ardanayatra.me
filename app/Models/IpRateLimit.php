<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpRateLimit extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'ip_address',
        'action',
        'count',
        'last_attempt_at',
    ];

    protected $casts = [
        'last_attempt_at' => 'datetime',
    ];
}
