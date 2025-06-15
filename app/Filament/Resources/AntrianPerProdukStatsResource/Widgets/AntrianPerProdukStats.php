<?php

namespace App\Filament\Resources\AntrianPerProdukStatsResource\Widgets;

use App\Models\Queue;
use App\Models\Produk;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\Auth;

class AntrianPerProdukStats extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        $filters = $this->filters ?? [];

        // Ambil tenant ID dari filter atau fallback ke Auth
        $tenantId = $filters['tenant_id'] ?? Auth::user()->tenant_id ?? null;

        if (!$tenantId) {
            return [
                Stat::make('Tidak Ada Tenant', '0')
                    ->description('Silakan pilih tenant terlebih dahulu')
                    ->color('gray'),
            ];
        }

        // Ambil semua produk milik tenant terkait
        $produks = Produk::where('tenant_id', $tenantId)->get();

        $stats = [];

        foreach ($produks as $produk) {
            $query = Queue::query()
                ->where('status', 'selesai')
                ->where('produk_id', $produk->id)
                ->where('tenant_id', $tenantId);

            // Terapkan filter tanggal
            if (!empty($filters['startDate']) && !empty($filters['endDate'])) {
                $query->whereBetween('booking_date', [
                    Carbon::parse($filters['startDate'])->startOfDay(),
                    Carbon::parse($filters['endDate'])->endOfDay(),
                ]);
            } elseif (!empty($filters['startDate'])) {
                $query->whereDate('booking_date', '>=', Carbon::parse($filters['startDate'])->startOfDay());
            } elseif (!empty($filters['endDate'])) {
                $query->whereDate('booking_date', '<=', Carbon::parse($filters['endDate'])->endOfDay());
            }

            $count = $query->count();

            $stats[] = Stat::make($produk->judul, "{$count} selesai")
                ->description("Antrian selesai untuk produk ini")
                ->color('success');
        }

        return $stats;
    }
}
