<?php

namespace App\Filament\Resources;

use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\SiteSettingResource\Pages;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'System';

    protected static ?string $navigationLabel = 'Site Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->required()
                            ->disabled()
                            ->dehydrated()
                            ->maxLength(255),
                        Forms\Components\Select::make('type')
                            ->options([
                                'text' => 'Plain Text',
                                'image' => 'Media Image',
                            ])
                            ->disabled()
                            ->dehydrated()
                            ->required(),
                        Forms\Components\Textarea::make('value')
                            ->label('Text Setting Value')
                            ->maxLength(65535)
                            ->visible(fn (callable $get) => $get('type') === 'text')
                            ->columnSpanFull(),
                        
                        SpatieMediaLibraryFileUpload::make('speaker_image')
                            ->collection('speaker_image')
                            ->image()
                            ->label('Upload Welcome Portrait')
                            ->visible(fn (callable $get) => $get('key') === 'speaker_image')
                            ->columnSpanFull(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('type')->badge(),
                Tables\Columns\TextColumn::make('value')->limit(50),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListSiteSettings::route('/'),
        ];
    }
}
