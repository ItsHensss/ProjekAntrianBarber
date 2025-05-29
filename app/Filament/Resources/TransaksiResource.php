<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Filament\Resources\TransaksiResource\RelationManagers;
use App\Models\Queue;
use App\Models\Transaksi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransaksiResource extends Resource
{
    protected static ?string $model = Queue::class;

    protected static ?string $navigationIcon = 'heroicon-o-cash';
    protected static ?string $tenantOwnershipRelationshipName = 'tenant';
    protected static ?string $label = 'Transaksi';
    protected static ?string $pluralLabel = 'Transaksi';
    protected static ?string $slug = 'transaksi';
    protected static ?string $navigationLabel = 'Transaksi';
    protected static ?string $recordTitleAttribute = 'id';
    protected static ?string $modelLabel = 'Transaksi';
    protected static ?string $pluralModelLabel = 'Transaksi';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID'),
                Tables\Columns\TextColumn::make('customer_name')->label('Nama Pelanggan'),
                Tables\Columns\TextColumn::make('produk')
                    ->label('Produk')
                    ->formatStateUsing(function ($state, $record) {
                        // Asumsikan ada relasi produk di model Queue
                        if (method_exists($record, 'produk')) {
                            return $record->produk->pluck('nama')->join(', ');
                        }
                        return '-';
                    }),
                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total Harga')
                    ->formatStateUsing(function ($state, $record) {
                        // Kalkulasi total harga produk yang diambil
                        if (method_exists($record, 'produk')) {
                            return 'Rp ' . number_format($record->produk->sum('harga'), 0, ',', '.');
                        }
                        return 'Rp 0';
                    }),
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal')->dateTime('d-m-Y H:i'),
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
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }
}
