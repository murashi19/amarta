<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Announcement;
use App\Models\FeePayment;
use Carbon\Carbon;
use DB;

class UserAnnouncementController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return redirect()->route('login');
            }

            $userStatusId = $user->status_id ?? 1;

            // Ambil pengumuman untuk user ini
            $announcements = $this->getAnnouncementsForUser($user);

            // Ambil meeting terdekat user
            $meetingData = $this->getNextMeeting($user->id, $userStatusId);

            // Enrich pengumuman dengan meeting data kalau perlu
            $announcements = $this->enrichAnnouncementsWithMeeting($announcements, $meetingData);

            return view('dashboard.users.announcements', [
                'user' => $user,
                'userStatusId' => $userStatusId,
                'announcements' => $announcements,
                'meetingData' => $meetingData,
            ]);

        } catch (\Exception $e) {
            \Log::error("User Announcement Error: " . $e->getMessage());

            return view('dashboard.users.announcements', [
                'user' => Auth::user(),
                'announcements' => collect(),
                'userStatusId' => 1,
                'meetingData' => null,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function getAnnouncementsForUser($user)
    {
        $statusId = $user->status_id ?? 1;
        $allowedAudiences = $this->getAllowedAudiences($statusId);

        // Published + Scheduled
        $published = $this->getPublishedAnnouncements($allowedAudiences);
        $scheduled = $this->getScheduledAnnouncements($allowedAudiences);
        $all = $published->merge($scheduled);

        $hasOutstanding = $this->userHasOutstandingPayments($user->id);

        $filtered = $this->getFilteredAnnouncementsByUser($all, $statusId, $hasOutstanding);

        return $this->sortAnnouncements($filtered);
    }

    private function getAllowedAudiences($statusId)
    {
        $statusToAudience = [
            1 => ['new registrants', 'all students'],
            2 => ['paid students', 'all students'],
            3 => ['meeting joined', 'all students'],
            5 => ['active students', 'all students'],
            6 => ['active students', 'all students'],
            7 => ['active students', 'all students'],
        ];
        return $statusToAudience[$statusId] ?? ['all students'];
    }

    private function getPublishedAnnouncements($allowedAudiences)
    {
        return Announcement::where('status', 'published')
            ->whereIn('target_audience', $allowedAudiences)
            ->orderByDesc('priority')
            ->latest()
            ->get();
    }

    private function getScheduledAnnouncements($allowedAudiences)
    {
        return Announcement::where('status', 'scheduled')
            ->whereIn('target_audience', $allowedAudiences)
            ->where('scheduled_at', '>=', now())
            ->orderBy('scheduled_at', 'asc')
            ->get();
    }

    private function userHasOutstandingPayments($userId)
    {
        return FeePayment::whereHas('transaction', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->where('status', '!=', 'Completed')
            ->exists();
    }

    private function getFilteredAnnouncementsByUser($announcements, $statusId, $hasOutstanding)
    {
        $statusTypeMap = [
            1 => ['auto welcome', 'umum'],
            2 => ['auto booking success', 'auto welcome','umum'],
            3 => ['auto dp request', 'umum'],
            5 => ['auto installment','auto success','umum'],
            6 => ['auto installment','auto success','umum'],
            7 => ['auto installment','auto success','umum'],
        ];

        $typeFilter = [
            'withDebt' => ['auto installment', 'auto welcome', 'umum'],
            'noDebt'   => ['auto success', 'auto welcome', 'umum'],
        ];

        $now = now();

        return $announcements->filter(function ($item) use ($statusId, $statusTypeMap, $typeFilter, $hasOutstanding, $now) {
            // Filter type
            if ($hasOutstanding) {
                if (isset($statusTypeMap[$statusId])) {
                    if (!in_array($item->type, $statusTypeMap[$statusId])) {
                        return false;
                    }
                } else {
                    if (!in_array($item->type, $typeFilter['withDebt'])) {
                        return false;
                    }
                }
            } else {
                if ($item->type !== 'auto dp request') {
                    return false;
                }
            }

            // Filter tanggal
            $date = $item->scheduled_at ?? $item->created_at;
            return Carbon::parse($date)->addDay()->isAfter($now);
        });
    }

    private function sortAnnouncements($announcements)
    {
        return $announcements->sortBy(function ($item) {
            return $item->scheduled_at ?? $item->created_at;
        })->values();
    }

    private function getNextMeeting($userId, $statusId)
    {
        if ($statusId == 2) {
            return DB::table('meetings')
                ->where('user_id', $userId)
                ->orderBy('schedule_at', 'asc')
                ->first();
        }
        return null;
    }

    private function enrichAnnouncementsWithMeeting($announcements, $meetingData)
    {
        return $announcements->map(function ($announcement) use ($meetingData) {
            if ($meetingData && $announcement->type === 'auto booking success') {
                $announcement->meeting_platform = $meetingData->platform ?? null;
                $announcement->zoom_meeting_id  = $meetingData->zoom_meeting_id ?? null;
                $announcement->zoom_passcode    = $meetingData->zoom_passcode ?? null;

                if ($meetingData->meet_link) {
                    $announcement->meet_link = $meetingData->meet_link;
                }
                if ($meetingData->schedule_at) {
                    $announcement->scheduled_at = $meetingData->schedule_at;
                }
            }
            return $announcement;
        });
    }
}
