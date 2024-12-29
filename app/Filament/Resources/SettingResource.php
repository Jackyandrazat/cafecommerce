<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->label('Key')
                    ->disabled()
                    ->required(),

                Forms\Components\Toggle::make('value')
                    ->label('Akses Promo untuk Kasir')
                    ->onIcon('heroicon-o-check') // Ikon ketika aktif
                    ->offIcon('heroicon-o-x-circle') // Ikon ketika nonaktif
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Key')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\IconColumn::make('value')
                    ->label('Status')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
        // ->bulkActions([
        //     Tables\Actions\BulkActionGroup::make([
        //         Tables\Actions\DeleteBulkAction::make(),
        //     ]),
        // ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            // 'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->check() && auth()->user()?->hasPermissionTo('manage settings');
    }

    public static function canCreate(): bool
    {
        return auth()->check() && auth()->user()?->hasPermissionTo('manage settings');
    }

    public static function canEdit($record): bool
    {
        return auth()->check() && auth()->user()?->hasPermissionTo('manage settings');
    }

    public static function canDelete($record): bool
    {
        return auth()->check() && auth()->user()?->hasPermissionTo('manage settings');
    }
}
