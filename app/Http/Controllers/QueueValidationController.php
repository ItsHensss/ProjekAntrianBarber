<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class QueueValidationController extends Controller
{
    public function show($encrypted)
    {
        try {
            $id = Crypt::decryptString($encrypted);
        } catch (\Exception $e) {
            abort(404);
        }

        $queue = Queue::findOrFail($id);

        // Memuat produk yang berelasi dengan queue
        $produk = $queue->produk; // pastikan relasi 'produk' ada di model Queue
        $cabang = $queue->tenant; // pastikan relasi 'tenant' ada di model Queue

        return view('validasi', compact('queue', 'produk', 'cabang'));
    }

    public function validateQueue(Request $request, Queue $queue)
    {
        // Cek apakah user login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login sebagai chapster untuk memvalidasi antrian.');
        }

        // Update status antrian
        $queue->update([
            'status' => 'selesai',
            'is_validated' => true,
            'user_id' => Auth::id(),
        ]);

        // Ambil nama cabang dari relasi tenant
        $tenant = $queue->tenant; // pastikan relasi 'tenant' ada di model Queue
        $namaCabang = $tenant->slug;

        // Kirim URL kembali ke halaman antrian dan nama cabang ke view
        $backUrl = url("/admin/{$namaCabang}/antrian");

        return redirect()->route('validasi.antrian.show', $queue->id)
            ->with([
                'success' => 'Antrian berhasil divalidasi oleh chapster.',
                'back_url' => $backUrl,
                'nama_cabang' => $namaCabang,
            ]);
    }
}
