<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Queue;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;

class SummaryExportController extends Controller
{
    public function export(Request $request)
    {
        $from = Carbon::parse($request->input('from'))->startOfDay();
        $until = Carbon::parse($request->input('until'))->endOfDay();

        $dates = [];
        $period = new \DatePeriod(
            $from,
            new \DateInterval('P1D'),
            $until->copy()->addDay()
        );

        $queues = Queue::with(['user', 'produk'])
            ->whereBetween('booking_date', [$from->format('Y-m-d'), $until->format('Y-m-d')])
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

        foreach ($summary as $name => $layanans) {
            foreach ($layanans as $layanan => $tanggal) {
                $summary[$name][$layanan]['total'] = array_sum($tanggal);
            }
        }

        $data = [
            'from' => $from->format('Y-m-d'),
            'until' => $until->format('Y-m-d'),
            'dates' => $dates,
            'summary' => $summary,
        ];

        $pdf = FacadePdf::loadView('exports.summary', $data)->setPaper('A4', 'landscape');
        return $pdf->stream("Laporan_Ringkasan_{$from->format('Ymd')}_{$until->format('Ymd')}.pdf");
    }
}
