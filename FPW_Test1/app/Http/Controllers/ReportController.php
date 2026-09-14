<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Menampilkan halaman laporan penjualan
    public function sales(Request $request)
    {
        return "Ini halaman Laporan Penjualan Toko (Hanya bisa diakses Admin)";
    }
}
