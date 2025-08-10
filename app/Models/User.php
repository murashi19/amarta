<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'gender',
        'birth_place',
        'birth_date',
        'address',
        'education_level',
        'photo',
        'notes',
        'status_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'password' => 'hashed',
    ];

    // Relasi
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


    public function meetings()
    {
        return $this->hasMany(\App\Models\Meeting::class);
    }


    public function userClasses()
    {
        return $this->hasMany(UserClass::class);
    }

    public function classes()
    {
        return $this->belongsToMany(ClassProgram::class, 'user_classes')
                    ->withTimestamps()
                    ->withPivot('enrolled_at');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function announcements()
    {
        return $this->belongsToMany(Announcement::class)->withPivot('read_at')->withTimestamps();
    }

    // Helper methods
    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    public function hasAnyRole($roles)
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    // Accessor untuk photo URL
    public function getPhotoUrlAttribute()
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    // Transaction related methods
    public function getBookingTransaction()
    {
        return $this->transactions()->where('type', 'booking')->first();
    }

    public function getDpTransaction()
    {
        return $this->transactions()->where('type', 'dp')->first();
    }

    public function hasCompletedBooking()
    {
        return $this->transactions()
                    ->where('type', 'booking')
                    ->where('status', 'completed')
                    ->exists();
    }

    public function hasCompletedDp()
    {
        return $this->transactions()
                    ->where('type', 'dp')
                    ->where('status', 'completed')
                    ->exists();
    }

    // Status related methods
    public function getStatusName()
    {
        return $this->status ? $this->status->name : 'No Status';
    }

    public function canPayDp()
    {
        return $this->hasCompletedBooking() && !$this->hasCompletedDp();
    }

    // Accessors

    public function getInitialsAttribute()
    {
        return strtoupper(substr($this->name ?? 'U', 0, 2));
    }

    public function getFullAddressAttribute()
    {
        $address = [];
        if ($this->address) $address[] = $this->address;
        if ($this->birth_place) $address[] = $this->birth_place;
        
        return implode(', ', $address);
    }

    // Scopes
    public function scopeWithStatus($query, $statusName)
    {
        return $query->whereHas('status', function($q) use ($statusName) {
            $q->where('name', $statusName);
        });
    }

    public function scopeWithRole($query, $roleName)
    {
        return $query->whereHas('roles', function($q) use ($roleName) {
            $q->where('name', $roleName);
        });
    }

    public function scopeRegistered($query)
    {
        return $query->withStatus('Registered');
    }

    public function scopeBookingPaid($query)
    {
        return $query->withStatus('Booking Paid');
    }

    public function scopeDpPaid($query)
    {
        return $query->withStatus('DP Paid');
    }

    public function scopeActive($query)
    {
        return $query->withStatus('Active');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Relasi ke payment schedules
    public function paymentSchedules()
    {
        return $this->hasMany(PaymentSchedule::class);
    }

    // Get current class program
    public function getCurrentClassProgram()
    {
        return $this->userClasses()
            ->with('classProgram.programFee')
            ->latest()
            ->first()?->classProgram;
    }

    // Get payment summary untuk UI
    public function getPaymentSummary()
    {
        $classProgram = $this->getCurrentClassProgram();
        if (!$classProgram || !$classProgram->programFee) {
            return null;
        }

        $programFee = $classProgram->programFee;
        
        return [
            'program_name' => $classProgram->name,
            'total_fee' => $programFee->total_fee,
            'booking_fee' => $programFee->booking_fee,
            'dp_fee' => $programFee->dp_fee,
            'departure_fee' => $programFee->departure_fee,
            'booking_status' => $this->getPaymentStatus('booking'),
            'dp_status' => $this->getPaymentStatus('dp'),
            'departure_status' => $this->getPaymentStatus('departure'),
        ];
    }

    // Get status pembayaran berdasarkan type
    public function getPaymentStatus($type)
    {
        $transaction = $this->transactions()
            ->where('type', $type)
            ->where('status', 'Completed')
            ->first();

        if ($transaction) {
            return 'paid';
        }

        // Check jika prerequisite sudah terpenuhi
        switch ($type) {
            case 'booking':
                return 'pending';
            case 'dp':
                $bookingPaid = $this->getPaymentStatus('booking') === 'paid';
                return $bookingPaid ? 'pending' : 'waiting';
            case 'departure':
                $dpPaid = $this->getPaymentStatus('dp') === 'paid';
                return $dpPaid ? 'pending' : 'waiting';
            default:
                return 'pending';
        }
    }

    // Check apakah bisa bayar tipe tertentu
    public function canPayType($type)
    {
        switch ($type) {
            case 'booking':
                return true;
            case 'dp':
                return $this->getPaymentStatus('booking') === 'paid';
            case 'departure':
                return $this->getPaymentStatus('dp') === 'paid';
            default:
                return false;
        }
    }

    public function canAccessFinancePage(): bool
    {
        $userStatus = $this->getStatusName();
        
        // Jika bukan status yang dibatasi, allow access
        if (!in_array($userStatus, ['Registered', 'New Registrant'])) {
            return true;
        }
        
        // Jika status Registered/New Registrant, harus sudah bayar booking
        return $this->hasCompletedBooking();
    }

    public function getFinanceAccessErrorMessage(): string
    {
        if (!$this->canAccessFinancePage()) {
            return 'Maaf Anda belum bisa membuka halaman ini karena anda belum membayar booking kelas, silahkan membayar terlebih dahulu';
        }
        
        return '';
    }

    public function isNewRegistrant(): bool
    {
        $userStatus = $this->getStatusName();
        return in_array($userStatus, ['Registered', 'New Registrant']);
    }
}