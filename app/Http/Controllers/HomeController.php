<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Visitor;
use App\Models\SecretMessage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount(['posts' => fn($q) => $q->published()])->get();
        
        $featuredPosts = Post::with(['category', 'user'])
            ->published()
            ->latest('published_at')
            ->take(6)
            ->get();

        // Get all messages for popup notifications
        $messages = SecretMessage::with('visitor')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($message) {
                $message->created_at_human = $message->created_at->diffForHumans();
                return $message;
            });

        // Check if visitor has introduced themselves
        $hasIntroduced = $request->session()->has('visitor_name');

        return view('home', compact('categories', 'featuredPosts', 'messages', 'hasIntroduced'));
    }

    public function storeVisitor(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Visitor::create([
            'name' => $validated['name'],
            'session_id' => $request->session()->getId(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $request->session()->put('visitor_name', $validated['name']);

        return response()->json(['success' => true]);
    }
}
