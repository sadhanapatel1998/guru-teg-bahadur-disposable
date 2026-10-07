<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ContactInquiry extends Model {
    protected $fillable = ['name','email','phone','subject','message','status','admin_reply'];
}

class NewsletterSubscriber extends Model {
    protected $fillable = ['email','name','is_active','subscribed_at','unsubscribed_at'];
    protected $casts = ['is_active'=>'boolean','subscribed_at'=>'datetime','unsubscribed_at'=>'datetime'];
}

class ReturnRequest extends Model {
    protected $fillable = ['order_id','user_id','reason','description','images','status','admin_notes','resolved_at'];
    protected $casts = ['images'=>'array','resolved_at'=>'datetime'];
    public function order() { return $this->belongsTo(Order::class); }
    public function user()  { return $this->belongsTo(User::class); }
}

class Setting extends Model {
    protected $fillable = ['key','value','group','label','type'];
    public static function get(string $key, $default = null) {
        $s = static::where('key', $key)->first();
        return $s ? $s->value : $default;
    }
    public static function set(string $key, $value): void {
        static::updateOrCreate(['key'=>$key], ['value'=>$value]);
    }
}
