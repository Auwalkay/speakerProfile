<?php

namespace App\Filament\Resources\MotionResource\Pages;

use App\Filament\Resources\MotionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMotion extends CreateRecord
{
    protected static string $resource = MotionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();

        return $data;
    }
}
