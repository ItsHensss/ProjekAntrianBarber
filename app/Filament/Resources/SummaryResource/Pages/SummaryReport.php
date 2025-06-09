<?php

namespace App\Filament\Resources\SummaryResource\Pages;

use App\Filament\Resources\SummaryResource;
use App\Models\Queue;
use Filament\Resources\Pages\Page;

class SummaryReport extends Page
{
    protected static string $resource = SummaryResource::class;
    protected static string $view = 'filament.resources.summary-resource.pages.summary-report';

    public $data = [];

    public function mount(): void
    {
        $this->data = $this->getSummaryData();
    }

    protected function getSummaryData()
    {
        $dates = ['2025-06-06', '2025-06-07'];

        $queues = Queue::with(['user', 'produk'])
            ->whereIn('booking_date', $dates)
            ->get();

        $summary = [];

        foreach ($queues as $queue) {
            $name = $queue->user->name ?? '-';
            $layanan = $queue->produk->judul ?? '-';
            $date = $queue->booking_date;

            if (!isset($summary[$name])) {
                $summary[$name] = [];
            }

            if (!isset($summary[$name][$layanan])) {
                $summary[$name][$layanan] = array_fill_keys($dates, 0);
            }

            $summary[$name][$layanan][$date]++;
        }

        // Hitung total
        foreach ($summary as $name => $layanans) {
            foreach ($layanans as $layanan => $tanggal) {
                $summary[$name][$layanan]['total'] = array_sum($tanggal);
            }
        }

        return [
            'dates' => $dates,
            'summary' => $summary,
        ];
    }
}
