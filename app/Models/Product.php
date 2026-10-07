<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'subcategory_id', 'name', 'slug', 'sku', 'barcode',
        'short_description', 'description', 'price', 'sale_price', 'cost_price',
        'stock', 'low_stock_threshold', 'manage_stock', 'thumbnail', 'status',
        'is_featured', 'is_trending', 'is_new_arrival', 'is_best_seller', 'is_on_sale',
        'tax_rate', 'weight', 'dimensions', 'meta_title', 'meta_description',
        'meta_keywords', 'tags', 'views',
    ];

    protected $casts = [
        'price'       => 'decimal:2',
        'sale_price'  => 'decimal:2',
        'cost_price'  => 'decimal:2',
        'tax_rate'    => 'decimal:2',
        'weight'      => 'decimal:2',
        'tags'        => 'array',
        'is_featured' => 'boolean',
        'is_trending' => 'boolean',
        'is_new_arrival' => 'boolean',
        'is_best_seller' => 'boolean',
        'is_on_sale'  => 'boolean',
        'manage_stock' => 'boolean',
    ];

    // Relations
    public function category(): BelongsTo    { return $this->belongsTo(Category::class); }
    public function subcategory(): BelongsTo { return $this->belongsTo(Subcategory::class); }

    // Many-to-many: a product can belong to multiple categories / subcategories.
    // The original category()/subcategory() above still point to the "primary"
    // category/subcategory (kept for backward compatibility with existing views).
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_category')->withTimestamps();
    }

    public function subcategories(): BelongsToMany
    {
        return $this->belongsToMany(Subcategory::class, 'product_subcategory')->withTimestamps();
    }

    public function images(): HasMany        { return $this->hasMany(ProductImage::class)->orderBy('sort_order'); }
    public function primaryImage(): HasMany  { return $this->hasMany(ProductImage::class)->where('is_primary', true); }
    public function variants(): HasMany      { return $this->hasMany(ProductVariant::class)->where('is_active', true); }
    // Unscoped — used by the admin panel so inactive variants can still be edited/reactivated.
    public function allVariants(): HasMany   { return $this->hasMany(ProductVariant::class); }
    public function reviews(): HasMany       { return $this->hasMany(Review::class)->where('status', 'approved'); }
    public function orderItems(): HasMany    { return $this->hasMany(OrderItem::class); }

    // Computed
    public function getEffectivePriceAttribute(): float
    {
        return (float) ($this->sale_price && $this->sale_price < $this->price
            ? $this->sale_price : $this->price);
    }

    public function getDiscountPercentAttribute(): int
    {
        if ($this->sale_price && $this->sale_price < $this->price) {
            return (int) round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }

    public function getThumbnailUrlAttribute(): string
    {
        return $this->thumbnail
            ? asset('public/storage/' . $this->thumbnail)
            : asset('images/no-image.png');
    }

    public function getAvgRatingAttribute(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function isInStock(): bool
    {
        return !$this->manage_stock || $this->stock > 0;
    }

    public function isLowStock(): bool
    {
        return $this->manage_stock && $this->stock <= $this->low_stock_threshold && $this->stock > 0;
    }

    // Scopes
    public function scopeActive($q)    { return $q->where('status', 'active'); }
    public function scopeFeatured($q)  { return $q->where('is_featured', true); }
    public function scopeTrending($q)  { return $q->where('is_trending', true); }
    public function scopeNewArrivals($q) { return $q->where('is_new_arrival', true)->latest(); }
    public function scopeBestSellers($q) { return $q->where('is_best_seller', true); }
    public function scopeOnSale($q)    { return $q->where('is_on_sale', true)->whereNotNull('sale_price'); }
}
