<?php

namespace App\Filament\Resources\AppointeeResource\Pages;

use App\Filament\Resources\AppointeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAppointees extends ListRecords
{
    protected static string $resource = AppointeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
