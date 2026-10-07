<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'avatar', 'dob', 'gender',
        'is_active', 'google_id', 'otp', 'otp_expires_at',
        'email_verified_at', 'phone_verified_at',
    ];

    protected $hidden = ['password', 'remember_token', 'otp'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'otp_expires_at'    => 'datetime',
        'dob'               => 'date',
        'is_active'         => 'boolean',
        'password'          => 'hashed',
    ];

    // Relations
    public function addresses(): HasMany  { return $this->hasMany(Address::class); }
    public function defaultAddress(): HasOne { return $this->hasOne(Address::class)->where('is_default', true); }
    public function orders(): HasMany    { return $this->hasMany(Order::class); }
    public function cart(): HasMany      { return $this->hasMany(Cart::class); }
    public function wishlists(): HasMany { return $this->hasMany(Wishlist::class); }
    public function reviews(): HasMany   { return $this->hasMany(Review::class); }

    // Helpers
    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? asset('public/storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=2E6F40&color=fff';
    }

    public function isOtpValid(): bool
    {
        return $this->otp && $this->otp_expires_at && $this->otp_expires_at->isFuture();
    }

    public function totalOrders(): int
    {
        return $this->orders()->count();
    }

    public function totalSpent(): float
    {
        return (float) $this->orders()->where('payment_status', 'paid')->sum('total');
    }
}
