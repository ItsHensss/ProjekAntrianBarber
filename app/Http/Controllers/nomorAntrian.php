<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Tenant;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Crypt;
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

        // Enkripsi ID
        $encrypted = Crypt::encryptString($queue->id);

        // Buat URL terenkripsi
        $qrUrl = route('antrian.qr.decrypt', ['encrypted' => $encrypted]);

        // Generate QRCode
        $qrCodeImage = QrCode::format('png')->size(100)->generate($qrUrl);
        $qrCode = 'data:image/png;base64,' . base64_encode($qrCodeImage);


        // Load view
        $pdf = Pdf::loadView('printAntrian', [
            'queue' => $queue,
            'produk' => $queue->produk,
            'cabang' => $queue->tenant,
            'qrCode' => $qrCode, // Kirim ke view
        ])->setOptions(['chroot' => public_path()]);

        $pdf->setPaper([0, 0, 78, 88]);

        return $pdf->stream('antrian-' . $queue->nomor_antrian . '.pdf');
    }
}
