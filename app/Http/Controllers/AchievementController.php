<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\AchievementCategory;
use App\Models\State;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AchievementController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Achievement::with(['category', 'state', 'lga'])
            ->where('status', 'published');

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('summary', 'like', '%' . $request->search . '%');
            });
        }

        // Category Filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // State Filter
        if ($request->filled('state')) {
            $query->where('state_id', $request->state);
        }

        // Year Filter
        if ($request->filled('year')) {
            $query->whereYear('achievement_date', $request->year);
        }

        // Paginated result
        $achievements = $query->orderBy('published_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        // Featured achievements
        $featured = Achievement::with('category')
            ->where('status', 'published')
            ->where('featured', true)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        $categories = AchievementCategory::select('id', 'name')->get();
        $states = State::select('id', 'name')->get();

        // Get years list where achievements exist
        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        $yearExpression = $driver === 'sqlite'
            ? 'strftime("%Y", achievement_date) as year'
            : 'EXTRACT(YEAR FROM achievement_date) as year';

        $years = Achievement::where('status', 'published')
            ->whereNotNull('achievement_date')
            ->selectRaw($yearExpression)
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        // Handle fallback years list if empty
        if (empty($years)) {
            $years = [date('Y')];
        }

        return Inertia::render('Achievements', [
            'achievements' => $achievements,
            'featured' => $featured,
            'categories' => $categories,
            'states' => $states,
            'years' => $years,
            'filters' => $request->only(['search', 'category', 'state', 'year']),
        ]);
    }

    public function show(Achievement $achievement): Response
    {
        if ($achievement->status !== 'published') {
            abort(404);
        }

        $achievement->load(['category', 'state', 'lga']);

        // Load media files from Spatie Collections
        $media = [
            'featured_image' => $achievement->getFirstMediaUrl('featured_image'),
            'gallery' => $achievement->getMedia('gallery')->map(fn ($m) => $m->getUrl())->toArray(),
            'documents' => $achievement->getMedia('documents')->map(fn ($m) => [
                'name' => $m->name,
                'url' => $m->getUrl(),
            ])->toArray(),
            'videos' => $achievement->getMedia('videos')->map(fn ($m) => $m->getUrl())->toArray(),
        ];

        // Related achievements
        $related = Achievement::with('category')
            ->where('status', 'published')
            ->where('category_id', $achievement->category_id)
            ->where('id', '!=', $achievement->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return Inertia::render('AchievementShow', [
            'achievement' => $achievement,
            'media' => $media,
            'related' => $related,
        ]);
    }
}
