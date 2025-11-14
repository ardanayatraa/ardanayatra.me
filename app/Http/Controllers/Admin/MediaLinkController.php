<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaLink;
use App\Models\Post;
use Illuminate\Http\Request;

class MediaLinkController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'platform' => 'required|string|max:100',
            'url' => 'required|url|max:500',
            'sort_order' => 'integer',
        ]);

        $validated['post_id'] = $post->id;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        MediaLink::create($validated);

        return back()->with('success', 'Media link added successfully.');
    }

    public function destroy(MediaLink $mediaLink)
    {
        $mediaLink->delete();

        return back()->with('success', 'Media link deleted successfully.');
    }
}
