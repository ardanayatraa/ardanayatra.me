<?php

namespace App\Http\Controllers;

use App\Models\IpRateLimit;
use App\Models\SecretMessage;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;

class SecretMessageController extends Controller
{
    public function create()
    {
        return view('messages.create');
    }

    public function store(Request $request)
    {
        // Skip visitor check if user is authenticated (admin)
        if (!auth()->check()) {
            // Get visitor from session
            $visitor = Visitor::where('session_id', $request->session()->getId())->first();
            
            if (!$visitor) {
                return back()->withErrors(['message' => 'Please refresh the page and introduce yourself first.']);
            }

            // Check daily message limit (5 messages per day per visitor)
            $todayMessagesCount = SecretMessage::where('visitor_id', $visitor->id)
                ->whereDate('created_at', today())
                ->count();

            if ($todayMessagesCount >= 5) {
                return back()->withErrors(['message' => 'You have reached the daily limit of 5 messages. Please try again tomorrow.']);
            }
        } else {
            $visitor = null;
            $todayMessagesCount = 0;
        }

        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Get admin user (first user or specific admin)
        $admin = User::first();
        
        if (!$admin) {
            return back()->withErrors(['message' => 'No admin user found. Please contact the administrator.']);
        }
        
        $validated['user_id'] = $admin->id;
        
        if ($visitor) {
            $validated['visitor_id'] = $visitor->id;
        }

        SecretMessage::create($validated);

        if (auth()->check()) {
            return redirect()->route('home')->with('success', 'Message sent successfully!');
        }

        $remaining = 5 - $todayMessagesCount - 1;
        $successMessage = $remaining > 0 
            ? "Message sent successfully! You have {$remaining} messages left today."
            : "Message sent successfully! You have reached your daily limit.";

        return redirect()->route('home')->with('success', $successMessage);
    }
}
