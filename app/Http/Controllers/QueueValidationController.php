<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QueueValidationController extends Controller
{
    public function show(Queue $queue)
    {
        // Memuat produk yang berelasi dengan queue
        $produk = $queue->produk; // pastikan relasi 'produk' ada di model Queue

        return view('validasi', compact('queue', 'produk'));
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

        return redirect()->route('validasi.antrian.show', $queue->id)
            ->with('success', 'Antrian berhasil divalidasi oleh chapster.');
    }
}
