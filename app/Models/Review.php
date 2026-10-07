<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model {
    protected $fillable = ['product_id','user_id','order_id','rating','title','body','images','status'];
    protected $casts = ['images' => 'array'];
    public function product(): BelongsTo { return $this->belongsTo(Product::class); }
    public function user(): BelongsTo    { return $this->belongsTo(User::class); }
    public function order(): BelongsTo   { return $this->belongsTo(Order::class); }
    public function scopeApproved($q)    { return $q->where('status', 'approved'); }
}
