<?php

namespace App\Filament\Resources\LegislativeWorkResource\Pages;

use App\Filament\Resources\LegislativeWorkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLegislativeWork extends EditRecord
{
    protected static string $resource = LegislativeWorkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['updated_by'] = auth()->id();

        return $data;
    }
}
