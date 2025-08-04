<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'type',          // booking / dp
        'amount',
        'status',        // pending / completed / failed
        'proof_url',
        'xendit_id',
        'xendit_status',
    ];

    // Relasi: satu transaksi milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
