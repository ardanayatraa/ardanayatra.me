<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function index()
    {
        // Track unique visitor
        $this->trackUniqueVisitor();
        
        $songs = Song::latest()->paginate(12);
        $totalViews = Song::sum('views');
        
        return view('song.index', compact('songs', 'totalViews'));
    }
    
    public function show($slug)
    {
        $song = Song::where('slug', $slug)->firstOrFail();
        $totalViews = Song::sum('views');
        
        // Track song view
        $song->increment('views');
        
        return view('song.show', compact('song', 'totalViews'));
    }
    
    private function trackUniqueVisitor()
    {
        $ipAddress = request()->ip();
        $userAgent = request()->userAgent();
        $today = now()->startOfDay();
        
        // Check if this IP has visited today
        $hasVisitedToday = \App\Models\SongView::where('ip_address', $ipAddress)
            ->where('viewed_at', '>=', $today)
            ->exists();
        
        if (!$hasVisitedToday) {
            // Record new unique visit
            \App\Models\SongView::create([
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'viewed_at' => now(),
            ]);
            
            // Increment total views count
            Song::query()->increment('views');
        }
    }
}
