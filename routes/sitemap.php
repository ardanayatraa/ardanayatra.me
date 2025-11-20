<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;

Route::get('/sitemap.xml', function() {
    $posts = Post::where('is_published', true)->get();
    
    $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
    $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    
    // Homepage
    $sitemap .= '<url>';
    $sitemap .= '<loc>' . url('/') . '</loc>';
    $sitemap .= '<changefreq>daily</changefreq>';
    $sitemap .= '<priority>1.0</priority>';
    $sitemap .= '</url>';
    
    // Posts
    foreach ($posts as $post) {
        $sitemap .= '<url>';
        $sitemap .= '<loc>' . route('posts.show', $post->slug) . '</loc>';
        $sitemap .= '<lastmod>' . $post->updated_at->toAtomString() . '</lastmod>';
        $sitemap .= '<changefreq>monthly</changefreq>';
        $sitemap .= '<priority>0.8</priority>';
        $sitemap .= '</url>';
    }
    
    $sitemap .= '</urlset>';
    
    return response($sitemap, 200)->header('Content-Type', 'application/xml');
});
