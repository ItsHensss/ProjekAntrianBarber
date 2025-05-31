<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class galleryController extends Controller
{
    public function index()
    {
        $cabang = \App\Models\Tenant::all();
        return view('gallery', compact('cabang'));
    }
}