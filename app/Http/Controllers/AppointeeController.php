<?php

namespace App\Http\Controllers;

use App\Models\Appointee;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AppointeeController extends Controller
{
    public function index(Request $request): Response
    {
        $appointees = Appointee::where('status', 'published')
            ->orderBy('sort_order', 'asc')
            ->get()
            ->map(fn ($appointee) => [
                'id' => $appointee->id,
                'name' => $appointee->name,
                'designation' => $appointee->designation,
                'category' => $appointee->category,
                'bio' => $appointee->bio,
                'avatar_url' => $appointee->getFirstMediaUrl('avatar') ?: '/images/speaker_portrait.png',
            ]);

        return Inertia::render('AppointeesIndex', [
            'appointees' => $appointees,
        ]);
    }
}
