<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $fillable = ['transaction_id', 'amount_paid', 'payment_date'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
