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

        // Load view dengan data
        $pdf = Pdf::loadView('printAntrian', [
            'queue' => $queue,
            'produk' => $queue->produk,
            'cabang' => $queue->tenant,
        ])->setOptions(['chroot' => public_path()]);

        // Set ukuran kertas dengan lebar 58mm dan panjang 210mm
        $pdf->setPaper([0, 0, 78, 88]); // lebar 58mm, panjang 210mm

        // Return PDF stream
        return $pdf->stream('antrian-' . $queue->nomor_antrian . '.pdf');
    }
}
