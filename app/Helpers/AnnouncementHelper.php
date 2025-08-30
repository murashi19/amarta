<?php

namespace App\Helpers;

class AnnouncementHelper
{
    public static function getActionForType($type, $userStatusId)
    {
        switch ($type) {
            case 'auto welcome':
                return ($userStatusId == 1) ? 'payment_booking' : null;
            case 'auto booking success':
                return ($userStatusId == 2) ? 'show_meet_link' : null;
            case 'auto dp request' && 'auto installment':
                return ($userStatusId == 3) ? 'payment_dp' : null;
            case 'auto success':
                return ($userStatusId == 5) ? 'info_class_active' : null;
            default:
                return null;
        }
    }

    public static function isAudienceMatch($announcementAudience, $userStatusId)
    {
        // Pastikan parameter tidak null dan bersihkan whitespace
        if (empty($announcementAudience) || empty($userStatusId)) {
            \Log::warning("Empty parameters - Audience: '{$announcementAudience}', Status: '{$userStatusId}'");
            return false;
        }

        // Normalisasi string target audience (lowercase dan trim)
        $cleanAudience = strtolower(trim($announcementAudience));
        
        // Mapping yang lebih komprehensif dengan berbagai variasi penulisan
        $audienceMap = [
            // Variasi untuk new registrants
            'new registrants' => [1],
            'new registrants' => [1],
            'new_registrants' => [1],
            'new_registrant' => [1],
            'registrants' => [1],
            'registrant' => [1],
            'registered' => [1],
            
            // Variasi untuk paid students  
            'paid students' => [2],
            'paid student' => [2],
            'paid_students' => [2],
            'paid_student' => [2],
            'paid' => [2],
            
            // Variasi untuk meeting joined
            'meeting joined' => [3],
            'meeting_joined' => [3],
            'joined' => [3],
            'joined meeting' => [3],

            // Variasi untuk dp paid
            'dp paid' => [4],
            'dp_paid' => [4],
            'paid dp' => [4],
            'paid_dp' => [4],
            
            
            // Variasi untuk active students
            'active students' => [5, 6, 7],
            'active student' => [5, 6, 7],
            'active_students' => [5, 6, 7],
            'active_student' => [5, 6, 7],
            'active' => [5, 6, 7],
            
            // Variasi untuk all students
            'all student' => [1, 2, 3, 4, 5, 6, 7],
            'all students' => [1, 2, 3, 4, 5, 6, 7],
            'all_students' => [1, 2, 3, 4, 5, 6, 7],
            'all_student' => [1, 2, 3, 4, 5, 6, 7],
            'all' => [1, 2, 3, 4, 5, 6, 7],
        ];

        // Cek apakah target audience ada dalam mapping
        $allowedStatuses = $audienceMap[$cleanAudience] ?? [];
        
        // Log untuk debugging
        \Log::info("Audience matching - Clean audience: '{$cleanAudience}', Allowed statuses: " . json_encode($allowedStatuses) . ", User status: {$userStatusId}");
        
        $isMatch = in_array((int)$userStatusId, $allowedStatuses);
        
        \Log::info("Final match result: " . ($isMatch ? 'TRUE' : 'FALSE'));
        
        return $isMatch;
    }

    // Menentukan label aksi yang bisa ditampilkan di view
    public static function getActionLabel($action)
    {
        return match ($action) {
            'payment_booking' => 'Bayar Booking Kelas',
            'show_meet_link' => 'Gabung Google Meet',
            'payment_dp' => 'Bayar DP',
            'installment' => 'Bayar Cicilan',
            'info_class_active' => 'Kelas Aktif 🎉',
            default => null,
        };
    }

    /**
     * Warna tombol untuk masing-masing aksi (opsional)
     */
    public static function getActionClass($action)
    {
        return match ($action) {
            'payment_booking' => 'btn-primary',
            'show_meet_link' => 'btn-success',
            'payment_dp' => 'btn-warning',
            'info_class_active' => 'btn-info disabled',
            default => 'btn-secondary',
        };
    }

    /**
     * Helper untuk mendapatkan daftar semua target audience yang valid
     */
    public static function getValidAudiences()
    {
        return [
            'new registrants' => 'New Registrants (Status 1)',
            'paid students' => 'Paid Students (Status 2)', 
            'meeting joined' => 'Meeting Joined (Status 3)',
            'active students' => 'Active Students (Status 5)',
            'all students' => 'All Students (Status 1-5)',
        ];
    }

    /**
     * Helper untuk mendapatkan status description
     */
    public static function getStatusDescription($statusId)
    {
        $descriptions = [
            1 => 'New Registrant',
            2 => 'Paid Student',
            3 => 'Meeting Joined',
            5 => 'Active Student'
        ];

        return $descriptions[$statusId] ?? 'Unknown Status';
    }

    public static function getActionUrl($action)
    {
        return match ($action) {
            'payment_booking' => route('transaksi.booking'), // tanpa ID
            'show_meet_link' => route('dashboard.users'),
            'payment_dp' => route('transaksi.dp.start'),
            'info_class_active' => '#',
            default => '#',
        };
    }



}