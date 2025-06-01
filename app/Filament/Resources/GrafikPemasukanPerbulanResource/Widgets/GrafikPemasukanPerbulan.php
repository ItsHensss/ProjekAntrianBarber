<?php

namespace App\Filament\Resources\GrafikPemasukanPerbulanResource\Widgets;

use App\Models\Queue;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class GrafikPemasukanPerbulan extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Grafik Pemasukan per Bulan';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $filters = $this->filters ?? [];

        $query = Queue::query()
            ->join('produks', 'queues.produk_id', '=', 'produks.id')
            ->where('queues.status', 'selesai');

        // Filter tenant jika ada
        if (!empty($filters['tenant_id'])) {
            $query->where('queues.tenant_id', $filters['tenant_id']);
        }

        // Filter tanggal jika ada
        if (!empty($filters['startDate']) && !empty($filters['endDate'])) {
            $query->whereBetween('queues.booking_date', [$filters['startDate'], $filters['endDate']]);
        } elseif (!empty($filters['startDate'])) {
            $query->whereDate('queues.booking_date', '>=', $filters['startDate']);
        } elseif (!empty($filters['endDate'])) {
            $query->whereDate('queues.booking_date', '<=', $filters['endDate']);
        } else {
            // Default: tahun ini
            $currentYear = now()->year;
            $query->whereYear('queues.booking_date', $currentYear);
        }

        $pemasukanPerBulan = $query
            ->selectRaw('MONTH(queues.booking_date) as bulan, SUM(produks.harga) as total')
            ->groupBy(DB::raw('MONTH(queues.booking_date)'))
            ->orderBy(DB::raw('MONTH(queues.booking_date)'))
            ->pluck('total', 'bulan')
            ->toArray();

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
}