<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PosController extends Controller
{
    // Menampilkan layar utama transaksi kasir
    public function index()
    {
        return "Ini halaman utama Layar Transaksi Kasir (POS)";
    }

    // Menyimpan data transaksi baru saat kasir melakukan checkout
    public function store(Request $request)
    {
        // Logika proses penyimpanan transaksi penjualan
    }
}
