<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'artist',
        'audio_file',
        'cover_image',
        'views',
        'markers',
        'lyrics',
        'serial_number',
    ];

    protected $casts = [
        'markers' => 'array',
        'lyrics' => 'array',
    ];

    /**
     * Boot method to auto-generate serial number and slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($song) {
            // Auto-generate serial number
            if (!$song->serial_number) {
                $lastSong = static::orderBy('id', 'desc')->first();
                $nextNumber = $lastSong ? (intval(substr($lastSong->serial_number, -3)) + 1) : 1;
                $song->serial_number = 'IMAY-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            }
            
            // Auto-generate slug from title
            if (!$song->slug) {
                $song->slug = static::generateUniqueSlug($song->title);
            }
        });
        
        static::updating(function ($song) {
            // Update slug if title changed
            if ($song->isDirty('title') && !$song->isDirty('slug')) {
                $song->slug = static::generateUniqueSlug($song->title, $song->id);
            }
        });
    }
    
    /**
     * Generate unique slug from title
     */
    protected static function generateUniqueSlug($title, $ignoreId = null)
    {
        $slug = \Illuminate\Support\Str::slug($title);
        $originalSlug = $slug;
        $count = 1;
        
        while (static::where('slug', $slug)->when($ignoreId, function($query, $id) {
            return $query->where('id', '!=', $id);
        })->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        
        return $slug;
    }

    /**
     * Get audio URL from R2 (with temporary signed URL)
     */
    public function getAudioUrlAttribute()
    {
        if ($this->audio_file) {
            // Use temporary signed URL (valid for 1 hour)
            return Storage::disk('r2')->temporaryUrl(
                $this->audio_file,
                now()->addHours(1)
            );
        }
        
        return null;
    }

    /**
     * Get cover image URL from R2 (with temporary signed URL)
     */
    public function getCoverUrlAttribute()
    {
        if ($this->cover_image) {
            // Use temporary signed URL (valid for 1 hour)
            return Storage::disk('r2')->temporaryUrl(
                $this->cover_image,
                now()->addHours(1)
            );
        }
        
        return null;
    }
}
