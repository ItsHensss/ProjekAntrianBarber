<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Tenant;
use Illuminate\Http\Request;

class nomorAntrian extends Controller
{

    public function index($id)
    {
        $cabang = Tenant::findOrFail($id);
        return view('nomorAntrian', compact('cabang'));
    }

    public function jsonToday($id)
    {
        $queues = Queue::with(['customer', 'produk'])
            ->whereDate('booking_date', today())
            ->where('cabang_id', $id)
            ->orderBy('nomor_antrian')
            ->get();

        return response()->json($queues);
    }
}
