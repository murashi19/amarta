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
        'type',
        'status',
        'priority',
        'target_audience',
        'has_payment_button',
        'meet_link',
        'has_payment_button',
        'scheduled_at',
        'views_count',
    ];

    protected $casts = [
        'has_payment_button' => 'boolean',
        'scheduled_at' => 'datetime',
        'views_count' => 'integer'
    ];

    // Relationship dengan User (Admin yang membuat)
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scope untuk filter berdasarkan status
    public function scopeByStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    // Scope untuk filter berdasarkan type
    public function scopeByType($query, $type)
    {
        if ($type) {
            return $query->where('type', $type);
        }
        return $query;
    }

    // Scope untuk search
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }
        return $query;
    }

    // Scope untuk pengumuman yang sudah terpublikasi
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // Scope untuk pengumuman yang dijadwalkan dan sudah waktunya
    public function scopeReadyToPublish($query)
    {
        return $query->where('status', 'scheduled')
                    ->where('scheduled_at', '<=', now());
    }

    // Accessor untuk badge type
    public function getTypeBadgeAttribute()
    {
        $badges = [
            'manual' => ['class' => 'badge-manual', 'text' => 'Manual'],
            'auto_welcome' => ['class' => 'badge-auto', 'text' => 'Otomatis - Welcome'],
            'auto_booking_success' => ['class' => 'badge-auto', 'text' => 'Otomatis - Booking Berhasil']
        ];

        return $badges[$this->type] ?? ['class' => 'badge-manual', 'text' => 'Manual'];
    }

    // Accessor untuk badge status
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'draft' => ['class' => 'bg-warning text-dark', 'text' => 'Draft'],
            'published' => ['class' => 'bg-success', 'text' => 'Terbit'],
            'scheduled' => ['class' => 'bg-info', 'text' => 'Terjadwal']
        ];

        return $badges[$this->status] ?? ['class' => 'bg-secondary', 'text' => 'Unknown'];
    }

    // Accessor untuk badge priority
    public function getPriorityBadgeAttribute()
    {
        $badges = [
            'low' => ['class' => 'bg-success', 'text' => 'Prioritas Rendah'],
            'medium' => ['class' => 'bg-warning', 'text' => 'Prioritas Sedang'],
            'high' => ['class' => 'bg-danger', 'text' => 'Prioritas Tinggi']
        ];

        return $badges[$this->priority] ?? ['class' => 'bg-secondary', 'text' => 'Unknown'];
    }

    // Accessor untuk target audience text
    public function getTargetAudienceTextAttribute()
    {
        $audiences = [
            'all_students' => 'Semua Siswa',
            'new_registrants' => 'Pendaftar Baru',
            'paid_students' => 'Siswa yang Sudah Bayar',
            'active_students' => 'Siswa Aktif'
        ];

        return $audiences[$this->target_audience] ?? 'Unknown';
    }

    // Method untuk increment views
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    // Method untuk check apakah bisa diedit
    public function canBeEdited()
    {
        return in_array($this->status, ['draft', 'scheduled']);
    }

    // Method untuk auto publish jika sudah waktunya
    public static function autoPublishScheduled()
    {
        return self::readyToPublish()->update(['status' => 'published']);
    }

    // Method untuk mendapatkan statistik
    public static function getStats()
    {
        return [
            'total' => self::count(),
            'published' => self::where('status', 'published')->count(),
            'draft' => self::where('status', 'draft')->count(),
            'scheduled' => self::where('status', 'scheduled')->count(),
            'total_views' => self::sum('views_count')
        ];
    }
}