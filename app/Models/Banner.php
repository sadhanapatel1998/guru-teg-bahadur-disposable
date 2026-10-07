<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'image',
        'mobile_image',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function getImageUrlAttribute(): string
    {
        return asset('public/storage/' . $this->image);
    }

    public function getMobileImageUrlAttribute(): string
    {
        return asset('public/storage/' . $this->mobile_image);
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', true)
                 ->latest();
    }
}