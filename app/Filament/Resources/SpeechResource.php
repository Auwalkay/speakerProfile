<?php

namespace App\Filament\Resources;

use App\Models\Speech;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class SpeechResource extends Resource
{
    protected static ?string $model = Speech::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center';

    protected static ?string $navigationGroup = 'Content Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Speech Details')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Content')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->disabled()
                                    ->dehydrated()
                                    ->maxLength(255)
                                    ->unique(Speech::class, 'slug', ignoreRecord: true),
                                Forms\Components\TextInput::make('event')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('location')
                                    ->maxLength(255),
                                Forms\Components\DatePicker::make('speech_date')
                                    ->required(),
                                Forms\Components\TextInput::make('video_url')
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('summary')
                                    ->maxLength(500)
                                    ->columnSpanFull(),
                                Forms\Components\RichEditor::make('content')
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\RichEditor::make('transcript')
                                    ->columnSpanFull(),
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'review' => 'In Review',
                                        'approved' => 'Approved',
                                        'published' => 'Published',
                                        'archived' => 'Archived',
                                    ])
                                    ->default('draft')
                                    ->required(),
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Attachments')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('pdf')
                                    ->collection('pdf')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->label('Official Transcript PDF'),
                            ]),
                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('event')
                    ->searchable(),
                Tables\Columns\TextColumn::make('speech_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'review' => 'warning',
                        'approved' => 'info',
                        'published' => 'success',
                        'archived' => 'danger',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'review' => 'In Review',
                        'approved' => 'Approved',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('publish')
                    ->action(fn (Speech $record) => $record->update(['status' => 'published', 'published_at' => now()]))
                    ->visible(fn (Speech $record) => $record->status !== 'published')
                    ->color('success')
                    ->icon('heroicon-o-paper-airplane'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => SpeechResource\Pages\ListSpeeches::route('/'),
            'create' => SpeechResource\Pages\CreateSpeech::route('/create'),
            'edit' => SpeechResource\Pages\EditSpeech::route('/{record}/edit'),
        ];
    }
}
