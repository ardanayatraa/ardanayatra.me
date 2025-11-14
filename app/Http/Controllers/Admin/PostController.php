<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['category', 'user']);

        // Search by title or description
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $posts = $query->latest()->paginate(20)->withQueryString();
        $categories = Category::all();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'lyrics' => 'nullable|string',
            'cover_type' => 'required|in:image,embed,upload',
            'cover_image' => 'nullable|string|max:500',
            'cover_upload' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'embed_url' => 'nullable|string|max:500',
            'is_published' => 'boolean',
            'is_for_sale' => 'boolean',
            'music_role' => 'nullable|string|in:arranger,songwriter,both',
            'project_url' => 'nullable|url|max:500',
        ]);

        // Handle file upload
        if ($validated['cover_type'] === 'upload') {
            if ($request->hasFile('cover_upload')) {
                $file = $request->file('cover_upload');
                $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/covers'), $filename);
                $validated['cover_image'] = '/uploads/covers/' . $filename;
            }
            $validated['cover_type'] = 'image'; // Store as image type
        }

        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);
        
        if ($request->boolean('is_published')) {
            $validated['published_at'] = now();
        }

        $post = Post::create($validated);

        return redirect()->route('admin.posts.edit', $post)
            ->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $post->load('mediaLinks');
        
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'lyrics' => 'nullable|string',
            'cover_type' => 'required|in:image,embed,upload',
            'cover_image' => 'nullable|string|max:500',
            'cover_upload' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'embed_url' => 'nullable|string|max:500',
            'is_published' => 'boolean',
            'is_for_sale' => 'boolean',
            'music_role' => 'nullable|string|in:arranger,songwriter,both',
            'project_url' => 'nullable|url|max:500',
        ]);

        // Handle file upload
        if ($validated['cover_type'] === 'upload') {
            if ($request->hasFile('cover_upload')) {
                // Delete old uploaded file if exists
                if ($post->cover_image && str_starts_with($post->cover_image, '/uploads/covers/')) {
                    $oldFile = public_path($post->cover_image);
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
                
                $file = $request->file('cover_upload');
                $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/covers'), $filename);
                $validated['cover_image'] = '/uploads/covers/' . $filename;
            }
            $validated['cover_type'] = 'image'; // Store as image type
        }

        $validated['slug'] = Str::slug($validated['title']);
        
        if ($request->boolean('is_published') && !$post->is_published) {
            $validated['published_at'] = now();
        } elseif (!$request->boolean('is_published')) {
            $validated['published_at'] = null;
        }

        $post->update($validated);

        return redirect()->route('admin.posts.edit', $post)
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post deleted successfully.');
    }
}
