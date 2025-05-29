<?php

namespace App\Filament\Resources\TransaksiResource\Pages;

use App\Filament\Exports\TransaksiExporter;
use App\Filament\Resources\TransaksiResource;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListTransaksis extends ListRecords
{
    protected static string $resource = TransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            ExportAction::make()
                ->exporter(TransaksiExporter::class)
                ->label('Ekspor Transaksi')
                ->icon('heroicon-o-folder-arrow-down')
                ->color('primary')
        ];
    }
}
