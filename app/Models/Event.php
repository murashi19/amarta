<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
   use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'type_id',
        'status_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'meeting_link',
        'meeting_id',
        'meeting_password',
        'admin_id',
        'budget_total',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budget_total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function type()
    {
        return $this->belongsTo(MasterEventType::class, 'type_id');
    }

    public function status()
    {
        return $this->belongsTo(MasterStatus::class, 'status_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Helper methods
    public function isGoogleMeeting()
    {
        return !empty($this->meeting_link);
    }

    public function getFormattedSchedule()
    {
        return $this->start_date->format('d M Y') . ' pukul ' . $this->start_date->format('H:i') . ' WIB';
    }
}
