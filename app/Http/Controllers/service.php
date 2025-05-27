<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class service extends Controller
{
    public function index()
    {

        $jamOperational = \App\Models\Operational::all();

        $lokasiCabang = \App\Models\Lokasi::all();

        $fotokategoris = \App\Models\Kategori::with('produks')->get();

        // Kirim data ke view 'home'
        return view('services', [
            'fotokategoris' => $fotokategoris,
            'jamOperational' => $jamOperational,
            'lokasiCabang' => $lokasiCabang,
        ]);
    }
}
