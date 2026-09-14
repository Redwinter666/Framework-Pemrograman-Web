<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return "Ini halaman utama Data Kategori (Hanya bisa diakses Admin)";
    }

    public function create()
    {
        return "Ini halaman form tambah Kategori";
    }

    public function store(Request $request)
    {
        // Logika simpan data kategori
    }

    public function show(string $id)
    {
        return "Ini halaman detail Kategori dengan ID: " . $id;
    }

    public function edit(string $id)
    {
        return "Ini halaman form edit Kategori dengan ID: " . $id;
    }

    public function update(Request $request, string $id)
    {
        // Logika update data kategori
    }

    public function destroy(string $id)
    {
        // Logika hapus data kategori
    }
}
