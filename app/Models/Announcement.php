<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'type',              // e.g. "booking", "meeting", "general"
        'status',            // e.g. "active", "draft", "expired"
        'priority',          // e.g. "low", "medium", "high"
        'target_audience',   // e.g. "new_user", "all", "booking_paid_only"
        'has_payment_button',// true/false
        'meet_link',         // opsional, jika announcement meeting
        'scheduled_at',      // tanggal tampil / berlaku
        'views_count',       // int, default 0
    ];

    // Relasi ke user
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('read_at')->withTimestamps();
    }
}