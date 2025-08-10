@extends('layouts.dashboardAdmin')

@section('title', 'Dashboard')

@section('content')
<!-- Welcome Card -->
<div class="dashboard-card welcome-card">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1>Welcome Back, {{ Auth::user()->name }}!</h1>
            <p class="mb-0">Here's what's happening with your LPK Amarta platform today.</p>
            <small class="text-muted">Last updated: {{ now()->format('d M Y, H:i') }}</small>
        </div>
        <div class="col-md-4 text-end">
            <i class="fas fa-graduation-cap" style="font-size: 4rem; opacity: 0.3;"></i>
        </div>
    </div>
</div>

<!-- Key Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="dashboard-card stat-card card-primary">
            <div class="position-relative">
                <h2 class="stat-number">{{ $totalUsers ?? 0 }}</h2>
                <p class="stat-label">Total Siswa</p>
                <i class="fas fa-users stat-icon"></i>
                <div class="stat-trend">
                    <small class="text-success">
                        <i class="fas fa-arrow-up"></i> +{{ $newUsersThisMonth ?? 0 }} bulan ini
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="dashboard-card stat-card card-success">
            <div class="position-relative">
                <h2 class="stat-number">{{ $activeStudents ?? 0 }}</h2>
                <p class="stat-label">Siswa Aktif</p>
                <i class="fas fa-user-check stat-icon"></i>
                <div class="stat-trend">
                    <small class="text-info">Status: Booking Paid - Meeting Joined</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="dashboard-card stat-card card-warning">
            <div class="position-relative">
                <h2 class="stat-number">{{ $totalTransactions ?? 0 }}</h2>
                <p class="stat-label">Total Transaksi</p>
                <i class="fas fa-credit-card stat-icon"></i>
                <div class="stat-trend">
                    <small class="text-warning">{{ $pendingTransactions ?? 0 }} menunggu verifikasi</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="dashboard-card stat-card card-info">
            <div class="position-relative">
                <h2 class="stat-number">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h2>
                <p class="stat-label">Total Pendapatan</p>
                <i class="fas fa-chart-line stat-icon"></i>
                <div class="stat-trend">
                    <small class="text-success">Dari transaksi completed</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Distribution Cards -->
<div class="row mb-4">
    @php
        $statusLabels = [
            'registered' => ['label' => 'Baru Daftar', 'icon' => 'fa-user-plus', 'color' => 'light', 'textColor' => 'text-secondary'],
            'booking_paid' => ['label' => 'Booking Paid', 'icon' => 'fa-money-bill', 'color' => 'primary'],
            'meeting_joined' => ['label' => 'Meeting Joined', 'icon' => 'fa-video', 'color' => 'info'],
            'dp_paid' => ['label' => 'DP Paid', 'icon' => 'fa-check-circle', 'color' => 'success'],
            'active' => ['label' => 'Kelas Aktif', 'icon' => 'fa-chalkboard-teacher', 'color' => 'warning'],
            'ready_depart' => ['label' => 'Siap Berangkat', 'icon' => 'fa-plane', 'color' => 'danger'],
        ];
    @endphp

    @foreach($statusLabels as $key => $info)
    <div class="col-xl-2 col-md-4 mb-3">
        <div class="dashboard-card stat-card card-{{ $info['color'] }}">
            <div class="position-relative text-center">
                <h3 class="stat-number {{ $info['textColor'] ?? '' }}">{{ $statusCounts[$key] ?? 0 }}</h3>
                <p class="stat-label small">{{ $info['label'] }}</p>
                <i class="fas {{ $info['icon'] }} stat-icon small"></i>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Charts and Analytics Row -->
<div class="row mb-4">
    <!-- Revenue Chart -->
    <div class="col-lg-8">
        <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">Pendapatan Bulanan</h4>
                <select class="form-select form-select-sm" style="width: auto;">
                    <option>2025</option>
                    <option>2024</option>
                </select>
            </div>
            <canvas id="revenueChart" height="80"></canvas>
        </div>
    </div>
    
    <!-- Transaction Types -->
    <div class="col-lg-4">
        <div class="dashboard-card">
            <h4 class="mb-3">Tipe Transaksi</h4>
            <div class="transaction-types">
                @foreach(['booking' => 'Booking Class', 'dp' => 'DP Program', 'pemantapan' => 'Pemantapan', 'pemberangkatan' => 'Pemberangkatan'] as $key => $label)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <span class="badge bg-{{ ['booking' => 'primary', 'dp' => 'success', 'pemantapan' => 'warning', 'pemberangkatan' => 'danger'][$key] }} me-2"></span>
                        {{ $label }}
                    </div>
                    <div>
                        <strong>{{ $transactionTypes[$key] ?? 0 }}</strong>
                        <small class="text-muted">transaksi</small>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities and Pending Actions -->
<div class="row">
    <!-- Recent Activities -->
    <div class="col-lg-8">
        <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Aktivitas Terbaru</h4>
                <a href="{{ route('dashboard.admin') ?? '#' }}" class="btn btn-outline-primary btn-sm">
                    Lihat Semua
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Aktivitas</th>
                            <th>Status</th>
                            <th>Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentActivities as $activity)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($activity->user && $activity->user->photo)
                                        <img src="{{ Storage::url($activity->user->photo) }}" alt="User" class="rounded-circle me-2" width="32" height="32">
                                    @else
                                        <div class="bg-secondary rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="fas fa-user text-white" style="font-size: 14px;"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-semibold">{{ $activity->user->name ?? 'Unknown User' }}</div>
                                        <small class="text-muted">{{ $activity->user->email ?? '' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>{{ $activity->type }}</div>
                                <small class="text-muted">Rp {{ number_format($activity->amount, 0, ',', '.') }}</small>
                            </td>
                            <td>
                                <span class="badge bg-{{ $activity->status == 'Completed' ? 'success' : ($activity->status == 'Pending' ? 'warning' : 'secondary') }}">
                                    {{ $activity->status }}
                                </span>
                            </td>
                            <td>
                                <div>{{ $activity->created_at->format('d M Y') }}</div>
                                <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                            </td>
                            <td>
                                @if($activity->status === 'Verification')
                                    <button class="btn btn-sm btn-outline-primary" onclick="handleActivity({{ $activity->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak ada aktivitas terbaru</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Pending Actions & Quick Stats -->
    <div class="col-lg-4">
        <div class="dashboard-card mb-4">
            <h4 class="mb-3">Perlu Perhatian</h4>
            <div class="pending-actions">
                @if($pendingPayments ?? 0 > 0)
                <div class="alert alert-warning d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <div>
                        <strong>{{ $pendingPayments }} Pembayaran</strong><br>
                        <small>Menunggu verifikasi</small>
                    </div>
                    <a href="{{ route('admin.transaksi', ['status' => 'verification']) ?? '#' }}" class="btn btn-sm btn-warning ms-auto">
                        Cek
                    </a>
                </div>
                @endif
                
                @if($expiredBookings ?? 0 > 0)
                <div class="alert alert-danger d-flex align-items-center">
                    <i class="fas fa-clock me-2"></i>
                    <div>
                        <strong>{{ $expiredBookings }} Booking Kedaluwarsa</strong><br>
                        <small>Perlu tindak lanjut</small>
                    </div>
                    <a href="#" class="btn btn-sm btn-danger ms-auto">
                        Lihat
                    </a>
                </div>
                @endif
                
                @if($newRegistrations ?? 0 > 0)
                <div class="alert alert-info d-flex align-items-center">
                    <i class="fas fa-user-plus me-2"></i>
                    <div>
                        <strong>{{ $newRegistrations }} Pendaftaran Baru</strong><br>
                        <small>Hari ini</small>
                    </div>
                    <a href="{{ route('admin.usersManage') ?? '#' }}" class="btn btn-sm btn-info ms-auto">
                        Lihat
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate numbers
    const statNumbers = document.querySelectorAll('.stat-number');
    statNumbers.forEach(number => {
        const finalText = number.textContent;
        const finalNumber = parseInt(finalText.replace(/[^0-9]/g, ''));

        if (finalNumber > 0) {
            let currentNumber = 0;
            const increment = Math.ceil(finalNumber / 50);

            const timer = setInterval(() => {
                currentNumber += increment;
                if (currentNumber >= finalNumber) {
                    number.textContent = finalText;
                    clearInterval(timer);
                } else {
                    if (finalText.includes('Rp')) {
                        number.textContent = 'Rp ' + currentNumber.toLocaleString('id-ID');
                    } else {
                        number.textContent = currentNumber.toLocaleString('id-ID');
                    }
                }
            }, 20);
        }
    });

    // Revenue Chart
    const ctx = document.getElementById('revenueChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Pendapatan (Juta Rupiah)',
                    data: @json($monthlyRevenue ?? []),
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value + 'jt';
                            }
                        }
                    }
                }
            }
        });
    }

    // Auto refresh every 5 minutes
    setInterval(function() { location.reload(); }, 300000);
});

function handleActivity(activityId) {
    console.log('Handling activity:', activityId);
}
</script>
@endpush
@endsection
