<?php

namespace App\Filament\Resources\TransaksiResource\Pages;

use App\Filament\Resources\TransaksiResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListTransaksis extends ListRecords
{
    protected static string $resource = TransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export-transaksi')
                ->label('Ekspor Transaksi')
                ->icon('heroicon-o-folder-arrow-down')
                ->color('primary')
                ->url(route('export.transaksi'))
                ->openUrlInNewTab(),
        ];
    }
}
