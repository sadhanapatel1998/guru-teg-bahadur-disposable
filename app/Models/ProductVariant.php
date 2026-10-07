<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id', 'sku', 'size', 'color', 'color_hex',
        'attributes', 'price', 'sale_price', 'stock', 'image', 'is_active',
    ];

    protected $casts = [
        'attributes' => 'array',
        'price'      => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_active'  => 'boolean',
    ];

    public function product(): BelongsTo { return $this->belongsTo(Product::class); }

    public function getLabelAttribute(): string
    {
        $parts = array_filter([$this->color, $this->size]);
        return implode(' / ', $parts) ?: $this->sku;
    }

    public function getEffectivePriceAttribute(): float
    {
        if ($this->price) {
            return (float) ($this->sale_price && $this->sale_price < $this->price
                ? $this->sale_price : $this->price);
        }
        return (float) ($this->product?->effective_price ?? 0.0);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('public/storage/' . $this->image) : null;
    }
}
