<?php

namespace App\Filament\Resources;

use App\Models\ConstituencyProject;
use App\Models\Lga;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class ConstituencyProjectResource extends Resource
{
    protected static ?string $model = ConstituencyProject::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'Projects Management';

    protected static ?string $navigationLabel = 'Constituency Projects';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Project Details')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Content')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                        if ($operation === 'create') {
                                            $set('slug', Str::slug($state));
                                            $set('title', $state);
                                        }
                                    }),
                                Forms\Components\Hidden::make('title')
                                    ->dehydrated(fn ($state, callable $get) => filled($state) || filled($get('name')))
                                    ->default(fn (callable $get) => $get('name')),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->disabled()
                                    ->dehydrated()
                                    ->maxLength(255)
                                    ->unique(ConstituencyProject::class, 'slug', ignoreRecord: true),
                                Forms\Components\Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\Select::make('status_project')
                                    ->options([
                                        'Annually' => 'Annually',
                                        'Awarded' => 'Awarded',
                                        'Budgeted' => 'Budgeted',
                                        'Budgeted 2026' => 'Budgeted 2026',
                                        'Completed' => 'Completed',
                                        'Distributed' => 'Distributed',
                                        'Ongoing' => 'Ongoing',
                                        'Planned' => 'Planned',
                                        'Seasonal' => 'Seasonal',
                                        'Suspended' => 'Suspended',
                                        'Cancelled' => 'Cancelled',
                                    ])
                                    ->default('Planned')
                                    ->required(),
                                
                                // Geo Location
                                Forms\Components\Select::make('state_id')
                                    ->label('State')
                                    ->options(State::pluck('name', 'id'))
                                    ->reactive()
                                    ->afterStateUpdated(fn (Forms\Set $set) => $set('lga_id', null))
                                    ->required(),
                                Forms\Components\Select::make('lga_id')
                                    ->label('LGA')
                                    ->options(fn (callable $get) => Lga::where('state_id', $get('state_id'))->pluck('name', 'id'))
                                    ->reactive()
                                    ->disabled(fn (callable $get) => !$get('state_id'))
                                    ->required(),
                                Forms\Components\TextInput::make('community')
                                    ->nullable()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('location')
                                    ->nullable()
                                    ->maxLength(255),

                                // Budgets & Timeline (All Nullable / Optional)
                                Forms\Components\TextInput::make('budget')
                                    ->numeric()
                                    ->nullable()
                                    ->prefix('₦'),
                                Forms\Components\TextInput::make('funding_source')
                                    ->nullable()
                                    ->maxLength(255),
                                Forms\Components\DatePicker::make('start_date')
                                    ->nullable(),
                                Forms\Components\DatePicker::make('expected_completion')
                                    ->label('Expected Completion / End Date')
                                    ->nullable(),
                                Forms\Components\TextInput::make('completion_percentage')
                                    ->numeric()
                                    ->nullable()
                                    ->default(0)
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->suffix('%'),
                                Forms\Components\TextInput::make('beneficiaries_count')
                                    ->label('Beneficiaries')
                                    ->numeric()
                                    ->nullable()
                                    ->default(0),

                                Forms\Components\Textarea::make('summary')
                                    ->nullable()
                                    ->maxLength(500)
                                    ->columnSpanFull(),
                                Forms\Components\RichEditor::make('description')
                                    ->nullable()
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

                        Forms\Components\Tabs\Tab::make('Map Coordinates')
                            ->schema([
                                Forms\Components\TextInput::make('latitude')
                                    ->numeric()
                                    ->placeholder('e.g. 9.0820'),
                                Forms\Components\TextInput::make('longitude')
                                    ->numeric()
                                    ->placeholder('e.g. 8.6753'),
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Media & Progress Attachments')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('before')
                                    ->collection('before')
                                    ->image()
                                    ->label('Before Photo'),
                                SpatieMediaLibraryFileUpload::make('during')
                                    ->collection('during')
                                    ->image()
                                    ->label('During Photo'),
                                SpatieMediaLibraryFileUpload::make('after')
                                    ->collection('after')
                                    ->image()
                                    ->label('After Photo'),
                                SpatieMediaLibraryFileUpload::make('gallery')
                                    ->collection('gallery')
                                    ->multiple()
                                    ->image()
                                    ->label('Gallery Images'),
                                SpatieMediaLibraryFileUpload::make('documents')
                                    ->collection('documents')
                                    ->multiple()
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->label('PDF Documents'),
                                SpatieMediaLibraryFileUpload::make('videos')
                                    ->collection('videos')
                                    ->multiple()
                                    ->acceptedFileTypes(['video/mp4'])
                                    ->label('Videos (MP4)'),
                            ]),
                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('state.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_project')
                    ->badge()
                    ->color(fn (?string $state): string => match (strtolower($state ?? '')) {
                        'planned', 'proposed', 'budgeted', 'budgeted 2026' => 'gray',
                        'ongoing', 'in progress', 'in-progress' => 'warning',
                        'completed', 'commissioned', 'distributed' => 'success',
                        'awarded' => 'primary',
                        'annually', 'seasonal' => 'info',
                        'suspended', 'cancelled' => 'danger',
                        default => 'info',
                    }),
                Tables\Columns\TextColumn::make('completion_percentage')
                    ->numeric()
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (?string $state): string => match (strtolower($state ?? '')) {
                        'draft' => 'gray',
                        'review' => 'warning',
                        'approved' => 'info',
                        'published' => 'success',
                        'archived' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_project')
                    ->options([
                        'Annually' => 'Annually',
                        'Awarded' => 'Awarded',
                        'Budgeted' => 'Budgeted',
                        'Budgeted 2026' => 'Budgeted 2026',
                        'Completed' => 'Completed',
                        'Distributed' => 'Distributed',
                        'Ongoing' => 'Ongoing',
                        'Planned' => 'Planned',
                        'Seasonal' => 'Seasonal',
                        'Suspended' => 'Suspended',
                        'Cancelled' => 'Cancelled',
                    ]),
                Tables\Filters\SelectFilter::make('state_id')
                    ->options(State::pluck('name', 'id'))
                    ->label('State'),
                Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Category'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('publish')
                    ->action(fn (ConstituencyProject $record) => $record->update(['status' => 'published', 'published_at' => now()]))
                    ->visible(fn (ConstituencyProject $record) => $record->status !== 'published')
                    ->color('success')
                    ->icon('heroicon-o-paper-airplane'),
                Tables\Actions\Action::make('duplicate')
                    ->action(function (ConstituencyProject $record) {
                        $duplicate = $record->replicate();
                        $duplicate->slug = Str::slug($duplicate->name . ' - Copy ' . time());
                        $duplicate->status = 'draft';
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
            'index' => ConstituencyProjectResource\Pages\ListConstituencyProjects::route('/'),
            'create' => ConstituencyProjectResource\Pages\CreateConstituencyProject::route('/create'),
            'edit' => ConstituencyProjectResource\Pages\EditConstituencyProject::route('/{record}/edit'),
        ];
    }
}
