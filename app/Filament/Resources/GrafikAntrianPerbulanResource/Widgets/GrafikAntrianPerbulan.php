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

        // Terapkan filter tanggal jika ada
        if (!empty($filters['startDate']) && !empty($filters['endDate'])) {
            $query->whereBetween('queues.booking_date', [$filters['startDate'], $filters['endDate']]);
        } elseif (!empty($filters['startDate'])) {
            $query->whereDate('queues.booking_date', '>=', $filters['startDate']);
        } elseif (!empty($filters['endDate'])) {
            $query->whereDate('queues.booking_date', '<=', $filters['endDate']);
        } else {
            // Default: tahun berjalan
            $currentYear = Carbon::now()->year;
            $query->whereYear('queues.booking_date', $currentYear);
        }

        // Ambil data jumlah antrian per bulan
        $antrianPerBulan = $query
            ->selectRaw('MONTH(booking_date) as bulan, COUNT(*) as total')
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