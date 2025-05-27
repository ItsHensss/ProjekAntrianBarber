<?php

namespace App\Filament\Resources\OperationalResource\Pages;

use App\Filament\Resources\OperationalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOperational extends EditRecord
{
    protected static string $resource = OperationalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
