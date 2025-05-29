<?php

namespace App\Filament\Exports;

use App\Models\Queue;
use App\Models\Transaksi;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class TransaksiExporter extends Exporter
{
    protected static ?string $model = Queue::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),

            ExportColumn::make('customer.nama')
                ->label('Nama Pelanggan'),

            ExportColumn::make('produk.judul')
                ->label('Produk'),

            ExportColumn::make('produk.harga')
                ->label('Harga Produk')
                ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),

            ExportColumn::make('booking_date')
                ->label('Tanggal Booking')
                ->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->format('d-m-Y')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your transaksi export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
