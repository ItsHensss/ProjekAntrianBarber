<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class aboutController extends Controller
{
    public function index()
    {
        $cabang = \App\Models\Tenant::all();
        //ambil telepon pada lokasi yang pertama saja
        $lokasiPertama = \App\Models\Lokasi::first();
        //masukkan telepon ke dalam format whatsapp seperto wa.me/62...
        if ($lokasiPertama) {
            $lokasiPertama->telepon = 'wa.me/62' . substr($lokasiPertama->telepon, 1);
        } else {
            $lokasiPertama = null; // Jika tidak ada lokasi, set ke null
        }
        return view('about', compact('cabang', 'lokasiPertama'));
    }
}
