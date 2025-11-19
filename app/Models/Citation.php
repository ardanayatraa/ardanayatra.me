<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citation extends Model
{
    use HasFactory;

    protected $fillable = [
        'news_id',
        'author',
        'title',
        'source',
        'year',
        'volume',
        'issue',
        'pages',
        'doi',
        'url',
        'type',
        'order',
    ];

    public function news()
    {
        return $this->belongsTo(News::class);
    }

    // Format citation berdasarkan tipe (APA style)
    public function getFormattedCitationAttribute()
    {
        switch ($this->type) {
            case 'journal':
                return $this->formatJournal();
            case 'book':
                return $this->formatBook();
            case 'website':
                return $this->formatWebsite();
            case 'conference':
                return $this->formatConference();
            default:
                return $this->formatJournal();
        }
    }

    private function formatJournal()
    {
        $citation = "{$this->author} ({$this->year}). {$this->title}. ";
        if ($this->source) {
            $citation .= "<em>{$this->source}</em>";
            if ($this->volume) $citation .= ", {$this->volume}";
            if ($this->issue) $citation .= "({$this->issue})";
            if ($this->pages) $citation .= ", {$this->pages}";
            $citation .= ". ";
        }
        if ($this->doi) $citation .= "https://doi.org/{$this->doi}";
        elseif ($this->url) $citation .= $this->url;
        return $citation;
    }

    private function formatBook()
    {
        $citation = "{$this->author} ({$this->year}). <em>{$this->title}</em>. ";
        if ($this->source) $citation .= "{$this->source}. ";
        if ($this->url) $citation .= $this->url;
        return $citation;
    }

    private function formatWebsite()
    {
        $citation = "{$this->author} ({$this->year}). {$this->title}. ";
        if ($this->source) $citation .= "{$this->source}. ";
        $citation .= "Retrieved from {$this->url}";
        return $citation;
    }

    private function formatConference()
    {
        $citation = "{$this->author} ({$this->year}). {$this->title}. ";
        if ($this->source) $citation .= "In <em>{$this->source}</em>";
        if ($this->pages) $citation .= " (pp. {$this->pages})";
        $citation .= ". ";
        if ($this->url) $citation .= $this->url;
        return $citation;
    }
}
