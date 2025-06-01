<?php

namespace App\Filament\Resources\GrafikAntrianPerbulanResource\Widgets;

use Filament\Widgets\ChartWidget;

class GrafikAntrianPerbulan extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
