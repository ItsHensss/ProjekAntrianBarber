<?php

namespace App\Filament\Resources\StatsHarianResource\Widgets;

use App\Models\Queue;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class StatsHarian extends BaseWidget
{
    protected function getStats(): array
    {
        $filters = $this->filters ?? [];

        $query = Queue::query();

        if (!empty($filters['tenant_id'])) {
            $query->where('tenant_id', $filters['tenant_id']);
        }

        if (!empty($filters['startDate'])) {
            $query->whereDate('booking_date', '>=', $filters['startDate']);
        }

        if (!empty($filters['endDate'])) {
            $query->whereDate('booking_date', '<=', $filters['endDate']);
        }

        $jumlahAntrian = (clone $query)->count();
        $jumlahSelesai = (clone $query)->where('status', 'selesai')->count();

        $pendapatan = (clone $query)
            ->where('status', 'selesai')
            ->join('produks', 'queues.produk_id', '=', 'produks.id')
            ->sum('produks.harga');

        return [
            Stat::make('Total Antrian', $jumlahAntrian)
                ->description('Seluruh antrian'),
            Stat::make('Antrian Selesai', $jumlahSelesai)
                ->description('Status selesai'),
            Stat::make('Pendapatan', 'Rp ' . number_format($pendapatan, 0, ',', '.'))
                ->description('Dari antrian selesai/filter'),
        ];
    }
}
