<?php

namespace App\Filament\Resources\MotionResource\Pages;

use App\Filament\Resources\MotionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMotion extends EditRecord
{
    protected static string $resource = MotionResource::class;

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
