<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class galleryController extends Controller
{
    public function index()
    {
        $cabang = \App\Models\Tenant::all();
        $foto_interior = \App\Models\FotoInterior::all();
        //ambil telepon pada lokasi yang pertama saja
        $lokasiPertama = \App\Models\Lokasi::first();
        //masukkan telepon ke dalam format whatsapp seperto wa.me/62...
        if ($lokasiPertama) {
            $lokasiPertama->telepon = 'wa.me/62' . substr($lokasiPertama->telepon, 1);
        } else {
            $lokasiPertama = null; // Jika tidak ada lokasi, set ke null
        }
        return view('gallery', compact('cabang', 'foto_interior', 'lokasiPertama'));
    }
}
