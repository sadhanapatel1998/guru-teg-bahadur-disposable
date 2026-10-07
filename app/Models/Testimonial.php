<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Testimonial extends Model {
    protected $fillable = ['name','designation','avatar','message','rating','is_active','sort_order'];
    protected $casts = ['is_active' => 'boolean'];
    public function getAvatarUrlAttribute(): string {
        return $this->avatar ? asset('public/storage/'.$this->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=2E6F40&color=fff';
    }
    public function scopeActive($q) { return $q->where('is_active', true)->orderBy('sort_order'); }
}
