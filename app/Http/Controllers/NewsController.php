<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with(['category', 'author'])
                    ->published()
                    ->latest('published_at');

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $news = $query->paginate(12);
        $categories = Category::all();

        return view('news.index', compact('news', 'categories'));
    }

    public function show($slug)
    {
        $article = News::with(['category', 'author', 'citations'])
                      ->where('slug', $slug)
                      ->published()
                      ->firstOrFail();

        // Increment views
        $article->increment('views');

        // Related news
        $relatedNews = News::with(['category', 'author'])
                          ->published()
                          ->where('id', '!=', $article->id)
                          ->where('category_id', $article->category_id)
                          ->latest('published_at')
                          ->take(3)
                          ->get();

        return view('news.show', compact('article', 'relatedNews'));
    }
}
