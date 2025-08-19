<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FeePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'user_id',
        'amount',
        'payment_method',
        'selected_method',
        'photo',
        'notes',
        'reference_number',
        'paid_at',
        'expires_at',
        'admin_notes',
        'verified_by',
        'verified_at',
        'status'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    /**
     * Relationship with Transaction
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    /**
     * Relationship with User (payer)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with User (verifier/admin)
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Get payment method name for display
     */
    public function getPaymentMethodNameAttribute()
    {
        $methods = [
            'transfer_bank' => 'Transfer Bank',
            'ewallet' => 'E-Wallet',
            'cash' => 'Tunai',
        ];

        return $methods[$this->payment_method] ?? ucfirst(str_replace('_', ' ', $this->payment_method));
    }

    /**
     * Get selected method name for display
     */
    public function getSelectedMethodNameAttribute()
    {
        if (!$this->selected_method) {
            return null;
        }

        // Bank names
        $banks = [
            'bca' => 'BCA',
            'mandiri' => 'Mandiri',
            'bri' => 'BRI',
            'bni' => 'BNI',
        ];

        // E-wallet names
        $ewallets = [
            'gopay' => 'GoPay',
            'ovo' => 'OVO',
            'dana' => 'DANA',
            'shopeepay' => 'ShopeePay',
        ];

        return $banks[$this->selected_method] ?? 
               $ewallets[$this->selected_method] ?? 
               ucfirst($this->selected_method);
    }

    /**
     * Get photo file URL
     */
    public function getphotoUrlAttribute()
    {
        if (!$this->photo) {
            return null;
        }

        return Storage::disk('public')->url($this->photo);
    }

    /**
     * Check if payment is expired
     */
    public function getIsExpiredAttribute()
    {
        if (!$this->expires_at) {
            return false;
        }

        return $this->expires_at->isPast();
    }

    /**
     * Get status badge color for display
     */
    public function getStatusBadgeColorAttribute()
    {
        $colors = [
            'Pending' => 'warning',
            'Verification' => 'info',
            'Completed' => 'success',
            'Failed' => 'danger',
            'Cancelled' => 'secondary',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * Get status icon for display
     */
    public function getStatusIconAttribute()
    {
        $icons = [
            'Pending' => 'fas fa-clock',
            'Verification' => 'fas fa-search',
            'Completed' => 'fas fa-check-circle',
            'Failed' => 'fas fa-times-circle',
            'Cancelled' => 'fas fa-ban',
        ];

        return $icons[$this->status] ?? 'fas fa-question-circle';
    }

    /**
     * Scope for specific transaction
     */
    public function scopeForTransaction($query, $transactionId)
    {
        return $query->where('transaction_id', $transactionId);
    }

    /**
     * Scope for specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for specific status
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for completed payments
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'Completed');
    }

    /**
     * Scope for pending verification
     */
    public function scopePendingVerification($query)
    {
        return $query->where('status', 'Verification');
    }

    /**
     * Scope for expired payments
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now())
                    ->where('status', 'Verification');
    }

    /**
     * Get formatted amount
     */
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Delete photo file when model is deleted
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            if ($model->photo && Storage::disk('public')->exists($model->photo)) {
                Storage::disk('public')->delete($model->photo);
            }
        });
    }
}