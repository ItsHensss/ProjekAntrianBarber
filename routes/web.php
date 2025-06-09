<?php

use App\Http\Controllers\aboutController;
use App\Http\Controllers\home;
use App\Http\Controllers\pricing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\service;
use App\Http\Controllers\booking;
use App\Http\Controllers\contactController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\galleryController;
use App\Http\Controllers\nomorAntrian;

use App\Http\Controllers\QueueValidationController;


Route::get('/validasi-antrian/{queue}', [QueueValidationController::class, 'show'])->name('validasi.antrian.show');
Route::post('/validasi-antrian/{queue}', [QueueValidationController::class, 'validateQueue'])->name('validasi.antrian.post');

Route::get('/', [home::class, 'index'])->name('home');
Route::get('/about', [aboutController::class, 'index'])->name('about');
Route::get('/gallery', [galleryController::class, 'index'])->name('gallery');
Route::get('/services', [service::class, 'index'])->name('services');
Route::get('/antrian/cabang/{id}', [NomorAntrian::class, 'index'])->name('antrian.cabang');
Route::get('/antrian/today/json/{id}', [NomorAntrian::class, 'jsonToday'])->name('antrian.today.json');
Route::get('/antrian/{queue}/print', [NomorAntrian::class, 'print'])->name('antrian.print');

Route::get('/export-transaksi', [ExportController::class, 'export'])->name('export.transaksi');
