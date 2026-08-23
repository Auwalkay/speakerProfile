<?php

namespace App\Filament\Resources;

use App\Models\AuditLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AuditLogResource extends Resource
{
    protected static ?string $model = AuditLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationGroup = 'System';

    protected static ?string $navigationLabel = 'Audit Logs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('user.name')->disabled(),
                        Forms\Components\TextInput::make('action')->disabled(),
                        Forms\Components\TextInput::make('model_type')->disabled(),
                        Forms\Components\TextInput::make('model_id')->disabled(),
                        Forms\Components\TextInput::make('ip_address')->disabled(),
                        Forms\Components\TextInput::make('user_agent')->disabled(),
                        Forms\Components\KeyValue::make('old_values')->disabled()->columnSpanFull(),
                        Forms\Components\KeyValue::make('new_values')->disabled()->columnSpanFull(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('action')->badge()->color(fn (string $state): string => match ($state) {
                    'create' => 'success',
                    'update' => 'info',
                    'delete' => 'danger',
                    'publish' => 'success',
                    'approve' => 'success',
                    'archive' => 'gray',
                    default => 'gray',
                })->sortable(),
                Tables\Columns\TextColumn::make('model_type')->sortable(),
                Tables\Columns\TextColumn::make('model_id')->sortable(),
                Tables\Columns\TextColumn::make('ip_address'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('action')
                    ->options([
                        'create' => 'Create',
                        'update' => 'Update',
                        'delete' => 'Delete',
                        'publish' => 'Publish',
                        'approve' => 'Approve',
                        'archive' => 'Archive',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // Read-only parameters
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => AuditLogResource\Pages\ListAuditLogs::route('/'),
        ];
    }
}
