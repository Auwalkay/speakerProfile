<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointeeResource\Pages;
use App\Models\Appointee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class AppointeeResource extends Resource
{
    protected static ?string $model = Appointee::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?string $navigationLabel = 'Appointees & SAs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('designation')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Special Adviser on Media'),
                        Forms\Components\Select::make('category')
                            ->options([
                                'Special Adviser' => 'Special Adviser (SA)',
                                'Senior Special Assistant' => 'Senior Special Assistant (SSA)',
                                'Special Assistant' => 'Special Assistant',
                                'Chief of Staff' => 'Chief of Staff',
                                'Aide' => 'Aide / Personal Assistant',
                            ])
                            ->default('Special Adviser')
                            ->required(),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Forms\Components\Textarea::make('bio')
                            ->maxLength(500)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                            ])
                            ->default('draft')
                            ->required(),
                        SpatieMediaLibraryFileUpload::make('avatar')
                            ->collection('avatar')
                            ->image()
                            ->label('Profile Photo')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('avatar')
                    ->collection('avatar')
                    ->label('Photo')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('designation')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Chief of Staff' => 'danger',
                        'Special Adviser' => 'success',
                        'Senior Special Assistant' => 'warning',
                        'Special Assistant' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable()
                    ->label('Order'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'Chief of Staff' => 'Chief of Staff',
                        'Special Adviser' => 'Special Adviser',
                        'Senior Special Assistant' => 'Senior Special Assistant',
                        'Special Assistant' => 'Special Assistant',
                        'Aide' => 'Aide / Personal Assistant',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListAppointees::route('/'),
            'create' => Pages\CreateAppointee::route('/create'),
            'edit' => Pages\EditAppointee::route('/{record}/edit'),
        ];
    }
}
