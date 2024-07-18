<?php

namespace App\Models;

use App\Observers\CartObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'cookie_id', 'product_id', 'quantity', 'options'];



    protected static function booted()
    {
        static::observe(CartObserver::class);
        static::addGlobalScope('cookie_id', function (Builder $builder) {
            $builder->where('cookie_id', self::getCookieId());
        });
    }

    public static function getCookieId()
    {
        $cookie_id = Cookie::get('cart_id');
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            $expiresAt = Carbon::now()->addDays(30)->diffInMinutes(Carbon::now());
            Cookie::queue('cart_id', $cookie_id, $expiresAt);
        }

        return $cookie_id;
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault(['name' => 'Guest']);
    }


}
