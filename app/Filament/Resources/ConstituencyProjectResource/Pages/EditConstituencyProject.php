<?php

namespace App\Filament\Resources\ConstituencyProjectResource\Pages;

use App\Filament\Resources\ConstituencyProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditConstituencyProject extends EditRecord
{
    protected static string $resource = ConstituencyProjectResource::class;

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
