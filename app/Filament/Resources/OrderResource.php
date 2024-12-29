<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;
use Filament\Tables\Actions\Action;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('customer_name')->required(),
                Forms\Components\TextInput::make('customer_email')->email(),
                Forms\Components\TextInput::make('customer_phone'),
                Forms\Components\TextInput::make('total_price')->numeric()->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'cancelled' => 'Cancelled',
                        'expired' => 'Expired',
                    ])
                    ->required(),
                Forms\Components\Select::make('payment_method')
                    ->options(['COD' => 'COD', 'Midtrans' => 'Midtrans'])
                    ->required(),

                Forms\Components\Select::make('products')
                    ->label('Pilih Produk')
                    ->multiple()
                    ->options(Product::all()->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer_name'),
                Tables\Columns\TextColumn::make('total_price')->sortable(),
                Tables\Columns\TextColumn::make('status')->sortable(),
                Tables\Columns\TextColumn::make('payment_method')->sortable(),
                Tables\Columns\TextColumn::make('products')
                    ->label('Produk')
                    ->getStateUsing(function ($record) {
                        // Karena 'products' sudah dicast ke array, kita langsung mengambilnya
                        if (!is_array($record->products) || empty($record->products)) {
                            return '-';
                        }

                        return Product::whereIn('id', $record->products)
                            ->pluck('name')
                            ->implode(', ');
                    })
                    ->wrap(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('cetak_laporan')
                ->label('Cetak Laporan Pesanan')
                ->icon('heroicon-o-printer')
                ->url(fn($record) => route('reports.orders', $record->id))
                ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
