<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',        // email, whatsapp, sms
        'content',
        'is_sent',
        'sent_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

