<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\AchievementCategory;
use App\Models\Bill;
use App\Models\ConstituencyProject;
use App\Models\Lga;
use App\Models\News;
use App\Models\ProjectCategory;
use App\Models\State;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelImportService
{
    /**
     * Parse uploaded spreadsheet file into array of rows with normalized headers.
     */
    public static function parseSpreadsheet(string $filePath): array
    {
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rawRows = $worksheet->toArray();

        if (empty($rawRows) || count($rawRows) < 2) {
            return [];
        }

        // Header row
        $headers = array_map(function ($h) {
            return Str::slug((string) $h, '_');
        }, array_shift($rawRows));

        $records = [];
        foreach ($rawRows as $row) {
            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }

            $record = [];
            foreach ($headers as $index => $header) {
                if (empty($header)) {
                    continue;
                }
                $record[$header] = isset($row[$index]) ? trim((string) $row[$index]) : null;
            }
            $records[] = $record;
        }

        return $records;
    }

    /**
     * Bulk import Constituency Projects from parsed spreadsheet rows.
     */
    public static function importProjects(array $rows): int
    {
        $count = 0;
        $defaultState = State::first();
        $defaultLga = Lga::first();
        $defaultCategory = ProjectCategory::first();

        foreach ($rows as $row) {
            $name = $row['name'] ?? $row['project_name'] ?? $row['title'] ?? null;
            if (empty($name)) {
                continue;
            }

            // Category lookup/creation
            $catName = $row['category'] ?? $row['project_category'] ?? null;
            if ($catName) {
                $category = ProjectCategory::firstOrCreate(
                    ['name' => $catName],
                    ['slug' => Str::slug($catName)]
                );
            } else {
                $category = $defaultCategory;
            }

            // State lookup
            $stateName = $row['state'] ?? $row['state_name'] ?? null;
            $state = null;
            if ($stateName) {
                $state = State::where('name', 'LIKE', '%' . $stateName . '%')->first();
            }
            $state = $state ?: $defaultState;

            // LGA lookup
            $lgaName = $row['lga'] ?? $row['lga_name'] ?? null;
            $lga = null;
            if ($lgaName && $state) {
                $lga = Lga::where('state_id', $state->id)->where('name', 'LIKE', '%' . $lgaName . '%')->first();
            }
            $lga = $lga ?: $defaultLga;

            // Parse numerical values safely
            $budget = isset($row['budget']) && is_numeric(str_replace([',', '₦', '$'], '', $row['budget']))
                ? (float) str_replace([',', '₦', '$'], '', $row['budget'])
                : null;

            $completionPercentage = isset($row['completion_percentage']) && is_numeric($row['completion_percentage'])
                ? (int) $row['completion_percentage']
                : (isset($row['percentage']) && is_numeric($row['percentage']) ? (int) $row['percentage'] : 0);

            $beneficiaries = isset($row['beneficiaries_count']) && is_numeric($row['beneficiaries_count'])
                ? (int) $row['beneficiaries_count']
                : (isset($row['beneficiaries']) && is_numeric($row['beneficiaries']) ? (int) $row['beneficiaries'] : null);

            $slug = Str::limit(Str::slug($name), 200, '');
            if (empty($slug)) {
                $slug = 'project-' . Str::random(8);
            }
            if (ConstituencyProject::where('slug', $slug)->exists()) {
                $slug .= '-' . Str::random(5);
            }

            ConstituencyProject::create([
                'name' => $name,
                'title' => $name,
                'slug' => $slug,
                'category_id' => $category ? $category->id : null,
                'state_id' => $state ? $state->id : null,
                'lga_id' => $lga ? $lga->id : null,
                'community' => $row['community'] ?? null,
                'location' => $row['location'] ?? null,
                'budget' => $budget,
                'funding_source' => $row['funding_source'] ?? $row['funding'] ?? null,
                'start_date' => !empty($row['start_date']) ? date('Y-m-d', strtotime($row['start_date'])) : null,
                'expected_completion' => !empty($row['expected_completion']) ? date('Y-m-d', strtotime($row['expected_completion'])) : (!empty($row['end_date']) ? date('Y-m-d', strtotime($row['end_date'])) : null),
                'completion_percentage' => $completionPercentage,
                'beneficiaries_count' => $beneficiaries,
                'status_project' => !empty($row['status_project']) ? ucfirst($row['status_project']) : (!empty($row['status']) ? ucfirst($row['status']) : 'Ongoing'),
                'summary' => $row['summary'] ?? null,
                'description' => $row['description'] ?? null,
                'status' => 'published',
                'published_at' => now(),
            ]);

            $count++;
        }

        return $count;
    }

    /**
     * Bulk import News articles from parsed spreadsheet rows.
     */
    public static function importNews(array $rows): int
    {
        $count = 0;
        foreach ($rows as $row) {
            $title = $row['title'] ?? $row['news_title'] ?? null;
            if (empty($title)) {
                continue;
            }

            $slug = Str::slug($title);
            if (News::where('slug', $slug)->exists()) {
                $slug .= '-' . Str::random(5);
            }

            News::create([
                'title' => $title,
                'slug' => $slug,
                'summary' => $row['summary'] ?? null,
                'content' => $row['content'] ?? $row['description'] ?? $title,
                'status' => 'published',
                'published_at' => !empty($row['published_at']) ? date('Y-m-d H:i:s', strtotime($row['published_at'])) : now(),
            ]);

            $count++;
        }

        return $count;
    }
}
