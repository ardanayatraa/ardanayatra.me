<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChordPreset extends Model
{
    protected $fillable = [
        'name',
        'family',
        'type',
        'difficulty',
        'fingers',
        'open_strings',
        'muted_strings',
        'starting_fret',
        'num_frets',
        'num_strings',
    ];

    protected $casts = [
        'fingers' => 'array',
        'open_strings' => 'array',
        'muted_strings' => 'array',
    ];
}
