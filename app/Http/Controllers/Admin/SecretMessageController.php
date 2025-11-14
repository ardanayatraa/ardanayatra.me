<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SecretMessage;
use Illuminate\Http\Request;

class SecretMessageController extends Controller
{
    public function index()
    {
        $messages = SecretMessage::with('visitor')
            ->latest()
            ->paginate(20);

        return view('admin.messages.index', compact('messages'));
    }

    public function show(SecretMessage $message)
    {
        $message->load('visitor');
        $message->update(['is_read' => true]);
        
        return view('admin.messages.show', compact('message'));
    }

    public function reply(Request $request, SecretMessage $message)
    {
        $validated = $request->validate([
            'reply' => 'required|string',
        ]);

        $message->update($validated);

        return back()->with('success', 'Reply sent successfully.');
    }

    public function destroy(SecretMessage $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Message deleted successfully.');
    }
}
