<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageReport extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'message_id',
        'ip_address',
        'reason',
        'reported_at',
    ];

    protected $casts = [
        'reported_at' => 'datetime',
    ];

    public function message(): BelongsTo
    {
        return $this->belongsTo(SecretMessage::class, 'message_id');
    }
}
