<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Pegawai Module
Route::get('/pegawai/{take}', [PegawaiController::class, 'allPegawai']);
Route::post('/pegawai/create/', [PegawaiController::class, 'createPegawai']);