<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Bill;
use App\Models\ConstituencyProject;
use App\Models\Event;
use App\Models\MediaAlbum;
use App\Models\News;
use App\Models\Speech;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(): Response
    {
        // Cache homepage database queries for 10 minutes (600 seconds)
        $data = Cache::remember('homepage_data', 600, function () {
            // Impact Stats Calculations
            $billsSponsored = Bill::where('status', 'published')->count();
            $billsPassed = Bill::where('status', 'published')
                ->whereIn('status_legislative', ['Passed House', 'Passed Senate', 'Assented'])
                ->count();
            $projectsCount = ConstituencyProject::where('status', 'published')->count();
            $totalBeneficiaries = ConstituencyProject::where('status', 'published')->sum('beneficiaries_count');

            return [
                'stats' => [
                    'bills_sponsored' => $billsSponsored > 0 ? $billsSponsored : 18,
                    'bills_sponsored_is_demo' => $billsSponsored == 0,
                    'bills_passed' => $billsPassed > 0 ? $billsPassed : 12,
                    'bills_passed_is_demo' => $billsPassed == 0,
                    'projects_count' => $projectsCount > 0 ? $projectsCount : 52,
                    'projects_count_is_demo' => $projectsCount == 0,
                    'beneficiaries' => $totalBeneficiaries > 0 ? $totalBeneficiaries : 125000,
                    'beneficiaries_is_demo' => $totalBeneficiaries == 0,
                ],
                'achievements' => Achievement::with('category')
                    ->where('status', 'published')
                    ->orderBy('published_at', 'desc')
                    ->take(3)
                    ->get()
                    ->map(fn ($achievement) => [
                        'id' => $achievement->id,
                        'title' => $achievement->title,
                        'slug' => $achievement->slug,
                        'summary' => $achievement->summary,
                        'category' => $achievement->category,
                        'published_at' => $achievement->published_at ? $achievement->published_at->format('M d, Y') : null,
                        'image_url' => $achievement->getFirstMediaUrl('featured_image') ?: null,
                    ])
                    ->toArray(),
                'bills' => Bill::where('status', 'published')
                    ->orderBy('published_at', 'desc')
                    ->take(3)
                    ->get(),
                'projects' => ConstituencyProject::with(['category', 'state', 'lga'])
                    ->where('status', 'published')
                    ->orderBy('published_at', 'desc')
                    ->take(3)
                    ->get()
                    ->map(fn ($project) => [
                        'id' => $project->id,
                        'title' => $project->title,
                        'slug' => $project->slug,
                        'category' => $project->category,
                        'state' => $project->state,
                        'lga' => $project->lga,
                        'status_project' => $project->status_project,
                        'image_url' => $project->getFirstMediaUrl('after') ?: ($project->getFirstMediaUrl('gallery') ?: null),
                    ])
                    ->toArray(),
                'news' => News::with('category')
                    ->where('status', 'published')
                    ->orderBy('published_at', 'desc')
                    ->take(3)
                    ->get()
                    ->map(fn ($article) => [
                        'id' => $article->id,
                        'title' => $article->title,
                        'slug' => $article->slug,
                        'summary' => $article->summary,
                        'category' => $article->category,
                        'published_at' => $article->published_at ? $article->published_at->format('M d, Y') : null,
                        'image_url' => $article->getFirstMediaUrl('featured_image') ?: null,
                    ])
                    ->toArray(),
                'heroSlides' => \App\Models\HeroSlide::where('status', 'published')
                    ->orderBy('sort_order', 'asc')
                    ->get()
                    ->map(fn ($slide) => [
                        'id' => $slide->id,
                        'title' => $slide->title,
                        'subtitle' => $slide->subtitle,
                        'badge' => $slide->badge,
                        'link_text' => $slide->link_text ?: 'Explore',
                        'link_url' => $slide->link_url ?: '/achievements',
                        'image_url' => $slide->getFirstMediaUrl('slide_image'),
                        'side_image_url' => $slide->getFirstMediaUrl('side_image'),
                    ])
                    ->toArray(),
                'speeches' => Speech::where('status', 'published')
                    ->orderBy('published_at', 'desc')
                    ->take(3)
                    ->get(),
                'mediaAlbums' => MediaAlbum::where('status', 'published')
                    ->orderBy('published_at', 'desc')
                    ->take(3)
                    ->get()
                    ->map(fn ($album) => [
                        'id' => $album->id,
                        'title' => $album->title,
                        'slug' => $album->slug,
                        'cover_url' => $album->getFirstMediaUrl('cover_image') ?: '/images/news_placeholder.png',
                        'media_items_count' => $album->getMedia('gallery')->count(),
                    ])
                    ->toArray(),
                'events' => Event::where('status', 'published')
                    ->where('starts_at', '>=', now())
                    ->orderBy('starts_at', 'asc')
                    ->take(3)
                    ->get(),
            ];
        });

        $speakerSetting = \App\Models\SiteSetting::where('key', 'speaker_image')->first();
        $speakerImageUrl = ($speakerSetting && $speakerSetting->hasMedia('speaker_image'))
            ? $speakerSetting->getFirstMediaUrl('speaker_image')
            : '/images/speaker_portrait.png';

        $speechSetting = \App\Models\SiteSetting::where('key', 'speaker_welcome_speech')->first();
        $speakerSpeech = $speechSetting ? $speechSetting->value : 'Dedicated to transparent governance, impactful legislation, and empowering citizens across the nation through visionary leadership.';

        return Inertia::render('Welcome', array_merge($data, [
            'speakerImageUrl' => $speakerImageUrl,
            'speakerSpeech' => $speakerSpeech,
        ]));
    }
}
