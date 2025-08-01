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
        'address',
        'birth_date',
        'education',
        'japanese_level',
        'motivation',
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
        return $this->belongsTo(MasterStatus::class, 'status_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    // Helper Method
    public function hasCompletedBookingPayment()
    {
        return $this->transactions()
            ->where('type', 'Payment')
            ->where('status', 'Completed')
            ->where('description', 'Booking Fee LPK')
            ->exists();
    }

    public function getActiveGoogleMeeting()
    {
        return $this->events()
            ->where('type_id', 1) // intro_meeting
            ->whereIn('status_id', [5, 6]) // meeting_scheduled or meeting_completed
            ->where('start_date', '>=', now()->toDateString())
            ->first();
    }

    public function getJapaneseLevelText()
    {
        $levels = [
            'N5' => 'N5 (Pemula)',
            'N4' => 'N4 (Menengah Bawah)',
            'N3' => 'N3 (Menengah)',
            'N2' => 'N2 (Menengah Atas)',
            'N1' => 'N1 (Mahir)',
            'none' => 'Belum Menguasai'
        ];
        
        return $levels[$this->japanese_level] ?? 'Tidak diketahui';
    }

    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }
}
