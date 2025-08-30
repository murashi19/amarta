<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'type',          // booking / dp
        'amount',
        'payment_schedule_id',
        'due_date',
        'status',        // pending / completed / failed / verification
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
        'paid_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relasi: satu transaksi milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentSchedule(): BelongsTo
    {
        return $this->belongsTo(PaymentSchedule::class);
    }
    
    public function feePayments()
    {
        return $this->hasMany(FeePayment::class, 'transaction_id');
    }

    // Atribut
    public function getTypeNameAttribute()
    {
        return match($this->type) {
            'booking' => 'Booking',
            'dp' => 'Program Kelas',
            'pemantapan' => 'Pemantapan', 
            'pemberangkatan' => 'Pemberangkatan',
            default => ucfirst($this->type)
        };
    }

    public function getStatusNameAttribute()
    {
        $statuses = [
            'pending' => 'Pending',
            'verification' => 'Verifikasi',
            'completed' => 'Selesai',
            'failed' => 'Gagal'
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeVerification($query)
    {
        return $query->where('status', 'verification');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

   // Scope berdasarkan tipe
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year);
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear('created_at', Carbon::now()->year);
    }

    // Static methods
    public static function getTotalRevenue()
    {
        return self::completed()->sum('amount');
    }

    public static function getMonthlyRevenue()
    {
        return self::completed()->thisMonth()->sum('amount');
    }

    public static function getTransactionStats()
    {
        return [
            'total' => self::count(),
            'completed' => self::completed()->count(),
            'verification' => self::verification()->count(),
            'pending' => self::pending()->count(),
            'failed' => self::failed()->count(),
            'booking' => self::booking()->count(),
            'dp' => self::dp()->count(),
            'departure' => self::departure()->count(),
            'total_revenue' => self::getTotalRevenue(),
            'monthly_revenue' => self::getMonthlyRevenue()
        ];
    }

    // Format amount
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    // Get status badge class untuk UI
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'Completed' => 'status-paid',
            'Pending' => 'status-pending',
            'Verification' => 'status-verification',
            'Failed' => 'status-expired',
            default => 'status-pending'
        };
    }

    // Get payment type label
    public function getTypeLabel()
    {
        return match($this->type) {
            'booking' => 'Booking Class',
            'dp' => 'Program Kelas',
            'pemantapan' => 'Pemantapan',
            'pemberangkatan' => 'Pemberangkatan',
            
            default => ucfirst($this->type)
        };
    }

}
