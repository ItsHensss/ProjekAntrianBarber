<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use Illuminate\Http\Request;

class nomorAntrian extends Controller
{

    public function index()
    {
        return view('nomorAntrian');
    }

    // Ambil data antrian hari ini sebagai JSON untuk AJAX
    public function jsonToday()
    {
        $queues = Queue::with(['customer', 'produk'])
            ->whereDate('booking_date', today())
            ->orderBy('nomor_antrian')
            ->get();

        return response()->json($queues);
    }
}