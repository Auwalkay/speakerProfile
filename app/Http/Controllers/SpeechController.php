<?php

namespace App\Http\Controllers;

use App\Models\Speech;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SpeechController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Speech::where('status', 'published');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%')
                  ->orWhere('event', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('year')) {
            $query->whereYear('speech_date', $request->year);
        }

        $speeches = $query->orderBy('published_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        // Get years list
        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        $yearExpression = $driver === 'sqlite'
            ? 'strftime("%Y", speech_date) as year'
            : 'EXTRACT(YEAR FROM speech_date) as year';

        $years = Speech::where('status', 'published')
            ->whereNotNull('speech_date')
            ->selectRaw($yearExpression)
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        return Inertia::render('SpeechesIndex', [
            'speeches' => $speeches,
            'years' => !empty($years) ? $years : [date('Y')],
            'filters' => $request->only(['search', 'year']),
        ]);
    }

    public function show(Speech $speech): Response
    {
        if ($speech->status !== 'published') {
            abort(404);
        }

        $pdfUrl = $speech->getFirstMediaUrl('pdf');

        $related = Speech::where('status', 'published')
            ->where('id', '!=', $speech->id)
            ->take(3)
            ->get();

        return Inertia::render('SpeechesShow', [
            'speech' => $speech,
            'pdfUrl' => $pdfUrl,
            'related' => $related,
        ]);
    }
}
