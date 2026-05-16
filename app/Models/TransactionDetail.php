<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = ['transaction_id', 'shoe_id', 'quantity', 'price', 'discount', 'subtotal'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function shoe()
    {
        return $this->belongsTo(Shoe::class);
    }
}
