<?php

namespace App\Filament\Resources\AlbumResource\RelationManagers;

use App\Models\MediaItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class MediaItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'mediaItems';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->options([
                        'image' => 'Image / Photo',
                        'video' => 'Video Clip',
                    ])
                    ->default('image')
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\Textarea::make('caption')
                    ->maxLength(500)
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ])
                    ->default('draft')
                    ->required(),
                SpatieMediaLibraryFileUpload::make('media')
                    ->collection('media')
                    ->required()
                    ->columnSpanFull()
                    ->label('Upload File (Image/MP4)'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('type')->badge(),
                Tables\Columns\TextColumn::make('date')->date(),
                Tables\Columns\TextColumn::make('status')->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(fn (array $data): array => array_merge($data, [
                        'created_by' => auth()->id(),
                        'published_at' => $data['status'] === 'published' ? now() : null,
                    ])),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(fn (array $data): array => array_merge($data, [
                        'updated_by' => auth()->id(),
                        'published_at' => $data['status'] === 'published' ? now() : null,
                    ])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
