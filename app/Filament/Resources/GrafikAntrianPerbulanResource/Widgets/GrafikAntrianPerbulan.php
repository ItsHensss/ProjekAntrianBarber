<?php

namespace App\Filament\Resources\GrafikAntrianPerbulanResource\Widgets;

use App\Models\Queue;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class GrafikAntrianPerbulan extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Grafik Antrian per Bulan';

    protected function getData(): array
    {
        $filters = $this->filters ?? [];
        $query = Queue::query();

        // Terapkan filter tenant jika ada
        if (!empty($filters['tenant_id'])) {
            $query->where('queues.tenant_id', $filters['tenant_id']);
        }

        // Jika filter tanggal diisi, gunakan range filter
        if (!empty($filters['startDate']) && !empty($filters['endDate'])) {
            $startDate = Carbon::parse($filters['startDate']);
            $endDate = Carbon::parse($filters['endDate']);
            $query->whereBetween('queues.booking_date', [$startDate->toDateString(), $endDate->toDateString()]);
        } else {
            // Default: bulan berjalan
            $now = Carbon::now();
            $startDate = $now->copy()->startOfMonth();
            $endDate = $now->copy()->endOfMonth();
            $query->whereBetween('queues.booking_date', [$startDate->toDateString(), $endDate->toDateString()]);
        }

        // Ambil data jumlah antrian per hari
        $antrianPerHari = $query
            ->selectRaw('DAY(booking_date) as hari, COUNT(*) as total')
            ->groupBy(DB::raw('DAY(booking_date)'))
            ->orderBy(DB::raw('DAY(booking_date)'))
            ->pluck('total', 'hari')
            ->toArray();

        // Siapkan data lengkap untuk range hari
        $labels = [];
        $dataChart = [];
        $period = new \DatePeriod($startDate, new \DateInterval('P1D'), $endDate->copy()->addDay());
        foreach ($period as $date) {
            $day = (int)$date->format('j');
            $labels[] = $date->format('d M');
            $dataChart[] = $antrianPerHari[$day] ?? 0;
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
            'labels' => $labels,
        ];
    }


    protected function getType(): string
    {
        return 'line';
    }
}