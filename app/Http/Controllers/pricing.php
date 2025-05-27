<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pricing extends Controller
{
    public function index()
    {

        $fotokategoris = \App\Models\Kategori::with('produks')->get();

        // Kirim data ke view 'home'
        return view('pricing', [
            'fotokategoris' => $fotokategoris,
        ]);
    }
}
