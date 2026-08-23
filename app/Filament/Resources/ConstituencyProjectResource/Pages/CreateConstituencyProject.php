<?php

namespace App\Filament\Resources\ConstituencyProjectResource\Pages;

use App\Filament\Resources\ConstituencyProjectResource;
use Filament\Resources\Pages\CreateRecord;

class CreateConstituencyProject extends CreateRecord
{
    protected static string $resource = ConstituencyProjectResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();

        return $data;
    }
}
