<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'admin_id', 'blog_category_id', 'title', 'slug', 'excerpt',
        'body', 'thumbnail', 'tags', 'status', 'meta_title',
        'meta_description', 'views', 'published_at',
    ];

    protected $casts = [
        'tags'         => 'array',
        'published_at' => 'datetime',
    ];

    public function admin(): BelongsTo        { return $this->belongsTo(Admin::class); }
    public function blogCategory(): BelongsTo { return $this->belongsTo(BlogCategory::class); }
    public function category(): BelongsTo     { return $this->belongsTo(BlogCategory::class, 'blog_category_id'); }

    public function getThumbnailUrlAttribute(): string
    {
        return $this->thumbnail ? asset('public/storage/' . $this->thumbnail) : asset('images/no-image.png');
    }

    public function scopePublished($q) { return $q->where('status', 'published'); }
}
