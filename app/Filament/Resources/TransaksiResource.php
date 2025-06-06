<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Models\Queue;
use App\Models\Transaksi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransaksiResource extends Resource
{
    protected static ?string $model = Queue::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
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
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),

                TextColumn::make('customer.nama')
                    ->label('Nama Pelanggan')
                    ->searchable(),

                TextColumn::make('produk.judul')
                    ->label('Produk')
                    ->searchable(),

                TextColumn::make('produk.harga')
                    ->label('Harga Produk')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),

                TextColumn::make('booking_date')
                    ->label('Tanggal Booking')
                    ->date('l, d F Y'),
            ])
            ->filters([
                // Filter berdasarkan tanggal
                Filter::make('booking_date')
                    ->label('Tanggal Booking')
                    ->form([
                        Forms\Components\DatePicker::make('from_date')
                            ->label('Dari Tanggal')
                            ->default(now()->startOfMonth()),

                        Forms\Components\DatePicker::make('to_date')
                            ->label('Sampai Tanggal')
                            ->default(now()),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['from_date']) && !empty($data['to_date'])) {
                            $query->whereBetween('booking_date', [
                                Carbon::parse($data['from_date'])->startOfDay(),
                                Carbon::parse($data['to_date'])->endOfDay(),
                            ]);
                        } elseif (!empty($data['from_date'])) {
                            $query->whereDate('booking_date', '>=', Carbon::parse($data['from_date'])->startOfDay());
                        } elseif (!empty($data['to_date'])) {
                            $query->whereDate('booking_date', '<=', Carbon::parse($data['to_date'])->endOfDay());
                        }
                    }),
            ])
            ->defaultSort('created_at', 'desc');
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
        ];
    }
}
