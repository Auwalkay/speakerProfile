<?php

namespace App\Filament\Widgets;

use App\Models\Achievement;
use App\Models\Bill;
use App\Models\ConstituencyProject;
use App\Models\Motion;
use App\Models\News;
use App\Models\Speech;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $publishedAchievements = Achievement::where('status', 'published')->count();
        
        $pendingApprovals = Achievement::where('status', 'review')->count() +
            Bill::where('status', 'review')->count() +
            Motion::where('status', 'review')->count() +
            ConstituencyProject::where('status', 'review')->count() +
            News::where('status', 'review')->count() +
            Speech::where('status', 'review')->count();

        $totalProjects = ConstituencyProject::count();
        $totalBills = Bill::count();

        return [
            Stat::make('Published Achievements', $publishedAchievements)
                ->description('Verified public portal achievements')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
            Stat::make('Pending Approvals', $pendingApprovals)
                ->description('Items awaiting editor review')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            Stat::make('Constituency Projects', $totalProjects)
                ->description('Total registered projects')
                ->descriptionIcon('heroicon-m-building-office-2'),
            Stat::make('Legislative Bills', $totalBills)
                ->description('Total sponsored bills')
                ->descriptionIcon('heroicon-m-document-text'),
        ];
    }
}
