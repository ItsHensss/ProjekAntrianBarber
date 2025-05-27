<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class booking extends Controller
{
    public function index()
    {
        $fotokategoris = \App\Models\Kategori::with('produks')->get();
        $employees = \App\Models\Employee::all();

        return view('book', [
            'fotokategoris' => $fotokategoris,
            'employees' => $employees,
        ]);
    }
}
