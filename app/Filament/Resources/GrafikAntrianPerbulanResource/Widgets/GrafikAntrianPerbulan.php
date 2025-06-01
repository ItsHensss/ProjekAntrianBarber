<?php

namespace App\Filament\Resources\GrafikAntrianPerbulanResource\Widgets;

use App\Models\Queue;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class GrafikAntrianPerbulan extends ChartWidget
{
    protected static ?string $heading = 'Grafik Antrian per Bulan';

    protected function getData(): array
    {
        // Ambil tahun sekarang
        $currentYear = Carbon::now()->year;

        // Ambil data jumlah antrian per bulan di tahun ini
        $antrianPerBulan = Queue::selectRaw('MONTH(booking_date) as bulan, COUNT(*) as total')
            ->whereYear('booking_date', $currentYear)
            ->groupBy(DB::raw('MONTH(booking_date)'))
            ->orderBy(DB::raw('MONTH(booking_date)'))
            ->pluck('total', 'bulan')
            ->toArray();

        // Siapkan data lengkap untuk 12 bulan
        $dataChart = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataChart[] = $antrianPerBulan[$i] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Antrian',
                    'data' => $dataChart,
                    'borderColor' => '#4f46e5',
                    'backgroundColor' => 'rgba(79,70,229,0.4)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'Mei',
                'Jun',
                'Jul',
                'Agu',
                'Sep',
                'Okt',
                'Nov',
                'Des'
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}