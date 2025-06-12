<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class service extends Controller
{
    public function index()
    {

        $jamOperational = \App\Models\Operational::all();

        $lokasiCabang = \App\Models\Lokasi::all();
        $cabang = \App\Models\Tenant::all();

        //ambil telepon pada lokasi yang pertama saja
        $lokasiPertama = \App\Models\Lokasi::first();
        //masukkan telepon ke dalam format whatsapp seperto wa.me/62...
        if ($lokasiPertama) {
            $lokasiPertama->telepon = 'wa.me/62' . substr($lokasiPertama->telepon, 1);
        } else {
            $lokasiPertama = null; // Jika tidak ada lokasi, set ke null
        }


        // ambil data produk
        $produk = \App\Models\Produk::where('tenant_id', 1)->get();

        // Kirim data ke view 'home'
        return view('services', [
            'cabang' => $cabang,
            'lokasiPertama' => $lokasiPertama,
            'produk' => $produk,
            'jamOperational' => $jamOperational,
            'lokasiCabang' => $lokasiCabang,
        ]);
    }
}