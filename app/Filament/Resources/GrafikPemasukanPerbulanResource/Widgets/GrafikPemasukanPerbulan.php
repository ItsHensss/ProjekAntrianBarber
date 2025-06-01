<?php

namespace App\Filament\Resources\GrafikPemasukanPerbulanResource\Widgets;

use App\Models\Queue;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class GrafikPemasukanPerbulan extends ChartWidget
{
    protected static ?string $heading = 'Grafik Pemasukan per Bulan';

    protected function getData(): array
    {
        $currentYear = Carbon::now()->year;

        // Ambil data pemasukan per bulan berdasarkan antrian selesai
        $pemasukanPerBulan = Queue::selectRaw('MONTH(booking_date) as bulan, SUM(produks.harga) as total')
            ->join('produks', 'queues.produk_id', '=', 'produks.id')
            ->where('queues.status', 'selesai')
            ->whereYear('booking_date', $currentYear)
            ->groupBy(DB::raw('MONTH(booking_date)'))
            ->orderBy(DB::raw('MONTH(booking_date)'))
            ->pluck('total', 'bulan')
            ->toArray();

        // Susun data agar 12 bulan selalu tampil
        $dataChart = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataChart[] = $pemasukanPerBulan[$i] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Pemasukan (Rp)',
                    'data' => $dataChart,
                    'borderColor' => '#16a34a',
                    'backgroundColor' => 'rgba(22,163,74,0.4)',
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
