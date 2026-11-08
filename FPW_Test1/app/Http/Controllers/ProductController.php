<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Pertemuan 10: daftar produk dengan pencarian, filter kategori,
     * dan pagination yang mempertahankan query string.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $keyword = $request->search;

            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('code', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('master-data.product.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('master-data.product.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated());

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Pertemuan 11: halaman detail produk beserta total terjual
     * dan sepuluh riwayat penjualan terakhir.
     */
    public function show(Product $product)
    {
        $product->load(['transactionDetails.transaction']);

        $totalTerjual = $product->transactionDetails->sum('qty');

        $riwayat = $product->transactionDetails()
            ->with('transaction')
            ->latest()
            ->take(10)
            ->get();

        return view('master-data.product.show', compact('product', 'totalTerjual', 'riwayat'));
    }

    /**
     * Pertemuan 9: form ubah produk memakai Route Model Binding.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('master-data.product.edit', compact('product', 'categories'));
    }

    /**
     * Pertemuan 9: simpan perubahan data produk.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Pertemuan 9: hapus produk. Produk yang sudah punya riwayat
     * transaksi tidak dihapus agar referensi historis tetap aman.
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
        } catch (QueryException $e) {
            return redirect()->route('products.index')
                ->with('error', 'Produk tidak dapat dihapus karena sudah memiliki riwayat transaksi.');
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
