<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    protected $fillable = [
        'transaction_id', 'amount', 'status', 'photo', 'paid_at',
    ];

    // Relasi ke transaksi induk
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
