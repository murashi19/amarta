<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meeting extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'meet_link',
        'schedule_at',
        'is_attended',
    ];

     protected $casts = [
        'schedule_at' => 'datetime',
        'is_attended' => 'boolean'
    ];

    // Relasi: satu meeting untuk satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

