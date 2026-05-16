<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['invoice_number', 'total_amount', 'payment_method', 'payment_status'];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }
}
