<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SecretMessage;
use App\Models\Visitor;
use Illuminate\Http\Request;

class AdminSecretMessageController extends Controller
{
    public function index()
    {
        // Group messages by visitor
        $visitors = Visitor::has('secretMessages')
            ->with(['secretMessages' => function($query) {
                $query->latest();
            }])
            ->withCount('secretMessages')
            ->latest()
            ->get();
        
        return view('admin.messages.index', compact('visitors'));
    }

    public function show(SecretMessage $message)
    {
        $message->load('visitor');
        
        // Mark as read
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }
        
        return view('admin.messages.show', compact('message'));
    }

    public function destroy(SecretMessage $message)
    {
        $message->delete();
        
        return back()->with('success', 'Message deleted successfully.');
    }
}
