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
            Action::make('Export Transaksi')
                ->url(fn(): string => route('export.transaksi', request()->query()))
                ->openUrlInNewTab()
                ->label('Export Transaksi')
                ->icon('heroicon-o-folder-arrow-down')
                ->color('primary')
                ->url(route('export.transaksi'))
                ->openUrlInNewTab(),
        ];
    }
}
