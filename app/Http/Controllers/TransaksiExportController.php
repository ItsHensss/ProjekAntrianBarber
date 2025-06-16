<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class TransaksiExportController extends Controller
{
    public function export(Request $request)
    {
        $from = Carbon::parse($request->input('from'))->startOfDay();
        $until = Carbon::parse($request->input('until'))->startOfDay();

        $data = Queue::with(['user', 'produk', 'customer'])
            ->whereBetween('booking_date', [$from->toDateString(), $until->subDay()->toDateString()])
            ->orderBy('booking_date', 'asc')
            ->get();

        $pdf = Pdf::loadView('exports.transaksi', [
            'data' => $data,
            'from' => $from->toDateString(),
            'until' => $until->subDay()->toDateString(),
        ])->setPaper('A4', 'landscape');

        return $pdf->stream("Laporan_Transaksi_{$from->format('Ymd')}_{$until->subDay()->format('Ymd')}.pdf");
    }
}
