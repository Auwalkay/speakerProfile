<?php

namespace App\Filament\Widgets;

use App\Models\AuditLog;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentActivity extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Recent Admin Activity Logs';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                AuditLog::with('user')->latest()->take(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Admin User'),
                Tables\Columns\TextColumn::make('action')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'create' => 'success',
                        'update' => 'info',
                        'delete' => 'danger',
                        'publish' => 'success',
                        'approve' => 'success',
                        'archive' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('model_type')
                    ->label('Resource Type')
                    ->formatStateUsing(fn ($state) => class_basename($state)),
                Tables\Columns\TextColumn::make('model_id')
                    ->label('ID'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Timestamp')
                    ->dateTime(),
            ])
            ->paginated(false);
    }
}
