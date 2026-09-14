<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return "Ini halaman utama Data Produk (Hanya bisa diakses Admin)";
    }

    public function create()
    {
        return "Ini halaman form tambah Produk";
    }

    public function store(Request $request)
    {
        // Logika simpan data produk
    }

    public function show(string $id)
    {
        return "Ini halaman detail Produk dengan ID: " . $id;
    }

    public function edit(string $id)
    {
        return "Ini halaman form edit Produk dengan ID: " . $id;
    }

    public function update(Request $request, string $id)
    {
        // Logika update data produk
    }

    public function destroy(string $id)
    {
        // Logika hapus data produk
    }
}
