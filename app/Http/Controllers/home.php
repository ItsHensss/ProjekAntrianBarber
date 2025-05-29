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

        // ambil data seluruh cabang di table tenant
        $cabang = \App\Models\Tenant::all();

        // Kirim data ke view 'home'
        return view('home', [
            'cabang' => $cabang,
            'fotoPotongans' => $fotoPotongans,
            'jamOperational' => $jamOperational,
            'lokasiCabang' => $lokasiCabang,
        ]);
    }
}
