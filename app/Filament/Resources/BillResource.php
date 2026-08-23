<?php

namespace App\Filament\Resources;

use App\Models\Bill;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class BillResource extends Resource
{
    protected static ?string $model = Bill::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Legislative Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Bill Details')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Content')
                            ->schema([
                                Forms\Components\TextInput::make('bill_number')
                                    ->required()
                                    ->maxLength(50),
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
                                    ->unique(Bill::class, 'slug', ignoreRecord: true),
                                Forms\Components\TextInput::make('category')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('sponsor')
                                    ->maxLength(255),
                                Forms\Components\Select::make('status_legislative')
                                    ->options([
                                        'First Reading' => 'First Reading',
                                        'Second Reading' => 'Second Reading',
                                        'Committee Stage' => 'Committee Stage',
                                        'Report Stage' => 'Report Stage',
                                        'Third Reading' => 'Third Reading',
                                        'Passed House' => 'Passed House',
                                        'Passed Senate' => 'Passed Senate',
                                        'Assented' => 'Assented',
                                        'Vetoed' => 'Vetoed',
                                    ])
                                    ->default('First Reading')
                                    ->required(),
                                
                                Forms\Components\DatePicker::make('date_introduced'),
                                Forms\Components\DatePicker::make('date_passed'),
                                Forms\Components\TextInput::make('assent_status')
                                    ->maxLength(255),

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
                                Forms\Components\Toggle::make('featured')
                                    ->default(false),
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Attachments')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('documents')
                                    ->collection('documents')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->maxSize(10240)
                                    ->label('Official Bill Document (PDF)'),
                            ]),
                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('bill_number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('sponsor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_legislative')
                    ->badge()
                    ->color('info'),
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
                Tables\Filters\SelectFilter::make('status_legislative')
                    ->options([
                        'First Reading' => 'First Reading',
                        'Second Reading' => 'Second Reading',
                        'Committee Stage' => 'Committee Stage',
                        'Report Stage' => 'Report Stage',
                        'Third Reading' => 'Third Reading',
                        'Passed House' => 'Passed House',
                        'Passed Senate' => 'Passed Senate',
                        'Assented' => 'Assented',
                        'Vetoed' => 'Vetoed',
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
                    ->action(fn (Bill $record) => $record->update(['status' => 'published', 'published_at' => now()]))
                    ->visible(fn (Bill $record) => $record->status !== 'published')
                    ->color('success')
                    ->icon('heroicon-o-paper-airplane'),
                Tables\Actions\Action::make('approve')
                    ->action(fn (Bill $record) => $record->update(['status' => 'approved']))
                    ->visible(fn (Bill $record) => $record->status === 'review')
                    ->color('info')
                    ->icon('heroicon-o-check'),
                Tables\Actions\Action::make('duplicate')
                    ->action(function (Bill $record) {
                        $duplicate = $record->replicate();
                        $duplicate->slug = Str::slug($duplicate->title . ' - Copy ' . time());
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
            'index' => BillResource\Pages\ListBills::route('/'),
            'create' => BillResource\Pages\CreateBill::route('/create'),
            'edit' => BillResource\Pages\EditBill::route('/{record}/edit'),
        ];
    }
}
