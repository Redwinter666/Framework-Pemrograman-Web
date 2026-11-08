<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Hanya admin yang boleh mengubah data produk.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Aturan validasi untuk memperbarui produk.
     * Unique code mengecualikan produk yang sedang diedit.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'code' => 'required|string|max:20|unique:products,code,' . $this->route('product')->id,
            'name' => 'required|string|max:150',
            'unit' => 'required|string|max:20',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'code.unique' => 'Kode produk sudah digunakan, gunakan kode lain.',
        ];
    }
}
