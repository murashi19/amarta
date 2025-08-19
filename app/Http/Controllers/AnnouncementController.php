<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Helpers\AnnouncementHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AnnouncementController extends Controller
{
   // --- Pengumuman ---
    public function index()
    {
        $announcements = Announcement::orderBy('id', 'desc')->get();
        
        // Calculate the counts for the stats cards
        $totalAnnouncements = $announcements->count();
        $publishedCount = $announcements->where('status', 'published')->count();
        $draftCount = $announcements->where('status', 'draft')->count();
        $scheduledCount = $announcements->where('status', 'scheduled')->count();

        return view('admin.pengumuman', compact('announcements', 'totalAnnouncements', 'publishedCount', 'draftCount', 'scheduledCount'));
    }

    public function filter(Request $request)
    {
        $query = Announcement::query();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $announcements = $query->get()->map(function($item) {
            return [
                'id' => $item->id,
                'judul' => $item->judul,
                'jenis' => $item->type,
                'status' => $item->status,
                'prioritas' => $item->priority,
                'audiens' => $item->target_audience,
                'tanggal' => $item->created_at->format('Y-m-d'),
            ];
        });

        return response()->json($announcements);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'type' => 'required|string|in:umum,auto welcome,auto booking success,auto dp request,auto success, auto installment',
            'status' => 'required|string|in:draft,published,scheduled',
            'priority' => 'required|string|in:low,medium,high',
            'target_audience' => 'nullable|string|in:all students,new registrants,paid students,meeting joined,active students',
            'meet_link' => 'nullable|url',
            'has_payment_button' => 'nullable|string',
            'scheduled_date' => 'nullable|date',
            'scheduled_time' => 'nullable|date_format:H:i',
        ]);

        $validated['has_payment_button'] = $request->has('has_payment_button');
        $validated['created_by'] = Auth::id();

        // Gabungkan scheduled_date dan scheduled_time ke scheduled_at
        if (!empty($validated['scheduled_date']) && !empty($validated['scheduled_time'])) {
            $validated['scheduled_at'] = Carbon\Carbon::parse(
                $validated['scheduled_date'] . ' ' . $validated['scheduled_time']
            );
        } else {
            $validated['scheduled_at'] = null;
        }

        // Hapus field lama supaya tidak error saat mass assignment
        unset($validated['scheduled_date'], $validated['scheduled_time']);

        switch ($validated['type']) {
            case 'auto welcome':
                $validated['has_payment_button'] = true;
                if (empty($validated['title'])) {
                    $validated['title'] = 'Selamat Datang di Program Kami';
                }
                break;

            case 'auto dp request':
                $validated['has_payment_button'] = true;
                if (empty($validated['target_audience'])) {
                    $validated['target_audience'] = 'meeting joined';
                }
                if (empty($validated['title'])) {
                    $validated['title'] = 'Permintaan Pembayaran DP Program Kelas';
                }
                if (empty($validated['content'])) {
                    $paymentUrl = route('transaksi.programKelas.createProgramKelas');
                    $validated['content'] = 'Terima kasih telah melanjutkan program kelas kita, '
                        . 'untuk bisa mengaktifkan kelas Anda, Anda harus membayar <strong>DP Program Kelas</strong> terlebih dahulu '
                        . 'untuk melanjut ke Program Kelas Bahasa.<br><br>'
                        . '<a href="' . $paymentUrl . '" class="btn btn-success" '
                        . 'style="padding:10px 20px; font-size:16px; border-radius:6px;">💳 Bayar DP Program Kelas</a>';
                }
                break;

            case 'auto booking success':
                if (empty($validated['meet_link'])) {
                    return back()->withErrors(['meet_link' => 'Link meeting wajib diisi untuk jenis Auto Booking Success'])->withInput();
                }
                $validated['has_payment_button'] = false;
                break;

            case 'auto installment':
                $validated['has_payment_button'] = false;
                break;
        }

        Announcement::create($validated);

        return redirect()->route('admin.pengumuman')->with('success', 'Pengumuman berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);

        // Pecah scheduled_at jadi scheduled_date & scheduled_time
        if (!empty($announcement->scheduled_at)) {
            $announcement->scheduled_date = \Carbon\Carbon::parse($announcement->scheduled_at)->format('Y-m-d');
            $announcement->scheduled_time = \Carbon\Carbon::parse($announcement->scheduled_at)->format('H:i');
        } else {
            $announcement->scheduled_date = null;
            $announcement->scheduled_time = null;
        }

        return response()->json($announcement);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'type' => 'required|string|in:umum,auto welcome,auto booking success,auto dp request,auto success, auto installment',
            'status' => 'required|string|in:draft,published,scheduled',
            'priority' => 'required|string|in:low,medium,high',
            'target_audience' => 'nullable|string|in:all students,new registrants,paid students,meeting joined,active students',
            'meet_link' => 'nullable|url',
            'has_payment_button' => 'nullable|string',
            'scheduled_date' => 'nullable|date',
            'scheduled_time' => 'nullable|date_format:H:i',
        ]);

        $validated['has_payment_button'] = $request->has('has_payment_button');

        switch ($validated['type']) {
            case 'auto welcome':
                $validated['has_payment_button'] = true;
                $validated['title'] = $validated['title'] ?: 'Selamat Datang di Program Kami';
                break;

            case 'auto dp request':
                $validated['has_payment_button'] = true;
                $validated['target_audience'] = $validated['target_audience'] ?: 'meeting joined';
                $validated['title'] = $validated['title'] ?: 'Permintaan Pembayaran DP Program Kelas';
                $validated['content'] = $validated['content'] ?: 'Terima kasih telah melanjutkan program kelas kita, ...';
                break;

            case 'auto booking success':
                if (empty($validated['meet_link'])) {
                    return back()->withErrors(['meet_link' => 'Link meeting wajib diisi untuk jenis Auto Booking Success'])->withInput();
                }
                $validated['has_payment_button'] = false;
                break;

            case 'auto installment':
                $validated['has_payment_button'] = false;
                break;
        }

        // Gabungkan tanggal & jam kalau status scheduled
        if ($validated['status'] === 'scheduled') {
            if (!empty($validated['scheduled_date']) && !empty($validated['scheduled_time'])) {
                $validated['scheduled_at'] = $validated['scheduled_date'] . ' ' . $validated['scheduled_time'];
            }
        }

        $announcement = Announcement::findOrFail($id);
        $announcement->update($validated);

        return redirect()->route('admin.pengumuman')->with('success', 'Pengumuman berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();
        return redirect()->route('admin.pengumuman')->with('success', 'Pengumuman berhasil dihapus.');
    }

    // --- Lihat Detail Pengumuman ---
    public function show($id)
    {
        try {
            $announcement = Announcement::findOrFail($id);

            if (request()->expectsJson()) {
                // Format tanggal/jam jika ada
                $scheduledDate = $announcement->scheduled_date
                    ? Carbon::parse($announcement->scheduled_date)->format('Y-m-d')
                    : null;
                $scheduledTime = $announcement->scheduled_time
                    ? Carbon::parse($announcement->scheduled_time)->format('H:i')
                    : null;

                // Bangun HTML fitur tambahan (dipakai di modal admin)
                $features = [];
                if ((bool)$announcement->has_payment_button) {
                    $features[] = '<span class="badge bg-success">Tombol Pembayaran</span>';
                }
                if (!empty($announcement->meet_link)) {
                    $features[] = '<a href="' . e($announcement->meet_link) . '" target="_blank" class="btn btn-sm btn-outline-primary">Link Meeting</a>';
                }
                // contoh fitur lain: tipe auto
                if (!empty($announcement->type) && str_contains($announcement->type, 'auto')) {
                    $features[] = '<span class="badge bg-info">'.e($announcement->type).'</span>';
                }
                $additionalFeaturesHtml = count($features) ? implode(' ', $features) : null;

                return response()->json([
                    'success' => true,
                    'id' => $announcement->id,
                    'title' => $announcement->title,
                    'content' => $announcement->content, // mengandung HTML jika ada
                    'type' => $announcement->type,
                    'status' => $announcement->status,
                    'priority' => $announcement->priority,
                    'target_audience' => $announcement->target_audience,
                    'meet_link' => $announcement->meet_link,
                    'has_payment_button' => (bool)$announcement->has_payment_button,
                    'scheduled_date' => $scheduledDate,
                    'scheduled_time' => $scheduledTime,
                    'created_at' => $announcement->created_at ? $announcement->created_at->format('Y-m-d H:i:s') : null,
                    'updated_at' => $announcement->updated_at ? $announcement->updated_at->format('Y-m-d H:i:s') : null,
                    'additional_features' => $additionalFeaturesHtml,
                ]);
            }

            return view('admin.pengumuman.show', compact('announcement'));
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengumuman tidak ditemukan'
                ], 404);
            }
            return redirect()->route('admin.pengumuman')
                            ->with('error', 'Pengumuman tidak ditemukan.');
        }
    }


    // --- Fungsi tambahan untuk view pengumuman (jika diperlukan) ---
    public function view($id)
    {
        try {
            $announcement = Announcement::findOrFail($id);
            
            // Increment views count
            $announcement->increment('views');
            
            return response()->json([
                'success' => true,
                'data' => $announcement
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pengumuman tidak ditemukan'
            ], 404);
        }
    }


    // --- Fungsi Pengumuman untuk User ---
    public function getUserAnnouncements()
    {
        try {
            $user = Auth::user()->load('status');

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan'
                ], 404);
            }

            // Tentukan target audience berdasarkan status user
            $targetAudience = $this->getTargetAudienceByStatus($user->status->name ?? 'Registered');

            // Ambil pengumuman yang sesuai target audience atau untuk semua siswa
            $announcements = Announcement::where('status', 'published')
                ->where(function ($query) use ($targetAudience) {
                    $query->where('target_audience', $targetAudience)
                        ->orWhere('target_audience', 'all students');
                })
                ->orderBy('priority', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();

            // Format response untuk frontend
            $formattedAnnouncements = $announcements->map(function ($announcement) use ($user) {
                return [
                    'id' => $announcement->id,
                    'title' => $announcement->title,
                    'content' => $announcement->content,
                    'type' => $announcement->type,
                    'priority' => $announcement->priority,
                    'target_audience' => $announcement->target_audience,
                    'has_payment_button' => $announcement->has_payment_button,
                    'meet_link' => $announcement->meet_link,
                    'created_at' => $announcement->created_at->format('Y-m-d H:i:s'),

                    // Logic tombol bayar otomatis
                    'show_booking_button' => $this->shouldShowBookingButton($user, $announcement),
                    'show_dp_button' => $this->shouldShowDpButton($user, $announcement),
                ];
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'user_status' => $user->status->name ?? 'Registered',
                    'announcements' => $formattedAnnouncements
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menentukan target audience berdasarkan status user
     * 
     * @param string $statusName
     * @return string
     */
    private function getTargetAudienceByStatus($statusName)
    {
        $statusMapping = [
            'Registered'     => 'new registrants',
            'Booking Paid'   => 'paid students',
            'Meeting Joined' => 'meeting joined', // khusus untuk auto dp request
            'DP Paid'        => 'active students',
            'Active'         => 'active students'
        ];

        return $statusMapping[$statusName] ?? 'new registrants';
    }

    /**
     * Tombol Booking Class
     * 
     * @param User $user
     * @param Announcement $announcement
     * @return bool
     */
    private function shouldShowBookingButton($user, $announcement)
    {
        $userStatus = $user->status->name ?? 'Registered';

        return $announcement->type === 'auto welcome' &&
            $userStatus === 'Registered' &&
            $announcement->has_payment_button;
    }

    /**
     * Tombol DP Program Kelas
     * 
     * @param User $user
     * @param Announcement $announcement
     * @return bool
     */
    private function shouldShowDpButton($user, $announcement)
    {
        $userStatus = $user->status->name ?? 'Registered';

        return $announcement->type === 'auto dp request' &&
            $userStatus === 'Meeting Joined' &&
            $announcement->has_payment_button;
    }

    /**
     * Mendapatkan detail pengumuman berdasarkan ID
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    
    public function AnnountmentsUser()
    {
        try {
            // Pastikan user sudah login
            $user = Auth::user();
            
            if (!$user) {
                return redirect()->route('login');
            }

            // Ambil status_id user dengan fallback
            $userStatusId = $user->status_id ?? 1;

            // Ambil semua announcements yang published
            $allAnnouncements = Announcement::where('status', 'published')
                ->orderByDesc('priority')
                ->latest()
                ->get();

            // Filter sesuai target audience
            $announcements = collect();
            
            if ($allAnnouncements->count() > 0) {
                $announcements = $allAnnouncements->filter(function ($announcement) use ($userStatusId) {
                    $isMatch = AnnouncementHelper::isAudienceMatch($announcement->target_audience, $userStatusId);
                    
                    // Debug - hapus setelah testing
                    \Log::info("Checking announcement: {$announcement->title}");
                    \Log::info("Target audience: '{$announcement->target_audience}'");
                    \Log::info("User Status: {$userStatusId}");
                    \Log::info("Match result: " . ($isMatch ? 'YES' : 'NO'));
                    
                    return $isMatch;
                });
            }

            // Cek apakah user masih punya cicilan
            $hasOutstanding = \App\Models\FeePayment::whereHas('transaction', function($q) {
                    $q->where('user_id', auth()->id());
                })
                ->where('status', '!=', 'Completed')
                ->exists();

            // Filter pengumuman berdasarkan kondisi tagihan
            if ($hasOutstanding) {
                $announcements = $announcements->filter(function ($item) {
                    return $item->type === 'auto installment' || $item->type === 'umum';
                });
            } else {
                $announcements = $announcements->filter(function ($item) {
                    return $item->type === 'auto success' || $item->type === 'umum';
                });
            }

            // Debug info - hapus setelah testing
            \Log::info("User Status ID: {$userStatusId}");
            \Log::info("Total announcements: " . $allAnnouncements->count());
            \Log::info("Filtered announcements: " . $announcements->count());

            // Tambahkan debug untuk semua target audience yang ada
            $allTargetAudiences = $allAnnouncements->pluck('target_audience')->unique();
            \Log::info("All target audiences in DB: " . $allTargetAudiences->toJson());

            // Pastikan semua variabel dikirim ke view
            return view('dashboard.users', [
                'announcements' => $announcements,
                'userStatusId' => $userStatusId,
                'user' => $user,
                'debug' => [
                    'totalAnnouncements' => $allAnnouncements->count(),
                    'filteredAnnouncements' => $announcements->count(),
                    'userStatus' => $userStatusId,
                    'allTargetAudiences' => $allTargetAudiences->toArray(),
                    'allAnnouncementsData' => $allAnnouncements->map(function($a) use ($userStatusId) {
                        return [
                            'title' => $a->title,
                            'target_audience' => $a->target_audience,
                            'is_match' => AnnouncementHelper::isAudienceMatch($a->target_audience, $userStatusId)
                        ];
                    })
                ]
            ]);
            
        } catch (\Exception $e) {
            // Handle error gracefully
            \Log::error("Dashboard error: " . $e->getMessage());
            \Log::error("Stack trace: " . $e->getTraceAsString());
            
            return view('dashboard.users', [
                'announcements' => collect(),
                'userStatusId' => 1,
                'user' => Auth::user(),
                'error' => $e->getMessage()
            ]);
        }
    }
}