<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class aboutController extends Controller
{
    public function index()
    {
        $cabang = \App\Models\Tenant::all();
        return view('about', compact('cabang'));
    }
}