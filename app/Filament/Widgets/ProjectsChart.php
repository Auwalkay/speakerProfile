<?php

namespace App\Filament\Widgets;

use App\Models\ConstituencyProject;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ProjectsChart extends ChartWidget
{
    protected static ?string $heading = 'Constituency Projects Intake';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        $expression = match ($driver) {
            'sqlite' => "strftime('%m', created_at) as month",
            'mysql' => "MONTH(created_at) as month",
            default => "EXTRACT(MONTH FROM created_at) as month",
        };

        $data = ConstituencyProject::selectRaw("{$expression}, count(*) as count")
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $monthlyCounts = array_fill(1, 12, 0);
        foreach ($data as $month => $count) {
            $monthlyCounts[(int)$month] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Projects Registered',
                    'data' => array_values($monthlyCounts),
                    'backgroundColor' => '#008751',
                    'borderColor' => '#008751',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }
}
