<?php

namespace App\Filament\Resources\AppointeeResource\Pages;

use App\Filament\Resources\AppointeeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAppointee extends EditRecord
{
    protected static string $resource = AppointeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
