<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'description',
        'lyrics',
        'cover_type',
        'cover_image',
        'embed_url',
        'is_published',
        'is_for_sale',
        'music_role',
        'project_url',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_for_sale' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function mediaLinks(): HasMany
    {
        return $this->hasMany(MediaLink::class)->orderBy('sort_order');
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true);
    }

    public function scopeByCategory(Builder $query, string $slug): void
    {
        $query->whereHas('category', fn($q) => $q->where('slug', $slug));
    }

    public function getFormattedEmbedUrlAttribute()
    {
        $url = $this->attributes['embed_url'] ?? null;
        
        if (!$url) return null;

        // Convert YouTube watch URL to embed URL
        if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        // Convert YouTube short URL to embed URL
        if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        // If already embed URL or other URL, return as is
        return $url;
    }
}
