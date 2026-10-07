<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id', 'user_id', 'payment_id', 'razorpay_order_id',
        'razorpay_signature', 'method', 'status', 'amount', 'currency',
        'gateway_response', 'refund_id', 'refund_amount', 'paid_at',
    ];

    protected $casts = [
        'amount'           => 'decimal:2',
        'refund_amount'    => 'decimal:2',
        'gateway_response' => 'array',
        'paid_at'          => 'datetime',
    ];

    public function order(): BelongsTo { return $this->belongsTo(Order::class); }
    public function user(): BelongsTo  { return $this->belongsTo(User::class); }
}
