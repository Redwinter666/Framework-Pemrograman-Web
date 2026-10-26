<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
public function index()
{
    $products = Product::with('Category')->latest()->paginate(10);

    return view('master-data.product.index', compact('products'));
}

public function create()
{
    $categories = Category::orderBy('name')->get();
    return view('master-data.product.create', compact('categories'));
}

public function store(StoreProductRequest $request)
{
    product::create($request->validated());

    return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
}


    public function show(string $id)
    {
        return "Ini halaman detail Produk dengan ID: " . $id;
    }

 public function edit(Product $product)
{
    $categories = Category::orderBy('name')->get();
    return view('master-data.product.edit', compact('product', 'categories'));
}

public function update(UpdateProductRequest $request, Product $product)
{
    $product->update($request->validated());

    return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
}
public function destroy(Product $product)
{
    $product->delete();

    return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
}
}
