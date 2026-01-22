<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'seller_payout_id',
        'method',
        'provider',
        'amount',
        'status',
        'va_number',
        'qris_payload',
        'reference',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function sellerPayout()
    {
        return $this->belongsTo(UserPayout::class, 'seller_payout_id');
    }
}
