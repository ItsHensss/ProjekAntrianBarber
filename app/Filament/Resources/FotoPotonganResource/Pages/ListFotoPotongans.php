<?php

namespace App\Filament\Resources\FotoPotonganResource\Pages;

use App\Filament\Resources\FotoPotonganResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFotoPotongans extends ListRecords
{
    protected static string $resource = FotoPotonganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
