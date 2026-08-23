<?php

namespace App\Http\Controllers;

use App\Models\MediaAlbum;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MediaController extends Controller
{
    public function index(Request $request): Response
    {
        $query = MediaAlbum::where('status', 'published');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $albums = $query->orderBy('published_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        $albums->getCollection()->transform(function ($album) {
            return [
                'id' => $album->id,
                'title' => $album->title,
                'slug' => $album->slug,
                'description' => $album->description,
                'cover_url' => $album->getFirstMediaUrl('cover_image') ?: '/images/news_placeholder.png',
                'media_items_count' => $album->getMedia('gallery')->count(),
            ];
        });

        return Inertia::render('MediaIndex', [
            'albums' => $albums,
            'filters' => $request->only(['search']),
        ]);
    }

    public function show(MediaAlbum $album): Response
    {
        if ($album->status !== 'published') {
            abort(404);
        }

        $items = $album->getMedia('gallery')->map(fn ($media, $index) => [
            'id' => $media->id,
            'title' => "Photo " . ($index + 1),
            'caption' => null,
            'type' => 'image',
            'date' => $media->created_at ? $media->created_at->format('Y-m-d') : null,
            'url' => $media->getUrl(),
        ])->toArray();

        return Inertia::render('MediaShow', [
            'album' => [
                'id' => $album->id,
                'title' => $album->title,
                'slug' => $album->slug,
                'description' => $album->description,
            ],
            'items' => $items,
        ]);
    }
}
