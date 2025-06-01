<?php

namespace App\Filament\Resources\StatsHarianResource\Widgets;

use App\Models\Queue;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class StatsHarian extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        $filters = $this->filters ?? [];

        $query = Queue::query();

        if (!empty($filters['tenant_id'])) {
            $query->where('queues.tenant_id', $filters['tenant_id']);
        }

        if (!empty($filters['startDate'])) {
            $query->whereDate('queues.booking_date', '>=', $filters['startDate']);
        }

        if (!empty($filters['endDate'])) {
            $query->whereDate('queues.booking_date', '<=', $filters['endDate']);
        }

        $jumlahAntrian = (clone $query)->count();
        $jumlahSelesai = (clone $query)->where('status', 'selesai')->count();

        $pendapatan = (clone $query)
            ->where('status', 'selesai')
            ->join('produks', 'queues.produk_id', '=', 'produks.id')
            ->sum('produks.harga');

        // dd($jumlahAntrian);

        return [
            Stat::make('<span style="color:#007bff;">Total Antrian</span>', $jumlahAntrian)
                ->description('Seluruh antrian')
                ->html(),
            Stat::make('<span style="color:#28a745;">Antrian Selesai</span>', $jumlahSelesai)
                ->description('Status selesai')
                ->html(),
            Stat::make('<span style="color:#ffc107;">Pendapatan</span>', 'Rp ' . number_format($pendapatan, 0, ',', '.'))
                ->description('Dari antrian selesai/filter')
                ->html(),
        ];
    }
}
