<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use Illuminate\Http\Response;

class ExportController extends Controller
{
    public function export()
    {
        $fileName = 'transaksi.csv';
        $queues = Queue::with(['customer', 'produk'])->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($queues) {
            $handle = fopen('php://output', 'w');

            // Header CSV
            fputcsv($handle, [
                'ID',
                'Nama Pelanggan',
                'Produk',
                'Harga Produk',
                'Tanggal Booking',
            ]);

            // Isi Data
            foreach ($queues as $item) {
                fputcsv($handle, [
                    $item->id,
                    $item->customer->nama ?? '-',
                    $item->produk->judul ?? '-',
                    'Rp ' . number_format($item->produk->harga ?? 0, 0, ',', '.'),
                    \Carbon\Carbon::parse($item->booking_date)->format('d-m-Y'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
