<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class product extends Model
{
    protected $fillable = [
        'category_id',
        'code',
        'name',
        'unit',
        'price',
        'stock'
    ];
    //

    protected function priceRupiah(): Attribute
{
    return Attribute::make(
        get: fn () => 'Rp ' . number_format($this->price, 0, ',', '.'),
    );
}
}
