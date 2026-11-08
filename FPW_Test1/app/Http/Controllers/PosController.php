<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePosRequest;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    /**
     * Pertemuan 12: tampilkan produk yang stoknya masih tersedia.
     */
    public function index()
    {
        $products = Product::where('stock', '>', 0)
            ->orderBy('name')
            ->get(['id', 'code', 'name', 'price', 'stock', 'unit']);

        return view('pos.index', compact('products'));
    }

    /**
     * Pertemuan 12: simpan transaksi penjualan secara atomik.
     */
    public function store(StorePosRequest $request)
    {
        try {
            $transaction = DB::transaction(function () use ($request) {
                $total = 0;
                $details = [];

                foreach ($request->items as $item) {
                    // Kunci baris produk agar stok tidak dibaca ganda oleh kasir lain.
                    $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                    if ($product->stock < $item['qty']) {
                        throw new \Exception("Stok {$product->name} tidak mencukupi.");
                    }

                    $subtotal = $product->price * $item['qty'];
                    $total += $subtotal;

                    $details[] = [
                        'product_id' => $product->id,
                        'qty' => $item['qty'],
                        'price' => $product->price,
                        'subtotal' => $subtotal,
                    ];

                    $product->decrement('stock', $item['qty']);
                }

                if ($request->pay < $total) {
                    throw new \Exception('Nominal bayar kurang dari total belanja.');
                }

                $trx = Transaction::create([
                    'invoice_number' => 'INV-' . now()->format('Ymd') . '-' . str_pad(
                        Transaction::whereDate('created_at', now())->count() + 1,
                        4,
                        '0',
                        STR_PAD_LEFT
                    ),
                    'user_id' => auth()->id(),
                    'total' => $total,
                    'pay' => $request->pay,
                    'change' => $request->pay - $total,
                ]);

                $trx->details()->createMany($details);

                return $trx;
            });
        } catch (\Exception $e) {
            return redirect()->route('pos.index')
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('pos.struk', $transaction)
            ->with('success', 'Transaksi berhasil disimpan.');
    }

    /**
     * Pertemuan 12: halaman struk sebagai konfirmasi transaksi.
     */
    public function struk(Transaction $transaction)
    {
        $transaction->load('details.product', 'user');

        return view('pos.struk', compact('transaction'));
    }
}
