<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// Rute bawaan halaman depan
Route::get('/', function () {
    return view('welcome');
});

// Kode Praktikum: Rute Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Kode Latihan 2: Rute /about tanpa Controller
Route::get('/about', function () {
    return 'Ini adalah profil POS Barokah Mart';
});
