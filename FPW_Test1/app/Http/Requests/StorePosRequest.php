<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePosRequest extends FormRequest
{
    /**
     * Admin dan kasir boleh menyimpan transaksi penjualan.
     */
    public function authorize(): bool
    {
        return auth()->check()
            && in_array(auth()->user()->role, ['admin', 'kasir'], true);
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'pay' => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'Keranjang belanja masih kosong.',
            'items.min' => 'Pilih minimal satu produk untuk ditransaksikan.',
            'items.*.product_id.exists' => 'Produk yang dipilih tidak ditemukan.',
            'items.*.qty.min' => 'Jumlah produk minimal 1.',
            'pay.required' => 'Nominal pembayaran wajib diisi.',
        ];
    }
}
