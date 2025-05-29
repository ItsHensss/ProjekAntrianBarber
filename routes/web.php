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
Route::get('/book', [booking::class, 'index'])->name('book');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::get('/gallery', function () {
    return view('gallery');
})->name('gallery');
Route::get('/pricing', [pricing::class, 'index'])->name('pricing');
Route::get('/services', [service::class, 'index'])->name('services');
Route::get('/antrian', [nomorAntrian::class, 'index'])->name('antrian');
Route::get('/antrian/today/json', [nomorAntrian::class, 'jsonToday'])->name('antrian.today.json');