<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

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
        // 'is_verified',
        'notes',
        'status_id',
        // 'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        // 'email_verified_at' => 'datetime',
        'birth_date' => 'date',
        // 'is_verified' => 'boolean',
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
}