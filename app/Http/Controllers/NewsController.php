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

        $featuredData = null;
        if ($featured) {
            $mediaUrl = $featured->getFirstMediaUrl('featured_image');
            if (!$mediaUrl && !empty($featured->featured_image)) {
                $mediaUrl = str_starts_with($featured->featured_image, 'http') || str_starts_with($featured->featured_image, '/')
                    ? $featured->featured_image
                    : asset('storage/' . $featured->featured_image);
            }
            $featuredData = [
                'id' => $featured->id,
                'title' => $featured->title,
                'slug' => $featured->slug,
                'summary' => $featured->summary,
                'excerpt' => $featured->excerpt,
                'author' => $featured->author,
                'published_at' => $featured->published_at ? $featured->published_at->toISOString() : null,
                'category' => $featured->category,
                'image_url' => $mediaUrl ?: null,
            ];
        }

        $news = $query->orderBy('published_at', 'desc')
            ->paginate(12)
            ->through(function ($article) {
                $mediaUrl = $article->getFirstMediaUrl('featured_image');
                if (!$mediaUrl && !empty($article->featured_image)) {
                    $mediaUrl = str_starts_with($article->featured_image, 'http') || str_starts_with($article->featured_image, '/')
                        ? $article->featured_image
                        : asset('storage/' . $article->featured_image);
                }
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'summary' => $article->summary,
                    'excerpt' => $article->excerpt,
                    'author' => $article->author,
                    'published_at' => $article->published_at ? $article->published_at->toISOString() : null,
                    'category' => $article->category,
                    'image_url' => $mediaUrl ?: null,
                ];
            })
            ->withQueryString();

        $categories = NewsCategory::all();

        return Inertia::render('NewsIndex', [
            'news' => $news,
            'featured' => $featuredData,
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

        $mediaUrl = $article->getFirstMediaUrl('featured_image');
        if (!$mediaUrl && !empty($article->featured_image)) {
            $mediaUrl = str_starts_with($article->featured_image, 'http') || str_starts_with($article->featured_image, '/')
                ? $article->featured_image
                : asset('storage/' . $article->featured_image);
        }

        $related = News::where('status', 'published')
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->take(3)
            ->get();

        return Inertia::render('NewsShow', [
            'article' => $article,
            'featuredImageUrl' => $mediaUrl ?: null,
            'related' => $related,
        ]);
    }
}
