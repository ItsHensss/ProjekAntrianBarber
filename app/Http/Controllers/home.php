<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class home extends Controller
{
    public function index()
    {
        $fotoPotongans = \App\Models\FotoPotongan::all();

        $jamOperational = \App\Models\Operational::all();

        $lokasiCabang = \App\Models\Lokasi::all();

        $fotokategoris = \App\Models\Kategori::all();

        // Kirim data ke view 'home'
        return view('home', [
            'fotoPotongans' => $fotoPotongans,
            'fotokategoris' => $fotokategoris,
            'jamOperational' => $jamOperational,
            'lokasiCabang' => $lokasiCabang,
        ]);
    }
}
