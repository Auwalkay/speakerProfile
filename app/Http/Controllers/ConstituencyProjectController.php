<?php

namespace App\Http\Controllers;

use App\Models\ConstituencyProject;
use App\Models\ProjectCategory;
use App\Models\State;
use App\Models\Lga;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ConstituencyProjectController extends Controller
{
    public function index(Request $request): Response
    {
        $query = ConstituencyProject::with(['category', 'state', 'lga'])
            ->where('status', 'published');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('title', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('state')) {
            $query->where('state_id', $request->state);
        }

        if ($request->filled('lga')) {
            $query->where('lga_id', $request->lga);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status_project')) {
            $query->where('status_project', $request->status_project);
        }

        if ($request->filled('year')) {
            $query->whereYear('start_date', $request->year);
        }

        $projects = $query->orderBy('published_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        $states = State::select('id', 'name')->get();
        $lgas = $request->filled('state') 
            ? Lga::where('state_id', $request->state)->select('id', 'name')->get()
            : collect();
        $categories = ProjectCategory::select('id', 'name')->get();

        // Unique years list
        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        $yearExpression = $driver === 'sqlite'
            ? 'strftime("%Y", start_date) as year'
            : 'EXTRACT(YEAR FROM start_date) as year';

        $years = ConstituencyProject::where('status', 'published')
            ->whereNotNull('start_date')
            ->selectRaw($yearExpression)
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        return Inertia::render('ProjectsIndex', [
            'projects' => $projects,
            'states' => $states,
            'lgas' => $lgas,
            'categories' => $categories,
            'years' => !empty($years) ? $years : [date('Y')],
            'projectStatuses' => ['Planned', 'Ongoing', 'Completed', 'Suspended', 'Cancelled'],
            'filters' => $request->only(['search', 'state', 'lga', 'category', 'status_project', 'year']),
        ]);
    }

    public function show(ConstituencyProject $project): Response
    {
        if ($project->status !== 'published') {
            abort(404);
        }

        $project->load(['category', 'state', 'lga']);

        // Load media files from Spatie Collections
        $media = [
            'before' => $project->getFirstMediaUrl('before'),
            'during' => $project->getFirstMediaUrl('during'),
            'after' => $project->getFirstMediaUrl('after'),
            'gallery' => $project->getMedia('gallery')->map(fn ($m) => $m->getUrl())->toArray(),
            'documents' => $project->getMedia('documents')->map(fn ($m) => [
                'name' => $m->name,
                'url' => $m->getUrl(),
            ])->toArray(),
            'videos' => $project->getMedia('videos')->map(fn ($m) => $m->getUrl())->toArray(),
        ];

        // Related projects in the same category
        $related = ConstituencyProject::with(['category', 'state', 'lga'])
            ->where('status', 'published')
            ->where('category_id', $project->category_id)
            ->where('id', '!=', $project->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        // Reusable Map integration parameters
        $mapConfig = [
            'provider' => env('MAP_PROVIDER', 'openstreetmap'), // google, mapbox, openstreetmap
            'api_key' => env('MAP_API_KEY', ''),
            'latitude' => $project->latitude ?? '9.0820', // Default Nigeria latitude
            'longitude' => $project->longitude ?? '8.6753',
            'zoom' => 12,
        ];

        return Inertia::render('ProjectsShow', [
            'project' => $project,
            'media' => $media,
            'related' => $related,
            'mapConfig' => $mapConfig,
        ]);
    }
}
