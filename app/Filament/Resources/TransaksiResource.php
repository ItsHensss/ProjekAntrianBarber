<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Models\Queue;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

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

                TextColumn::make('status')
                    ->label('Status'),

                TextColumn::make('user.name')
                    ->label('Chapster'),

                TextColumn::make('produk.harga')
                    ->label('Harga Produk')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),

                TextColumn::make('booking_date')
                    ->label('Tanggal Booking')
                    ->date('l, d F Y'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Group by Chapster')
                    ->options(fn() => \App\Models\User::pluck('name', 'id'))
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value'])) {
                            $query->where('user_id', $data['value']);
                        }
                    }),

                Tables\Filters\SelectFilter::make('produk_id')
                    ->label('Group by Produk')
                    ->options(fn() => \App\Models\Produk::where('tenant_id', Auth::user()?->teams->first()?->id)->pluck('judul', 'id'))
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value'])) {
                            $query->where('produk_id', $data['value']);
                        }
                    }),

                Tables\Filters\Filter::make('booking_date')
                    ->label('Group by Tanggal Booking')
                    ->form([
                        Forms\Components\DatePicker::make('booking_date'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['booking_date'])) {
                            $query->whereDate('booking_date', $data['booking_date']);
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
