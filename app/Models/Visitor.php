<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'name',
        'session_id',
        'ip_address',
        'user_agent',
        'visit_count',
    ];

    public function secretMessages()
    {
        return $this->hasMany(SecretMessage::class);
    }
}
