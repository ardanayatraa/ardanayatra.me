<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = auth()->user()->profile ?? auth()->user()->profile()->create([]);
        
        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'bio' => 'nullable|string',
            'avatar' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
        ]);

        auth()->user()->profile()->updateOrCreate(
            ['user_id' => auth()->id()],
            $validated
        );

        return back()->with('success', 'Profile updated successfully.');
    }
}
