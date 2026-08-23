<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Bill;
use App\Models\ConstituencyProject;
use App\Models\Event;
use App\Models\MediaItem;
use App\Models\Motion;
use App\Models\News;
use App\Models\Publication;
use App\Models\Speech;
use App\Models\ContactMessage;
use App\Models\State;
use App\Models\Lga;
use App\Models\AchievementCategory;
use App\Models\ProjectCategory;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PublicPortalController extends Controller
{
    public function home(): Response
    {
        $achievements = Achievement::with('category')
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        $news = News::with('category')
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return Inertia::render('Welcome', [
            'achievements' => $achievements,
            'news' => $news,
        ]);
    }

    public function about(): Response
    {
        return Inertia::render('About');
    }

    public function achievements(Request $request): Response
    {
        $query = Achievement::with('category')->where('status', 'published');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $achievements = $query->orderBy('published_at', 'desc')->paginate(12)->withQueryString();
        $categories = AchievementCategory::select('id', 'name')->get();

        return Inertia::render('Achievements', [
            'achievements' => $achievements,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category']),
        ]);
    }

    public function legislativeWork(Request $request): Response
    {
        $type = $request->input('type', 'bills');

        if ($type === 'motions') {
            $query = Motion::where('status', 'published');
            if ($request->filled('search')) {
                $query->where('title', 'like', '%' . $request->search . '%');
            }
            $items = $query->orderBy('published_at', 'desc')->paginate(12)->withQueryString();
        } else {
            $query = Bill::where('status', 'published');
            if ($request->filled('search')) {
                $query->where('title', 'like', '%' . $request->search . '%');
            }
            $items = $query->orderBy('published_at', 'desc')->paginate(12)->withQueryString();
        }

        return Inertia::render('LegislativeWork', [
            'items' => $items,
            'filters' => $request->only(['search', 'type']),
        ]);
    }

    public function projects(Request $request): Response
    {
        $query = ConstituencyProject::with(['category', 'state', 'lga'])->where('status', 'published');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('state')) {
            $query->where('state_id', $request->state);
        }

        $projects = $query->orderBy('published_at', 'desc')->paginate(12)->withQueryString();
        
        $states = State::select('id', 'name')->get();
        $categories = ProjectCategory::select('id', 'name')->get();

        return Inertia::render('Projects', [
            'projects' => $projects,
            'states' => $states,
            'categories' => $categories,
            'filters' => $request->only(['search', 'state']),
        ]);
    }

    public function news(Request $request): Response
    {
        $query = News::with('category')->where('status', 'published');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $news = $query->orderBy('published_at', 'desc')->paginate(12)->withQueryString();

        return Inertia::render('News', [
            'news' => $news,
            'filters' => $request->only(['search']),
        ]);
    }

    public function speeches(Request $request): Response
    {
        $query = Speech::where('status', 'published');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $speeches = $query->orderBy('published_at', 'desc')->paginate(12)->withQueryString();

        return Inertia::render('Speeches', [
            'speeches' => $speeches,
            'filters' => $request->only(['search']),
        ]);
    }

    public function media(Request $request): Response
    {
        $query = MediaItem::with('album')->where('status', 'published');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $mediaItems = $query->orderBy('published_at', 'desc')->paginate(12)->withQueryString();

        return Inertia::render('Media', [
            'media' => $mediaItems,
            'filters' => $request->only(['search']),
        ]);
    }

    public function publications(Request $request): Response
    {
        $query = Publication::where('status', 'published');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $publications = $query->orderBy('published_at', 'desc')->paginate(12)->withQueryString();

        return Inertia::render('Publications', [
            'publications' => $publications,
            'filters' => $request->only(['search']),
        ]);
    }

    public function events(Request $request): Response
    {
        $query = Event::where('status', 'published');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $events = $query->orderBy('published_at', 'desc')->paginate(12)->withQueryString();

        return Inertia::render('Events', [
            'events' => $events,
            'filters' => $request->only(['search']),
        ]);
    }

    public function contact(): Response
    {
        return Inertia::render('Contact');
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', 'Thank you. Your message has been received by the Office.');
    }
}
