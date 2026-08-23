<?php

namespace App\Filament\Resources\MotionResource\Pages;

use App\Filament\Resources\MotionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMotions extends ListRecords
{
    protected static string $resource = MotionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
