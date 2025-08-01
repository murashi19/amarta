<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
   use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'event_id',
        'amount',
        'type',
        'status',
        'payment_method',
        'payment_reference',
        'snap_token',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Scopes
    public function scopeBookingFee($query)
    {
        return $query->where('description', 'Booking Fee LPK');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'Completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }
}
