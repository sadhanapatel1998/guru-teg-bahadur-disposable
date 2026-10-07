<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'image',
        'meta_title', 'meta_description', 'is_active', 'sort_order',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function category(): BelongsTo  { return $this->belongsTo(Category::class); }

    // Many-to-many: every product assigned to this subcategory (via product_subcategory pivot).
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_subcategory')->withTimestamps();
    }

    // Legacy: products whose single/primary subcategory_id points to this subcategory.
    public function primaryProducts(): HasMany { return $this->hasMany(Product::class); }
    public function getImageUrlAttribute(): string
    {
        return $this->image ? asset('public/storage/' . $this->image) : asset('images/no-image.png');
    }
    public function scopeActive($q) { return $q->where('is_active', true); }
}
