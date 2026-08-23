<?php

namespace App\Filament\Resources;

use App\Models\LegislativeWork;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class LegislativeWorkResource extends Resource
{
    protected static ?string $model = LegislativeWork::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Legislative Management';

    protected static ?string $navigationLabel = 'Legislative Works';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
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
                            ->unique(LegislativeWork::class, 'slug', ignoreRecord: true),
                        Forms\Components\Select::make('type')
                            ->options([
                                'Committee' => 'Committee',
                                'Oversight' => 'Oversight',
                                'Plenary' => 'Plenary',
                                'Constituency Engagement' => 'Constituency Engagement',
                            ])
                            ->default('Committee')
                            ->required(),
                        Forms\Components\Textarea::make('summary')
                            ->required()
                            ->maxLength(500)
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('description')
                            ->required()
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
                    ])->columns(2)
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
                Tables\Columns\TextColumn::make('type')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state ?? '') {
                        'draft' => 'gray',
                        'review' => 'warning',
                        'approved' => 'info',
                        'published' => 'success',
                        'archived' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'Committee' => 'Committee',
                        'Oversight' => 'Oversight',
                        'Plenary' => 'Plenary',
                        'Constituency Engagement' => 'Constituency Engagement',
                    ]),
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
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('publish')
                    ->action(fn (LegislativeWork $record) => $record->update(['status' => 'published', 'published_at' => now()]))
                    ->visible(fn (LegislativeWork $record) => $record->status !== 'published')
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
            'index' => LegislativeWorkResource\Pages\ListLegislativeWorks::route('/'),
            'create' => LegislativeWorkResource\Pages\CreateLegislativeWork::route('/create'),
            'edit' => LegislativeWorkResource\Pages\EditLegislativeWork::route('/{record}/edit'),
        ];
    }
}
