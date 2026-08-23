<?php

namespace App\Filament\Resources;

use App\Models\Achievement;
use App\Models\Lga;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class AchievementResource extends Resource
{
    protected static ?string $model = Achievement::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';
    
    protected static ?string $navigationGroup = 'Achievements Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Achievement Details')
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
                                    ->unique(Achievement::class, 'slug', ignoreRecord: true),
                                Forms\Components\Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\DatePicker::make('achievement_date')
                                    ->required(),
                                
                                // Geo Location
                                Forms\Components\Select::make('state_id')
                                    ->label('State')
                                    ->options(State::pluck('name', 'id'))
                                    ->reactive()
                                    ->afterStateUpdated(fn (Forms\Set $set) => $set('lga_id', null)),
                                Forms\Components\Select::make('lga_id')
                                    ->label('LGA')
                                    ->options(fn (callable $get) => Lga::where('state_id', $get('state_id'))->pluck('name', 'id'))
                                    ->reactive()
                                    ->disabled(fn (callable $get) => !$get('state_id')),
                                Forms\Components\TextInput::make('location')
                                    ->maxLength(255),

                                Forms\Components\Textarea::make('summary')
                                    ->required()
                                    ->maxLength(500)
                                    ->columnSpanFull(),
                                Forms\Components\RichEditor::make('content')
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('impact_summary')
                                    ->maxLength(1000)
                                    ->columnSpanFull(),
                                
                                // Settings
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
                                Forms\Components\Toggle::make('featured')
                                    ->default(false),
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Media & Attachments')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('featured_image')
                                    ->collection('featured_image')
                                    ->image()
                                    ->maxSize(5120),
                                SpatieMediaLibraryFileUpload::make('gallery')
                                    ->collection('gallery')
                                    ->multiple()
                                    ->image()
                                    ->maxSize(5120),
                                SpatieMediaLibraryFileUpload::make('documents')
                                    ->collection('documents')
                                    ->multiple()
                                    ->acceptedFileTypes(['application/pdf', 'application/msword'])
                                    ->maxSize(10240),
                                SpatieMediaLibraryFileUpload::make('videos')
                                    ->collection('videos')
                                    ->multiple()
                                    ->acceptedFileTypes(['video/mp4', 'video/quicktime'])
                                    ->maxSize(51200),
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
                    ->limit(40),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('achievement_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('state.name')
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
                Tables\Columns\IconColumn::make('featured')
                    ->boolean()
                    ->sortable(),
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
                Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Category'),
                Tables\Filters\SelectFilter::make('state_id')
                    ->options(State::pluck('name', 'id'))
                    ->label('State'),
                Tables\Filters\TernaryFilter::make('featured')
                    ->label('Featured Only'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('publish')
                    ->action(fn (Achievement $record) => $record->update(['status' => 'published', 'published_at' => now()]))
                    ->visible(fn (Achievement $record) => $record->status !== 'published')
                    ->color('success')
                    ->icon('heroicon-o-paper-airplane'),
                Tables\Actions\Action::make('approve')
                    ->action(fn (Achievement $record) => $record->update(['status' => 'approved']))
                    ->visible(fn (Achievement $record) => $record->status === 'review')
                    ->color('info')
                    ->icon('heroicon-o-check'),
                Tables\Actions\Action::make('archive')
                    ->action(fn (Achievement $record) => $record->update(['status' => 'archived']))
                    ->visible(fn (Achievement $record) => $record->status === 'published')
                    ->color('danger')
                    ->icon('heroicon-o-archive-box'),
                Tables\Actions\Action::make('duplicate')
                    ->action(function (Achievement $record) {
                        $duplicate = $record->replicate();
                        $duplicate->slug = Str::slug($duplicate->title . ' - Copy ' . time());
                        $duplicate->status = 'draft';
                        $duplicate->featured = false;
                        $duplicate->save();
                    })
                    ->color('gray')
                    ->icon('heroicon-o-document-duplicate'),
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
            'index' => AchievementResource\Pages\ListAchievements::route('/'),
            'create' => AchievementResource\Pages\CreateAchievement::route('/create'),
            'edit' => AchievementResource\Pages\EditAchievement::route('/{record}/edit'),
        ];
    }
}
