<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Tenant;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;

class RegisterTeam extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register team';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('slug')->required()->maxLength(255)->unique(
                    Tenant::class,
                    'slug',
                    fn($record) => $record ? $record->id : null
                )->label('Slug'),
            ]);
    }

    protected function handleRegistration(array $data): Tenant
    {
        $team = Tenant::create($data);

        $team->users()->attach(auth()->user());

        return $team;
    }
}
