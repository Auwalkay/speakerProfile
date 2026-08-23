<?php

namespace App\Filament\Resources\ConstituencyProjectResource\Pages;

use App\Filament\Resources\ConstituencyProjectResource;
use App\Services\ExcelImportService;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ListConstituencyProjects extends ListRecords
{
    protected static string $resource = ConstituencyProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Actions\Action::make('download_template')
                ->label('Download Excel Template')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function () {
                    return response()->download(public_path('samples/constituency_projects_sample_template.csv'));
                }),

            Actions\Action::make('import_excel')
                ->label('Import Excel / CSV')
                ->icon('heroicon-o-document-arrow-up')
                ->color('success')
                ->form([
                    Forms\Components\FileUpload::make('attachment')
                        ->label('Upload Excel (.xlsx) or CSV (.csv) file')
                        ->acceptedFileTypes([
                            'text/csv',
                            'text/plain',
                            'application/csv',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        ])
                        ->storeFiles(true)
                        ->directory('imports')
                        ->required(),
                ])
                ->action(function (array $data) {
                    $relativePath = $data['attachment'];
                    $fullPath = Storage::disk('public')->path($relativePath);

                    if (!file_exists($fullPath)) {
                        $fullPath = storage_path('app/public/' . $relativePath);
                    }

                    try {
                        $parsedRows = ExcelImportService::parseSpreadsheet($fullPath);
                        if (empty($parsedRows)) {
                            Notification::make()
                                ->title('Import Failed')
                                ->body('The uploaded file is empty or could not be parsed.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $importedCount = ExcelImportService::importProjects($parsedRows);

                        Notification::make()
                            ->title('Bulk Import Successful')
                            ->body("Successfully imported {$importedCount} constituency projects from the uploaded spreadsheet!")
                            ->success()
                            ->send();
                    } catch (\Throwable $e) {
                        Notification::make()
                            ->title('Error Processing Spreadsheet')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}
