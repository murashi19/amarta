<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
        'user_id',
        'meet_link',
        'schedule_at',
        'is_attended',
    ];

    // Relasi: satu meeting untuk satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

