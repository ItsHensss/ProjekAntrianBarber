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
        $today = Carbon::today();

        $jumlahAntrian = Queue::count();

        $jumlahSelesai = Queue::where('status', 'selesai')->count();

        $pendapatanHariIni = Queue::where('status', 'selesai')
            ->whereDate('booking_date', $today)
            ->join('produks', 'queues.produk_id', '=', 'produks.id')
            ->sum('produks.harga');

        return [
            Stat::make('Total Antrian', $jumlahAntrian)
                ->description('Seluruh antrian'),
            Stat::make('Antrian Selesai', $jumlahSelesai)
                ->description('Status selesai'),
            Stat::make('Pendapatan Hari Ini', 'Rp ' . number_format($pendapatanHariIni, 0, ',', '.'))
                ->description('Dari antrian selesai hari ini'),
        ];
    }
}
