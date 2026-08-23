<?php

namespace App\Filament\Resources\ConstituencyProjectResource\Pages;

use App\Filament\Resources\ConstituencyProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConstituencyProjects extends ListRecords
{
    protected static string $resource = ConstituencyProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
