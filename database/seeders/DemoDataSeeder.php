<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\AchievementCategory;
use App\Models\Bill;
use App\Models\ConstituencyProject;
use App\Models\Lga;
use App\Models\MediaAlbum;
use App\Models\MediaItem;
use App\Models\Motion;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\ProjectCategory;
use App\Models\Publication;
use App\Models\Speech;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. News Categories & News
        $newsCats = ['Press Release', 'Legislative Updates', 'Constituency News', 'Statements'];
        foreach ($newsCats as $name) {
            $cat = NewsCategory::firstOrCreate(['name' => $name], ['slug' => Str::slug($name)]);
            
            for ($i = 1; $i <= 3; $i++) {
                News::create([
                    'title' => "{$name} Release: Development Milestone {$i}",
                    'slug' => Str::slug("{$name} Release Development Milestone {$i} " . rand(1, 99)),
                    'category_id' => $cat->id,
                    'summary' => "Official summary outline detailing the impact of news release {$i} on national agendas.",
                    'excerpt' => "Short excerpt outlining news release {$i}.",
                    'content' => "<p>This is the official details description body of {$name} release {$i}. Real data values covering legislative excellence and transparency parameters.</p>",
                    'author' => 'Press Secretary',
                    'status' => 'published',
                    'featured' => $i === 1,
                    'published_at' => now()->subDays($i),
                ]);
            }
        }

        // 2. Achievement Categories & Achievements
        $achCats = ['Infrastructure Development', 'Capacity Building', 'Legislative Oversight', 'Community Health'];
        $state = State::first();
        $lga = $state ? Lga::where('state_id', $state->id)->first() : null;

        foreach ($achCats as $name) {
            $cat = AchievementCategory::firstOrCreate(['name' => $name], ['slug' => Str::slug($name)]);
            
            for ($i = 1; $i <= 2; $i++) {
                Achievement::create([
                    'title' => "Speaker Initiative: {$name} Program {$i}",
                    'slug' => Str::slug("speaker-initiative-{$name}-program-{$i}-" . rand(1, 99)),
                    'category_id' => $cat->id,
                    'summary' => "Summary description outline of target goals achieved during program {$i}.",
                    'content' => "<p>Details text of achievement {$name} showing progress markers and structural changes.</p>",
                    'achievement_date' => now()->subMonths($i),
                    'state_id' => $state?->id,
                    'lga_id' => $lga?->id,
                    'location' => 'Constituency Head Office',
                    'impact_summary' => 'Direct empowerment metrics recorded.',
                    'status' => 'published',
                    'featured' => $i === 1,
                    'published_at' => now(),
                ]);
            }
        }

        // 3. Project Categories & Projects
        $projCats = ['Power & Energy', 'Clean Water', 'Rural Roads', 'Education Infrastructure'];
        foreach ($projCats as $name) {
            $cat = ProjectCategory::firstOrCreate(['name' => $name], ['slug' => Str::slug($name)]);
            
            for ($i = 1; $i <= 2; $i++) {
                ConstituencyProject::create([
                    'name' => "Constituency {$name} Phase {$i}",
                    'title' => "Constituency {$name} Phase {$i}",
                    'slug' => Str::slug("constituency-{$name}-phase-{$i}-" . rand(1, 99)),
                    'category_id' => $cat->id,
                    'state_id' => $state?->id,
                    'lga_id' => $lga?->id,
                    'community' => 'Aladja Community',
                    'location' => 'Main Access Road Junction',
                    'latitude' => 9.0820,
                    'longitude' => 8.6753,
                    'cost' => 25000000.00,
                    'budget' => 25000000.00,
                    'funding_source' => 'Federal Budget Intervention',
                    'start_date' => now()->subMonths(6),
                    'expected_completion' => now()->addMonths(6),
                    'completion_percentage' => 45,
                    'beneficiaries_count' => 15000,
                    'status_project' => 'Ongoing',
                    'summary' => "Providing vital infrastructure developments through community support interventions.",
                    'description' => "<p>Full details description on progress markers, machinery deployed, and target objectives.</p>",
                    'status' => 'published',
                    'published_at' => now(),
                ]);
            }
        }

        // 4. Bills
        for ($i = 1; $i <= 3; $i++) {
            Bill::create([
                'bill_number' => "HB. 2026.0{$i}",
                'title' => "National Legislative Oversight & Transparency Bill {$i}",
                'slug' => Str::slug("national-legislative-oversight-transparency-bill-{$i}-" . rand(1, 99)),
                'category' => 'Governance',
                'sponsor' => 'Office of the Speaker',
                'status_legislative' => 'Second Reading',
                'summary' => "Summary explanation on bill HB 2026.0{$i} aims and objectives.",
                'description' => "<p>Comprehensive clause details relating to transparency, oversight targets, and audits.</p>",
                'date_introduced' => now()->subMonths(2),
                'status' => 'published',
                'published_at' => now(),
            ]);
        }

        // 5. Motions
        for ($i = 1; $i <= 3; $i++) {
            Motion::create([
                'title' => "Urgent Motion on Infrastructure Rehab and Security Measures {$i}",
                'slug' => Str::slug("urgent-motion-infrastructure-rehab-security-{$i}-" . rand(1, 99)),
                'sponsor' => 'Office of the Speaker',
                'date' => now()->subWeeks($i),
                'summary' => "Direct motion address to prioritize structural security checks.",
                'description' => "<p>Transcript and debates surrounding regional security resolutions.</p>",
                'status' => 'published',
                'published_at' => now(),
            ]);
        }

        // 6. Speeches
        for ($i = 1; $i <= 3; $i++) {
            Speech::create([
                'title' => "Inaugural Speech: Leading Legislative Excellence {$i}",
                'slug' => Str::slug("inaugural-speech-leading-legislative-excellence-{$i}-" . rand(1, 99)),
                'event' => 'National Assembly Plenary Opening Session',
                'location' => 'House of Representatives Chamber, Abuja',
                'speech_date' => now()->subMonths(3),
                'summary' => "Keynotes and strategic milestones outline for national growth.",
                'content' => "<p>Speech transcript text contents covering collaborative governance frameworks.</p>",
                'status' => 'published',
                'published_at' => now(),
            ]);
        }

        // 7. Publications
        for ($i = 1; $i <= 2; $i++) {
            Publication::create([
                'title' => "House Rules and Legislative Guidelines Manual Vol. {$i}",
                'slug' => Str::slug("house-rules-legislative-guidelines-manual-vol-{$i}-" . rand(1, 99)),
                'category' => 'Legislative Manual',
                'publication_date' => now()->subYear(),
                'summary' => "Official guidelines handbook covering standard procedures and rules of debate.",
                'description' => "<p>Detailed chapters covering member duties, session rules, and oversight standards.</p>",
                'status' => 'published',
                'published_at' => now(),
            ]);
        }

        // 8. Media Albums & Items
        for ($i = 1; $i <= 2; $i++) {
            $album = MediaAlbum::create([
                'title' => "Official State Tour & Project Inspections {$i}",
                'slug' => Str::slug("official-state-tour-project-inspections-{$i}-" . rand(1, 99)),
                'description' => "Photo album containing snaps of project inspections and tours.",
                'status' => 'published',
                'published_at' => now(),
            ]);

            MediaItem::create([
                'album_id' => $album->id,
                'title' => "Project Inspection Kickoff Snaps {$i}",
                'caption' => 'Inspecting infrastructure developments and milestones.',
                'type' => 'image',
                'date' => now()->subDays(2),
                'status' => 'published',
                'published_at' => now(),
            ]);
        }
    }
}
