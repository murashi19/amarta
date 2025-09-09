<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use App\Models\FeePayment;
use App\Models\Status;
use App\Models\Announcement;
use App\Models\ClassProgram;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Utama
        $totalUsers = User::whereHas('roles', function($q) {
            $q->where('name', 'User');
        })->count();

        $activeStudents = User::whereHas('roles', function($q) {
            $q->where('name', 'User');
        })->whereHas('status', function($q) {
            $q->whereIn('name', ['Booking Paid', 'Meeting Joined', 'DP Paid', 'Active']);
        })->count();

        $totalTransactions = Transaction::count();
        
        $totalRevenue = Transaction::where('status', 'Completed')->sum('amount');
        
        $newUsersThisMonth = User::whereHas('roles', function($q) {
            $q->where('name', 'User');
        })->whereMonth('created_at', now()->month)->count();

        // 2. Distribusi Status
        $statusCounts = [
            'registered' => User::whereHas('status', function($q) {
                $q->where('name', 'Registered');
            })->whereDoesntHave('roles', function($q) {
                $q->where('name', 'admin');
            })->count(),

            'booking_paid' => User::whereHas('status', function($q) {
                $q->where('name', 'Booking Paid');
            })->whereDoesntHave('roles', function($q) {
                $q->where('name', 'admin');
            })->count(),

            'meeting_joined' => User::whereHas('status', function($q) {
                $q->where('name', 'Meeting Joined');
            })->whereDoesntHave('roles', function($q) {
                $q->where('name', 'admin');
            })->count(),

            'dp_paid' => User::whereHas('status', function($q) {
                $q->where('name', 'DP Paid');
            })->whereDoesntHave('roles', function($q) {
                $q->where('name', 'admin');
            })->count(),

            'active' => User::whereHas('status', function($q) {
                $q->where('name', 'Active');
            })->whereDoesntHave('roles', function($q) {
                $q->where('name', 'admin');
            })->count(),

            'ready_depart' => User::whereHas('status', function($q) {
                $q->where('name', 'Ready to Depart');
            })->whereDoesntHave('roles', function($q) {
                $q->where('name', 'admin');
            })->count(),
        ];


        // 3. Tipe Transaksi
        $transactionTypes = [
            'booking' => Transaction::where('type', 'booking')->count(),
            'dp' => Transaction::where('type', 'dp')->count(),
            'pemantapan' => Transaction::where('type', 'pemantapan')->count(),
            'pemberangkatan' => Transaction::where('type', 'pemberangkatan')->count(),
        ];

        // 4. Pending Actions
        $pendingTransactions = Transaction::where('status', 'Pending')->count();
        $pendingPayments = FeePayment::where('status', 'Verification')->count();
        
        $expiredBookings = Transaction::where('type', 'booking')
            ->where('status', 'Pending')
            ->where('created_at', '<', now()->subDays(3))
            ->count();
            
        $newRegistrations = User::whereHas('roles', function($q) {
            $q->where('name', 'User');
        })->whereDate('created_at', today())->count();

        // 5. Aktivitas Terbaru
        $recentActivities = Transaction::with(['user', 'feePayments'])
        ->orderBy('created_at', 'desc')
        ->paginate(5);


        // 6. Data Chart - Pendapatan Bulanan
        $monthlyRevenue = $this->getMonthlyRevenue();

        // 7. System Info
        $totalAnnouncements = Announcement::where('status', 'published')->count();
        $totalPrograms = ClassProgram::count();
        $systemUptime = 99; // Hardcoded, bisa diambil dari monitoring

        return view('dashboard.admin', compact(
            'totalUsers',
            'activeStudents', 
            'totalTransactions',
            'totalRevenue',
            'newUsersThisMonth',
            'statusCounts',
            'transactionTypes',
            'pendingTransactions',
            'pendingPayments',
            'expiredBookings',
            'newRegistrations',
            'recentActivities',
            'monthlyRevenue',
            'totalAnnouncements',
            'totalPrograms',
            'systemUptime'
        ));
    }

    private function getRecentActivities()
    {
        // Ambil transaksi terbaru dengan user info
        $transactions = Transaction::with(['user', 'feePayments'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $activities = [];
        
        foreach ($transactions as $transaction) {
            $statusColor = $this->getStatusColor($transaction->status);
            $activityText = $this->getActivityText($transaction);
            
            $activities[] = [
                'id' => $transaction->id,
                'user_name' => $transaction->user->name ?? 'Unknown User',
                'user_email' => $transaction->user->email ?? '',
                'user_photo' => $transaction->user->photo ?? null,
                'activity' => $activityText,
                'amount' => $transaction->amount,
                'status' => $transaction->status,
                'status_color' => $statusColor,
                'date' => $transaction->created_at->format('d M Y'),
                'time_ago' => $transaction->created_at->diffForHumans(),
                'needs_action' => $transaction->status === 'Verification'
            ];
        }

        // Jika tidak ada transaksi, berikan data default
        if (empty($activities)) {
            $activities = [
                [
                    'id' => 0,
                    'user_name' => 'Zidan Shidiq',
                    'user_email' => 'zidanafiw@gmail.com',
                    'user_photo' => null,
                    'activity' => 'Pembayaran booking class berhasil',
                    'amount' => 500000,
                    'status' => 'Completed',
                    'status_color' => 'success',
                    'date' => now()->format('d M Y'),
                    'time_ago' => '2 jam lalu',
                    'needs_action' => false
                ]
            ];
        }

        return $activities;
    }

    private function getMonthlyRevenue()
    {
        $currentYear = now()->year;
        $monthlyRevenue = [];
        
        for ($month = 1; $month <= 12; $month++) {
            $revenue = Transaction::where('status', 'Completed')
                ->whereYear('paid_at', $currentYear)
                ->whereMonth('paid_at', $month)
                ->sum('amount');
                
            // Convert ke juta rupiah
            $monthlyRevenue[] = $revenue / 1000000;
        }
        
        return $monthlyRevenue;
    }

    private function getStatusColor($status)
    {
        return match($status) {
            'Completed' => 'success',
            'Pending' => 'warning',
            'Verification' => 'info',
            'Failed' => 'danger',
            default => 'secondary'
        };
    }

    private function getActivityText($transaction)
    {
        return match($transaction->type) {
            'booking' => 'Pembayaran booking class',
            'dp' => 'Pembayaran DP program kelas',
            'pemantapan' => 'Pembayaran biaya pemantapan',
            'pemberangkatan' => 'Pembayaran biaya pemberangkatan',
            default => 'Transaksi ' . $transaction->type
        };
    }
}