<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'description', 'image', 'icon',
        'meta_title', 'meta_description', 'meta_keywords',
        'is_active', 'is_featured', 'sort_order',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function subcategories(): HasMany { return $this->hasMany(Subcategory::class)->where('is_active', true); }

    // Many-to-many: every product assigned to this category (via product_category pivot),
    // including products that also belong to other categories. Used for listing/counting.
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_category')->withTimestamps();
    }

    // Legacy: products whose single/primary category_id points to this category.
    // Kept for backward compatibility, not used by default anywhere anymore.
    public function primaryProducts(): HasMany { return $this->hasMany(Product::class); }
    public function getImageUrlAttribute(): string
    {
        return $this->image ? asset('public/storage/' . $this->image) : asset('images/no-image.png');
    }

    public function scopeActive($q)  { return $q->where('is_active', true); }
    public function scopeFeatured($q){ return $q->where('is_featured', true); }
}
