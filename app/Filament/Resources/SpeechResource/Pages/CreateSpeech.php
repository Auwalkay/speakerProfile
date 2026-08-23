<?php

namespace App\Filament\Resources\SpeechResource\Pages;

use App\Filament\Resources\SpeechResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSpeech extends CreateRecord
{
    protected static string $resource = SpeechResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();

        return $data;
    }
}
