<?php

namespace App\Filament\Customer\Resources\UserQueueResource\Pages;

use App\Filament\Customer\Resources\UserQueueResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserQueue extends EditRecord
{
    protected static string $resource = UserQueueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
