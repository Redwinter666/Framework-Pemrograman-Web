<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return "Ini halaman utama Data User/Kasir (Hanya bisa diakses Admin)";
    }

    public function create()
    {
        return "Ini halaman form tambah User baru";
    }

    public function store(Request $request)
    {
        // Logika simpan data user
    }

    public function show(string $id)
    {
        return "Ini halaman detail User dengan ID: " . $id;
    }

    public function edit(string $id)
    {
        return "Ini halaman form edit User dengan ID: " . $id;
    }

    public function update(Request $request, string $id)
    {
        // Logika update data user
    }

    public function destroy(string $id)
    {
        // Logika hapus data user
    }
}
