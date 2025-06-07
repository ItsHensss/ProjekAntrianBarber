<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Tenant;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class nomorAntrian extends Controller
{

    public function index($id)
    {
        $cabang = Tenant::with('lokasi')->findOrFail($id);
        return view('nomorAntrian', compact('cabang'));
    }

    public function jsonToday($id)
    {
        $queues = Queue::with(['customer', 'produk'])
            ->whereDate('booking_date', today())
            ->where('tenant_id', $id)
            ->orderBy('nomor_antrian')
            ->get();

        if ($queues->isEmpty()) {
            return response()->json(0);
        }

        return response()->json($queues);
    }

    public function print($id)
    {
        $queue = Queue::with(['produk', 'customer', 'tenant.lokasi'])->findOrFail($id);

        $pdf = Pdf::loadView('printAntrian', [
            'queue' => $queue,
            'produk' => $queue->produk,
            'cabang' => $queue->tenant,
        ])->setOptions(['chroot' => public_path()]);

        // Ukuran kertas POS58: lebar 58mm, panjang fleksibel (misal 100mm)
        $pdf->setPaper([0, 0, 164.57, 283.46]); // 58mm x 100mm (1 mm = 2.8346 point)

        return $pdf->stream('antrian-' . $queue->nomor_antrian . '.pdf');
    }
}