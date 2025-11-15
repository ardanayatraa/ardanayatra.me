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

        $ipAddress = $request->ip();
        
        // Jangan simpan ke database jika nama adalah MDY (admin)
        if (strtoupper($validated['name']) !== 'MDY') {
            // Cek apakah IP sudah pernah berkunjung
            $existingVisitor = Visitor::where('ip_address', $ipAddress)->first();
            
            if ($existingVisitor) {
                // Increment visit count jika IP sama
                $existingVisitor->increment('visit_count');
                $existingVisitor->update([
                    'name' => $validated['name'],
                    'session_id' => $request->session()->getId(),
                    'user_agent' => $request->userAgent(),
                ]);
            } else {
                // Buat visitor baru
                Visitor::create([
                    'name' => $validated['name'],
                    'session_id' => $request->session()->getId(),
                    'ip_address' => $ipAddress,
                    'user_agent' => $request->userAgent(),
                    'visit_count' => 1,
                ]);
            }
        }

        $request->session()->put('visitor_name', $validated['name']);

        return response()->json(['success' => true]);
    }
}
