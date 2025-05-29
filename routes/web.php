<?php

use App\Http\Controllers\home;
use App\Http\Controllers\pricing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\service;
use App\Http\Controllers\booking;
use App\Http\Controllers\nomorAntrian;

Route::get('/', [home::class, 'index'])->name('home');
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::get('/gallery', function () {
    return view('gallery');
})->name('gallery');
Route::get('/services', [service::class, 'index'])->name('services');
Route::get('/antrian/cabang/{id}', [NomorAntrian::class, 'index'])->name('antrian.cabang');
Route::get('/antrian/today/json/{id}', [NomorAntrian::class, 'jsonToday'])->name('antrian.today.json');
