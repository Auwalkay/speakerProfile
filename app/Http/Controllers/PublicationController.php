<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PublicationController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Publication::where('status', 'published');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('summary', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('year')) {
            $query->whereYear('publication_date', $request->year);
        }

        $publications = $query->orderBy('published_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        $categories = Publication::where('status', 'published')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->toArray();

        // Get years list
        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        $yearExpression = $driver === 'sqlite'
            ? 'strftime("%Y", publication_date) as year'
            : 'EXTRACT(YEAR FROM publication_date) as year';

        $years = Publication::where('status', 'published')
            ->whereNotNull('publication_date')
            ->selectRaw($yearExpression)
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        return Inertia::render('PublicationsIndex', [
            'publications' => $publications,
            'categories' => $categories,
            'years' => !empty($years) ? $years : [date('Y')],
            'filters' => $request->only(['search', 'category', 'year']),
        ]);
    }

    public function show(Publication $publication): Response
    {
        if ($publication->status !== 'published') {
            abort(404);
        }

        $pdfUrl = $publication->getFirstMediaUrl('pdf');
        $coverUrl = $publication->getFirstMediaUrl('cover');

        $related = Publication::where('status', 'published')
            ->where('category', $publication->category)
            ->where('id', '!=', $publication->id)
            ->take(3)
            ->get();

        return Inertia::render('PublicationsShow', [
            'publication' => $publication,
            'pdfUrl' => $pdfUrl,
            'coverUrl' => $coverUrl,
            'related' => $related,
        ]);
    }
}
