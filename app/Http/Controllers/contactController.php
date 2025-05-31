<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class contactController extends Controller
{
    public function index()
    {
        $cabang = \App\Models\Tenant::all();
        return view('contact', compact('cabang'));
    }
}