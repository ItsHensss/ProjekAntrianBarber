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


        //ambil telepon pada lokasi yang pertama saja
        $lokasiPertama = \App\Models\Lokasi::first();
        //masukkan telepon ke dalam format whatsapp seperto wa.me/62...
        if ($lokasiPertama) {
            $lokasiPertama->telepon = 'wa.me/62' . substr($lokasiPertama->telepon, 1);
        } else {
            $lokasiPertama = null; // Jika tidak ada lokasi, set ke null
        }

        // Kirim data ke view 'home'
        return view('home', [
            'cabang' => $cabang,
            'fotoPotongans' => $fotoPotongans,
            'lokasiPertama' => $lokasiPertama,
            'jamOperational' => $jamOperational,
            'lokasiCabang' => $lokasiCabang,
        ]);
    }
}