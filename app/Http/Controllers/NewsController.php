<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    public function index(Request $request): Response
    {
        $query = News::with('category')->where('status', 'published');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('summary', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $featured = News::with('category')
            ->where('status', 'published')
            ->where('featured', true)
            ->first();

        $news = $query->orderBy('published_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        $categories = NewsCategory::all();

        return Inertia::render('NewsIndex', [
            'news' => $news,
            'featured' => $featured,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category']),
        ]);
    }

    public function show(News $article): Response
    {
        if ($article->status !== 'published') {
            abort(404);
        }

        $article->load('category');

        $related = News::where('status', 'published')
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->take(3)
            ->get();

        return Inertia::render('NewsShow', [
            'article' => $article,
            'featuredImageUrl' => $article->getFirstMediaUrl('featured_image'),
            'related' => $related,
        ]);
    }
}
