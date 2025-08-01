@extends('layouts.dashboardAdmin')

@section('title', 'Dashboard')

@section('content')
<!-- Welcome Card -->
<div class="dashboard-card welcome-card">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1>Welcome Back, {{ Auth::user()->name }}!</h1>
            <p class="mb-0">Here's what's happening with your learning platform today.</p>
        </div>
        <div class="col-md-4 text-end">
            <i class="fas fa-chart-line" style="font-size: 4rem; opacity: 0.3;"></i>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="dashboard-card stat-card card-primary">
            <div class="position-relative">
                <h2 class="stat-number">{{ $TotalSiswa ?? '1,234' }}</h2>
                <p class="stat-label">Total Siswa</p>
                <i class="fas fa-users stat-icon"></i>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="dashboard-card stat-card card-success">
            <div class="position-relative">
                <h2 class="stat-number">{{ $SiswaAktif ?? '856' }}</h2>
                <p class="stat-label">Siswa Aktif</p>
                <i class="fas fa-user-check stat-icon"></i>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="dashboard-card stat-card card-warning">
            <div class="position-relative">
                <h2 class="stat-number">{{ $SiswaSudahBekerja ?? '42' }}</h2>
                <p class="stat-label">Siswa Sudah Bekerja</p>
                <i class="fas fa-calendar-alt stat-icon"></i>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="dashboard-card stat-card card-info">
            <div class="position-relative">
                <h2 class="stat-number">${{ number_format($TotalPendapatan ?? 12450) }}</h2>
                <p class="stat-label">Total Revenue</p>
                <i class="fas fa-dollar-sign stat-icon"></i>
            </div>
        </div>
    </div>
</div>

<!-- Additional Stats Row -->
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="dashboard-card stat-card card-danger">
            <div class="position-relative">
                <h2 class="stat-number">{{ $pendingApprovals ?? '23' }}</h2>
                <p class="stat-label">Persetujuan Tertunda</p>
                <i class="fas fa-clock stat-icon"></i>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="dashboard-card stat-card card-success">
            <div class="position-relative">
                <h2 class="stat-number">{{ $completedTransactions ?? '198' }}</h2>
                <p class="stat-label">Transaksi Selesai</p>
                <i class="fas fa-check-circle stat-icon"></i>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="dashboard-card stat-card card-primary">
            <div class="position-relative">
                <h2 class="stat-number">{{ $activePackages ?? '15' }}</h2>
                <p class="stat-label">Active Packages</p>
                <i class="fas fa-box stat-icon"></i>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="dashboard-card stat-card card-warning">
            <div class="position-relative">
                <h2 class="stat-number">{{ $systemUptime ?? '95' }}%</h2>
                <p class="stat-label">System Uptime</p>
                <i class="fas fa-server stat-icon"></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row">
    <div class="col-lg-8">
        <div class="dashboard-card">
            <h4 class="mb-4">Recent Activities</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Action</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentActivities ?? [] as $activity)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/32" alt="User" class="rounded-circle me-2" width="32" height="32">
                                    <span>{{ $activity['user'] ?? 'Unknown User' }}</span>
                                </div>
                            </td>
                            <td>{{ $activity['action'] ?? 'No action' }}</td>
                            <td>{{ $activity['date'] ?? 'Unknown date' }}</td>
                            <td>
                                <span class="badge bg-{{ $activity['status_color'] ?? 'secondary' }}">
                                    {{ $activity['status'] ?? 'Unknown' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/32" alt="User" class="rounded-circle me-2" width="32" height="32">
                                    <span>John Doe</span>
                                </div>
                            </td>
                            <td>Registered for Tech Conference 2025</td>
                            <td>2 hours ago</td>
                            <td><span class="badge bg-success">Completed</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/32" alt="User" class="rounded-circle me-2" width="32" height="32">
                                    <span>Jane Smith</span>
                                </div>
                            </td>
                            <td>Created new event: Web Development Workshop</td>
                            <td>4 hours ago</td>
                            <td><span class="badge bg-primary">Active</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/32" alt="User" class="rounded-circle me-2" width="32" height="32">
                                    <span>Ahmad Hidayat</span>
                                </div>
                            </td>
                            <td>Payment received for Professional Package</td>
                            <td>1 day ago</td>
                            <td><span class="badge bg-success">Completed</span></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="dashboard-card">
            <h4 class="mb-4">Quick Actions</h4>
            <div class="d-grid gap-3">
                <a href="" class="btn btn-custom-primary">
                    <i class="fas fa-user-plus me-2"></i>Add New User
                </a>
                <a href="" class="btn btn-outline-success">
                    <i class="fas fa-plus-circle me-2"></i>Create Event
                </a>
                <a href="" class="btn btn-outline-warning">
                    <i class="fas fa-file-alt me-2"></i>Generate Report
                </a>
                <a href="" class="btn btn-outline-info">
                    <i class="fas fa-cogs me-2"></i>System Settings
                </a>
            </div>
        </div>
        
        <div class="dashboard-card">
            <h5 class="mb-3">System Status</h5>
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="small">Server Status</span>
                    <span class="badge bg-success">Online</span>
                </div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                </div>
            </div>
            
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="small">Database</span>
                    <span class="badge bg-success">Healthy</span>
                </div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 98%"></div>
                </div>
            </div>
            
            <div class="mb-0">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="small">Storage</span>
                    <span class="badge bg-warning">75%</span>
                </div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 75%"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Custom JavaScript untuk dashboard
    document.addEventListener('DOMContentLoaded', function() {
        // Animate numbers on load
        const statNumbers = document.querySelectorAll('.stat-number');
        statNumbers.forEach(number => {
            const finalNumber = number.textContent;
            let currentNumber = 0;
            const increment = Math.ceil(parseInt(finalNumber.replace(/[^0-9]/g, '')) / 100);
            
            const timer = setInterval(() => {
                currentNumber += increment;
                if (currentNumber >= parseInt(finalNumber.replace(/[^0-9]/g, ''))) {
                    number.textContent = finalNumber;
                    clearInterval(timer);
                } else {
                    number.textContent = currentNumber.toLocaleString();
                }
            }, 20);
        });
    });
</script>
@endsection