<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\News;
use App\Models\Song;

Route::get('/sitemap.xml', function() {
    $posts = Post::where('is_published', true)->get();
    $news = News::where('is_published', true)->get();
    $songs = Song::where('is_published', true)->get();
    
    $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
    $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    
    // Homepage
    $sitemap .= '<url>';
    $sitemap .= '<loc>' . url('/') . '</loc>';
    $sitemap .= '<changefreq>daily</changefreq>';
    $sitemap .= '<priority>1.0</priority>';
    $sitemap .= '</url>';
    
    // Static pages
    $staticPages = [
        '/fretbubble' => '0.8',
        '/learningchord' => '0.8',
        '/invoicego' => '0.8',
        '/metronome' => '0.8',
        '/fastread' => '0.9',
        '/song' => '0.9',
    ];
    
    foreach ($staticPages as $page => $priority) {
        $sitemap .= '<url>';
        $sitemap .= '<loc>' . url($page) . '</loc>';
        $sitemap .= '<changefreq>weekly</changefreq>';
        $sitemap .= '<priority>' . $priority . '</priority>';
        $sitemap .= '</url>';
    }
    
    // Posts
    foreach ($posts as $post) {
        $sitemap .= '<url>';
        $sitemap .= '<loc>' . route('posts.show', $post->slug) . '</loc>';
        $sitemap .= '<lastmod>' . $post->updated_at->toAtomString() . '</lastmod>';
        $sitemap .= '<changefreq>monthly</changefreq>';
        $sitemap .= '<priority>0.7</priority>';
        $sitemap .= '</url>';
    }
    
    // News
    foreach ($news as $item) {
        $sitemap .= '<url>';
        $sitemap .= '<loc>' . route('news.show', $item->slug) . '</loc>';
        $sitemap .= '<lastmod>' . $item->updated_at->toAtomString() . '</lastmod>';
        $sitemap .= '<changefreq>monthly</changefreq>';
        $sitemap .= '<priority>0.7</priority>';
        $sitemap .= '</url>';
    }
    
    // Songs
    foreach ($songs as $song) {
        $sitemap .= '<url>';
        $sitemap .= '<loc>' . route('song.show', $song->slug) . '</loc>';
        $sitemap .= '<lastmod>' . $song->updated_at->toAtomString() . '</lastmod>';
        $sitemap .= '<changefreq>monthly</changefreq>';
        $sitemap .= '<priority>0.8</priority>';
        $sitemap .= '</url>';
    }
    
    $sitemap .= '</urlset>';
    
    return response($sitemap, 200)->header('Content-Type', 'application/xml');
});
