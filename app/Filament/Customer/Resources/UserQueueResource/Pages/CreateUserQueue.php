<?php

namespace App\Filament\Customer\Resources\UserQueueResource\Pages;

use App\Filament\Customer\Resources\UserQueueResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUserQueue extends CreateRecord
{
    protected static string $resource = UserQueueResource::class;
}
