<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\SecretMessage;
use App\Models\LoginLog;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::published()->count(),
            'draft_posts' => Post::where('is_published', false)->count(),
            'unread_messages' => SecretMessage::where('is_read', false)->count(),
        ];

        $recentPosts = Post::with('category')->latest()->take(5)->get();
        $recentMessages = SecretMessage::latest()->take(5)->get();
        $recentLogins = LoginLog::with('user')->latest('logged_in_at')->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'recentMessages', 'recentLogins'));
    }
}
