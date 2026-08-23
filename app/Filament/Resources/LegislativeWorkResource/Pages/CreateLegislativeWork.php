<?php

namespace App\Filament\Resources\LegislativeWorkResource\Pages;

use App\Filament\Resources\LegislativeWorkResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLegislativeWork extends CreateRecord
{
    protected static string $resource = LegislativeWorkResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();

        return $data;
    }
}
