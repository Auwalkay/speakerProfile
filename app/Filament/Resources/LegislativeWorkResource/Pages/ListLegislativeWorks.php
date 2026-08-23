<?php

namespace App\Filament\Resources\LegislativeWorkResource\Pages;

use App\Filament\Resources\LegislativeWorkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLegislativeWorks extends ListRecords
{
    protected static string $resource = LegislativeWorkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
