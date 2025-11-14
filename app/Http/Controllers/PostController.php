<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['category', 'user'])
            ->published()
            ->latest('published_at')
            ->paginate(12);

        return view('posts.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = Post::with(['category', 'mediaLinks', 'user.profile'])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        return view('posts.show', compact('post'));
    }

    public function category(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $posts = Post::with(['category', 'user'])
            ->byCategory($slug)
            ->published()
            ->latest('published_at')
            ->paginate(12);

        return view('posts.category', compact('posts', 'category'));
    }
}
