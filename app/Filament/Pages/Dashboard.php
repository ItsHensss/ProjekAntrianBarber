<?php

namespace App\Filament\Pages;

use App\Filament\Resources\StatsHarianResource\Widgets\StatsHarian;
use Filament\Pages\Dashboard as PagesDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\Tenant;

class Dashboard extends PagesDashboard
{
    use HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('tenant_id')
                            ->label('Tenant')
                            ->options(Tenant::all()->pluck('name', 'id'))
                            ->searchable()
                            ->placeholder('Pilih Tenant'),
                        DatePicker::make('startDate')
                            ->label('Tanggal Awal')
                            ->maxDate(fn(Get $get) => $get('endDate') ?: now()),
                        DatePicker::make('endDate')
                            ->label('Tanggal Akhir')
                            ->minDate(fn(Get $get) => $get('startDate') ?: now())
                            ->maxDate(now()),
                    ])
                    ->columns(3),
            ]);
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsHarian::make()->filters($this->filters),
        ];
    }
}
