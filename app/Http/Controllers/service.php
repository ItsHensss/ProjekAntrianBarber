<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class service extends Controller
{
    public function index()
    {

        $jamOperational = \App\Models\Operational::all();

        $lokasiCabang = \App\Models\Lokasi::all();

        // ambil data produk
        $produk = \App\Models\Produk::where('tenant_id', 1)->get();

        // Kirim data ke view 'home'
        return view('services', [
            'produk' => $produk,
            'jamOperational' => $jamOperational,
            'lokasiCabang' => $lokasiCabang,
        ]);
    }
}
