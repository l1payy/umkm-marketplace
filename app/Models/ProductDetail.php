<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'sku',
        'material',
        'care_label',
        'specs',
        'long_description',
    ];

    protected $casts = [
        'specs' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

