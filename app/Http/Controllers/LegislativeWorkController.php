<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Motion;
use App\Models\News;
use App\Models\Speech;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LegislativeWorkController extends Controller
{
    public function index(): Response
    {
        $recentBills = Bill::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        $recentMotions = Motion::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return Inertia::render('LegislativeWorkIndex', [
            'recentBills' => $recentBills,
            'recentMotions' => $recentMotions,
        ]);
    }

    public function bills(Request $request): Response
    {
        $query = Bill::where('status', 'published');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('bill_number', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status_legislative', $request->status);
        }

        if ($request->filled('year')) {
            $query->whereYear('date_introduced', $request->year);
        }

        $bills = $query->orderBy('published_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        // Get unique years
        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        $yearExpression = $driver === 'sqlite'
            ? 'strftime("%Y", date_introduced) as year'
            : 'EXTRACT(YEAR FROM date_introduced) as year';

        $years = Bill::where('status', 'published')
            ->whereNotNull('date_introduced')
            ->selectRaw($yearExpression)
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        // Unique categories
        $categories = Bill::where('status', 'published')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->toArray();

        // Legislative statuses
        $statuses = ['First Reading', 'Second Reading', 'Committee Stage', 'Report Stage', 'Third Reading', 'Passed House', 'Passed Senate', 'Assented', 'Vetoed'];

        return Inertia::render('LegislativeWorkBills', [
            'bills' => $bills,
            'years' => !empty($years) ? $years : [date('Y')],
            'categories' => $categories,
            'statuses' => $statuses,
            'filters' => $request->only(['search', 'category', 'status', 'year']),
        ]);
    }

    public function motions(Request $request): Response
    {
        $query = Motion::where('status', 'published');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('sponsor', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }

        $motions = $query->orderBy('published_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        // Get unique years
        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        $yearExpression = $driver === 'sqlite'
            ? 'strftime("%Y", date) as year'
            : 'EXTRACT(YEAR FROM date) as year';

        $years = Motion::where('status', 'published')
            ->whereNotNull('date')
            ->selectRaw($yearExpression)
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        return Inertia::render('LegislativeWorkMotions', [
            'motions' => $motions,
            'years' => !empty($years) ? $years : [date('Y')],
            'filters' => $request->only(['search', 'year']),
        ]);
    }

    public function show($slug): Response
    {
        // Try to find a Bill first
        $bill = Bill::where('slug', $slug)->first();
        if ($bill) {
            if ($bill->status !== 'published') {
                abort(404);
            }
            return $this->renderDetail('bill', $bill);
        }

        // Try to find a Motion
        $motion = Motion::where('slug', $slug)->first();
        if ($motion) {
            if ($motion->status !== 'published') {
                abort(404);
            }
            return $this->renderDetail('motion', $motion);
        }

        abort(404);
    }

    protected function renderDetail($type, $record): Response
    {
        // Retrieve media documents
        $documents = $record->getMedia('documents')->map(fn ($m) => [
            'name' => $m->name,
            'url' => $m->getUrl(),
        ])->toArray();

        // Get related news and speeches based on title matching keywords or general highlights
        $relatedNews = News::where('status', 'published')
            ->where(function ($q) use ($record) {
                $q->where('title', 'like', '%' . substr($record->title, 0, 15) . '%')
                  ->orWhere('summary', 'like', '%' . substr($record->title, 0, 15) . '%');
            })
            ->take(3)
            ->get();

        $relatedSpeeches = Speech::where('status', 'published')
            ->where('title', 'like', '%' . substr($record->title, 0, 15) . '%')
            ->take(3)
            ->get();

        return Inertia::render('LegislativeWorkShow', [
            'type' => $type,
            'record' => $record,
            'documents' => $documents,
            'relatedNews' => $relatedNews,
            'relatedSpeeches' => $relatedSpeeches,
        ]);
    }
}
