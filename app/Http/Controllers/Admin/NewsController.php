<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Category;
use App\Models\Citation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with(['category', 'author'])
                   ->latest()
                   ->paginate(20);

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:draft,published',
        ]);

        $validated['author_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        if ($validated['status'] === 'published' && !$request->has('published_at')) {
            $validated['published_at'] = now();
        }

        $news = News::create($validated);

        // Handle citations
        if ($request->has('citations')) {
            foreach ($request->citations as $index => $citationData) {
                if (!empty($citationData['author']) && !empty($citationData['title'])) {
                    $news->citations()->create([
                        'author' => $citationData['author'],
                        'title' => $citationData['title'],
                        'source' => $citationData['source'] ?? null,
                        'year' => $citationData['year'] ?? null,
                        'volume' => $citationData['volume'] ?? null,
                        'issue' => $citationData['issue'] ?? null,
                        'pages' => $citationData['pages'] ?? null,
                        'doi' => $citationData['doi'] ?? null,
                        'url' => $citationData['url'] ?? null,
                        'type' => $citationData['type'] ?? 'journal',
                        'order' => $index,
                    ]);
                }
            }
        }

        return redirect()->route('admin.news.index')
                        ->with('success', 'Artikel berhasil dibuat!');
    }

    public function edit(News $news)
    {
        $news->load('citations');
        $categories = Category::all();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:draft,published',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        if ($validated['status'] === 'published' && !$news->published_at) {
            $validated['published_at'] = now();
        }

        $news->update($validated);

        // Handle citations
        if ($request->has('citations')) {
            // Delete existing citations
            $news->citations()->delete();
            
            // Create new citations
            foreach ($request->citations as $index => $citationData) {
                if (!empty($citationData['author']) && !empty($citationData['title'])) {
                    $news->citations()->create([
                        'author' => $citationData['author'],
                        'title' => $citationData['title'],
                        'source' => $citationData['source'] ?? null,
                        'year' => $citationData['year'] ?? null,
                        'volume' => $citationData['volume'] ?? null,
                        'issue' => $citationData['issue'] ?? null,
                        'pages' => $citationData['pages'] ?? null,
                        'doi' => $citationData['doi'] ?? null,
                        'url' => $citationData['url'] ?? null,
                        'type' => $citationData['type'] ?? 'journal',
                        'order' => $index,
                    ]);
                }
            }
        }

        return redirect()->route('admin.news.index')
                        ->with('success', 'Artikel berhasil diupdate!');
    }

    public function destroy(News $news)
    {
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
                        ->with('success', 'Artikel berhasil dihapus!');
    }
}
