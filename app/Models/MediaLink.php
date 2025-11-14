<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaLink extends Model
{
    protected $fillable = [
        'post_id',
        'platform',
        'url',
        'sort_order',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
