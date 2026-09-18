<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PosController;
use app\Http\Controllers\ReportController;
// Rute bawaan halaman depan
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/about', function () {
    return 'Ini adalah profil POS Barokah Mart';
});

Route::get('/login', [LoginController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [LoginController::class, 'store'])
    ->middleware('guest')
    ->name('login.store');

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');


Route::middleware(['auth', 'role:admin,kasir'])->group(function () {
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos', [PosController::class, 'store'])->name('pos.store');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('users', UserController::class);
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('report.sales');
});

Route::get('/index', function(){
    $posts = [
        (object)['title'=> 'belajar blade pro', 'published' => true],
        (object)['title'=> 'tidak belajar blade pro', 'unpublished' => false],
        (object)['title'=> 'tolong belajar blade pro', 'post_published' => true],
        (object)['created_at'=> 241016728]
    ];
    return view('posts.index', compact('posts'));
});

Route::get('/pos/history', function () {
    return "Ini halaman riwayat transaksi khusus kasir";
})->name('pos.history');
