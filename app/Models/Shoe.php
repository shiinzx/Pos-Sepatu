<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shoe extends Model
{
    protected $fillable = [
        'category_id', 'promo_id', 'name', 'brand', 'size', 'price', 'stock', 'description', 'image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }

    public function getDiscountedPriceAttribute()
    {
        if ($this->promo && now()->between($this->promo->start_date, $this->promo->end_date)) {
            $discountAmount = ($this->price * $this->promo->discount_percentage) / 100;
            return $this->price - $discountAmount;
        }
        return $this->price;
    }
}
