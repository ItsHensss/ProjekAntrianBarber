<?php

namespace App\Filament\Resources\FotoInteriorResource\Pages;

use App\Filament\Resources\FotoInteriorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFotoInteriors extends ListRecords
{
    protected static string $resource = FotoInteriorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
