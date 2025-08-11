@extends('layouts.dashboard')
@section('title', 'Dashboard')

@section('content')


{{-- Toast Container untuk Flash Messages dari Middleware --}}
@if(session('success') || session('error') || session('warning') || session('info'))
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    @if(session('success'))
        <div class="toast show align-items-center text-bg-success border-0 shadow-lg" role="alert" data-bs-delay="5000">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Berhasil!</strong><br>
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="toast show align-items-center text-bg-danger border-0 shadow-lg" role="alert" data-bs-delay="8000">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Perhatian!</strong><br>
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif

    @if(session('warning'))
        <div class="toast show align-items-center text-bg-warning border-0 shadow-lg" role="alert" data-bs-delay="6000">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Peringatan!</strong><br>
                    {{ session('warning') }}
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif

    @if(session('info'))
        <div class="toast show align-items-center text-bg-info border-0 shadow-lg" role="alert" data-bs-delay="5000">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Informasi</strong><br>
                    {{ session('info') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif
</div>
@endif

<div class="dashboard-container">
    <!-- Error Display -->
    @if(isset($error))
        <div class="alert-modern alert-danger">
            <div class="alert-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="alert-content">
                <strong>Error:</strong> {{ $error }}
            </div>
        </div>
    @endif

    <!-- Welcome Hero Section -->
    <div class="hero-card">
        <div class="hero-background"></div>
        <div class="hero-content">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="hero-text">
                        <h1 class="hero-title">
                            Selamat Datang, 
                            <span class="hero-name">{{ Auth::user()->name ?? 'User' }}!</span>
                        </h1>
                        <p class="hero-subtitle">
                            Tetap terhubung dengan informasi terbaru seputar pelatihan dan proses belajar Anda di 
                            <strong>LPK Amarta Bangun Indonesia</strong>.
                        </p>
                        <div class="hero-stats">
                            <div class="stat-item">
                                <i class="fas fa-clock"></i>
                                <span>{{ now()->format('H:i') }} WIB</span>
                            </div>
                            <div class="stat-divider">•</div>
                            <div class="stat-item">
                                <i class="fas fa-calendar"></i>
                                <span>{{ now()->format('d F Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-end d-none d-lg-block">
                    <div class="hero-illustration">
                        <div class="illustration-circle">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Card -->
    <div class="status-card">
        <div class="status-header">
            <div class="status-icon">
                <i class="fas fa-user-circle"></i>
            </div>
            <div class="status-content">
                <h3 class="status-title">Status Pembelajaran Anda</h3>
                @if(isset($userStatusId))
                    <div class="status-badge status-level-{{ $userStatusId }}">
                        <div class="status-indicator"></div>
                        <div class="status-text">
                            @switch($userStatusId)
                                @case(1) 
                                    <strong>New Registrant</strong>
                                    <span>Silakan lakukan pembayaran booking untuk melanjutkan</span>
                                    @break
                                @case(2) 
                                    <strong>Paid Student</strong>
                                    <span>Silakan gabung ke jadwal meeting yang telah ditentukan</span>
                                    @break
                                @case(3) 
                                    <strong>Meeting Joined</strong>
                                    <span>Silakan lanjutkan dengan pembayaran DP</span>
                                    @break
                                @case(4) 
                                    <strong>DP Paid</strong>
                                    <span>Kelas Anda akan segera diaktifkan</span>
                                    @break
                                @case(5) 
                                    <strong>Active Student</strong>
                                    <span>Selamat belajar dan semangat!</span>
                                    @break
                                @default 
                                    <strong>Unknown Status</strong>
                                    <span>Hubungi administrator untuk informasi lebih lanjut</span>
                            @endswitch
                        </div>
                    </div>
                @else
                    <div class="status-badge status-unknown">
                        <div class="status-indicator"></div>
                        <div class="status-text">
                            <strong>Status Tidak Tersedia</strong>
                            <span>Hubungi administrator untuk informasi status</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Progress Bar -->
        @if(isset($userStatusId))
        <div class="progress-section">
            <div class="progress-track">
                <div class="progress-fill" style="width: {{ ($userStatusId / 5) * 100 }}%"></div>
            </div>
            <div class="progress-steps">
                @for($i = 1; $i <= 5; $i++)
                    <div class="progress-step {{ $i <= $userStatusId ? 'active' : '' }}">
                        <div class="step-circle">{{ $i }}</div>
                    </div>
                @endfor
            </div>
        </div>
        @endif
    </div>

    <!-- Announcements Section -->
    <div class="announcements-section">
        <div class="section-header">
            <div class="header-content">
                <h2 class="section-title">
                    <i class="fas fa-bullhorn"></i>
                    Pengumuman
                </h2>
                <p class="section-subtitle">Informasi terbaru untuk Anda</p>
            </div>
            <div class="header-badge">
                <span class="count-badge">{{ $announcements->count() ?? 0 }}</span>
            </div>
        </div>

        <div class="announcements-content">
            @if($announcements->count())
                <div class="announcements-list">
                    @foreach($announcements as $index => $announcement)
                        <div class="announcement-card 
                                target_audience-{{ str_replace(' ', '_', strtolower($announcement->target_audience)) }} 
                                priority-{{ strtolower($announcement->priority) }}" 
                        style="animation-delay: {{ $index * 0.1 }}s">

                            
                            <!-- Priority Indicator -->
                            <div class="priority-bar"></div>
                            
                            <div class="announcement-header">
                                <div class="announcement-icon">
                                    @if($announcement->target_audience == 'new registrants')
                                        <i class="fas fa-exclamation-triangle"></i>
                                    @elseif($announcement->target_audience == 'paid students' || $announcement->target_audience == 'active students')
                                        <i class="fas fa-check"></i>
                                    @elseif($announcement->target_audience == 'all students')
                                        <i class="fas fa-info-circle"></i>
                                    @else
                                        <i class="fas fa-info-circle"></i>
                                    @endif
                                </div>

                                
                                <div class="announcement-title-section">
                                    <h4 class="announcement-title">{{ $announcement->title }}</h4>
                                    <div class="announcement-meta">
                                        <span class="target-audience">
                                            <i class="fas fa-users"></i>
                                            {{ ucfirst($announcement->target_audience) }}
                                        </span>
                                        <span class="announcement-time">
                                            <i class="fas fa-clock"></i>
                                            {{ $announcement->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="priority-badge">
                                    <span class="badge-text">{{ ucfirst($announcement->priority) }}</span>
                                </div>
                            </div>

                            <div class="announcement-body">
                                <p class="announcement-content">{{ $announcement->content }}</p>
                            </div>

                            <!-- Action Section -->
                           @php
                                $pendingBooking = \App\Models\Transaction::where('user_id', Auth::id())
                                    ->where('type', 'booking')
                                    ->whereIn('status', ['Pending', 'Verification']) // Perbaikan disini
                                    ->latest()
                                    ->first();

                                $userStatus = $userStatusId ?? 1;
                            @endphp

                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <!-- Kondisi berdasarkan status user -->
                            @if($userStatus == 1)
                                {{-- Status: New Registrant - Tampilkan form booking --}}
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="text-warning">
                                            <i class="fas fa-credit-card me-2"></i>
                                            Booking Kelas
                                        </h5>

                                        @if($pendingBooking)
                                            @if($pendingBooking->status === 'Pending')
                                                <p class="text-muted">Kamu sudah membuat transaksi booking yang belum dibayar.</p>
                                                <a href="{{ route('transaksi.booking', $pendingBooking) }}" class="btn btn-warning">
                                                    <i class="fas fa-clock me-2"></i>
                                                    Lanjutkan Pembayaran Booking
                                                </a>
                                            @elseif($pendingBooking->status === 'Verification')
                                                <p class="text-muted">Pembayaran booking Anda sedang diverifikasi.</p>
                                                <a href="{{ route('transaksi.booking', $pendingBooking) }}" class="btn btn-warning">
                                                    <i class="fas fa-spinner fa-spin me-2"></i>
                                                    Lihat Status Pembayaran
                                                </a>
                                            @endif
                                        @else
                                            <p class="text-muted mb-3">Silakan lakukan pembayaran booking untuk melanjutkan proses pendaftaran.</p>
                                            <form method="POST" action="{{ route('transaksi.booking.createBooking') }}">
                                                @csrf
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-money-bill-wave me-2"></i>
                                                    Bayar Booking Rp500.000
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>

                            @elseif($userStatus == 2)
                                {{-- Status: Paid Student - Tampilkan link Google Meet --}}
                                <div class="card mb-3 border-info">
                                    <div class="card-body">
                                        <h5 class="text-info">
                                            <i class="fas fa-video me-2"></i>
                                            Link Meeting Kelas
                                        </h5>
                                            @if(isset($announcement) && !empty($announcement->meet_link))
                                                <p class="text-muted mb-3">
                                                    Pembayaran booking Anda sudah berhasil. Silakan bergabung dengan meeting kelas sesuai jadwal berikut:
                                                </p>

                                                @if(!empty($announcement->scheduled_at))
                                                    <p>
                                                        <i class="fas fa-calendar-alt me-2"></i>
                                                        {{ \Carbon\Carbon::parse($announcement->scheduled_at)->translatedFormat('l, d F Y') }}
                                                        <br>
                                                        <i class="fas fa-clock me-2"></i>
                                                        {{ \Carbon\Carbon::parse($announcement->scheduled_at)->format('H:i') }} WIB
                                                    </p>
                                                @endif

                                                <div class="d-grid gap-2">
                                                    <a href="{{ $announcement->meet_link }}" target="_blank" class="btn btn-info">
                                                        <i class="fas fa-external-link-alt me-2"></i>
                                                        Gabung Google Meet
                                                    </a>
                                                </div>
                                                <small class="text-muted d-block mt-2">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Link akan membuka di tab baru. Pastikan Anda sudah menginstall Google Meet atau menggunakan browser yang mendukung.
                                                </small>
                                            @else
                                                <div class="alert alert-warning" role="alert">
                                                    <i class="fas fa-clock me-2"></i>
                                                    Link Google Meet belum tersedia. Admin akan segera memberikan link meeting.
                                                </div>
                                            @endif

                                    </div>
                                </div>

                            @elseif($userStatus >= 3 && $userStatus <= 5)
                                {{-- Status: Meeting Joined sampai Ready to Depart - Tampilkan tombol ke halaman keuangan --}}
                                <div class="card mb-3 border-success">
                                    <div class="card-body">
                                        <h5 class="text-success">
                                            <i class="fas fa-calculator me-2"></i>
                                            Pembayaran Keuangan
                                        </h5>

                                        @if($userStatus == 3)
                                            <p class="text-muted mb-3">
                                                Anda sudah bergabung dalam meeting. Silakan lanjutkan dengan pembayaran DP (Down Payment) melalui halaman keuangan.
                                            </p>
                                        @elseif($userStatus == 4)
                                            <p class="text-muted mb-3">
                                                DP Anda sudah dibayar. Silakan lengkapi pembayaran sisanya melalui halaman keuangan.
                                            </p>
                                        @elseif($userStatus == 5)
                                            <p class="text-muted mb-3">
                                                Status Anda sudah aktif. Anda dapat melihat riwayat pembayaran dan informasi keuangan lainnya.
                                            </p>
                                        @endif

                                        <div class="d-grid gap-2">
                                            <a href="{{ route('users.keuangan') }}" class="btn btn-success">
                                                <i class="fas fa-money-check-alt me-2"></i>
                                                Buka Halaman Keuangan
                                            </a>
                                        </div>

                                        <small class="text-muted d-block mt-2">
                                            <i class="fas fa-shield-alt me-1"></i>
                                            Semua transaksi pembayaran dilakukan melalui halaman keuangan untuk keamanan dan kemudahan tracking.
                                        </small>
                                    </div>
                                </div>

                            @else
                                {{-- Status tidak dikenali --}}
                                <div class="card mb-3 border-secondary">
                                    <div class="card-body">
                                        <h5 class="text-secondary">
                                            <i class="fas fa-question-circle me-2"></i>
                                            Status Tidak Dikenali
                                        </h5>
                                        <p class="text-muted mb-3">
                                            Status Anda tidak dapat diidentifikasi. Silakan hubungi administrator untuk mendapatkan bantuan.
                                        </p>
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('contact.admin') }}" class="btn btn-secondary">
                                                <i class="fas fa-headset me-2"></i>
                                                Hubungi Administrator
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            <!-- Footer -->
                            <div class="announcement-footer">
                                <div class="footer-info">
                                    <span class="created-date">{{ $announcement->created_at->format('d M Y, H:i') }}</span>
                                    @if($announcement->type != 'manual')
                                        <span class="auto-type">
                                            <i class="fas fa-robot"></i>
                                            Auto: {{ ucfirst(str_replace('auto ', '', $announcement->type)) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-illustration">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <div class="empty-content">
                        <h3 class="empty-title">Belum Ada Pengumuman</h3>
                        <p class="empty-subtitle">Pengumuman dan informasi terbaru akan muncul di sini</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>


@push('styles')
<style>
    :root {
        --primary: #0d5ea6;
        --primary-dark: #4f46e5;
        --primary-light: #a5b4fc;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
        --radius: 16px;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    }

    .dashboard-container {
        padding: 2rem 1rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Alert Styles */
    .alert-modern {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem 1.5rem;
        border-radius: var(--radius);
        margin-bottom: 2rem;
        border: none;
        box-shadow: var(--shadow);
    }

    .alert-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: var(--danger);
    }

    .alert-icon {
        font-size: 1.25rem;
        margin-top: 0.125rem;
    }

    /* Hero Card */
    .hero-card {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border-radius: var(--radius);
        overflow: hidden;
        position: relative;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-xl);
    }

    .hero-background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.3;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        padding: 3rem 2rem;
        color: white;
    }

    .hero-title {
        font-size: 2.25rem;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 1rem;
    }

    .hero-name {
        background: linear-gradient(45deg, #fbbf24, #f59e0b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-subtitle {
        font-size: 1.125rem;
        opacity: 0.9;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .hero-stats {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.9rem;
        opacity: 0.8;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .stat-divider {
        opacity: 0.5;
    }

    .hero-illustration {
        text-align: center;
    }

    .illustration-circle {
        width: 120px;
        height: 120px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .illustration-circle i {
        font-size: 3rem;
        opacity: 0.8;
    }

    /* Status Card */
    .status-card {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow-lg);
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid var(--gray-200);
    }

    .status-header {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .status-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, var(--primary-light), var(--primary));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .status-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 1rem;
    }

    .status-badge {
        background: var(--gray-50);
        border-radius: 12px;
        padding: 1rem 1.5rem;
        border: 1px solid var(--gray-200);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .status-badge.status-level-1 { border-left: 4px solid var(--warning); }
    .status-badge.status-level-2 { border-left: 4px solid var(--info); }
    .status-badge.status-level-3 { border-left: 4px solid var(--primary); }
    .status-badge.status-level-4 { border-left: 4px solid var(--primary-dark); }
    .status-badge.status-level-5 { border-left: 4px solid var(--success); }

    .status-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .status-level-1 .status-indicator { background: var(--warning); }
    .status-level-2 .status-indicator { background: var(--info); }
    .status-level-3 .status-indicator { background: var(--primary); }
    .status-level-4 .status-indicator { background: var(--primary-dark); }
    .status-level-5 .status-indicator { background: var(--success); }

    .status-text strong {
        color: var(--gray-800);
        display: block;
        font-size: 1rem;
        margin-bottom: 0.25rem;
    }

    .status-text span {
        color: var(--gray-600);
        font-size: 0.9rem;
    }

    /* Progress Section */
    .progress-section {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--gray-200);
    }

    .progress-track {
        height: 4px;
        background: var(--gray-200);
        border-radius: 2px;
        margin-bottom: 1rem;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary), var(--success));
        border-radius: 2px;
        transition: width 1s ease;
    }

    .progress-steps {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .progress-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
    }

    .step-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--gray-300);
        color: var(--gray-600);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }

    .progress-step.active .step-circle {
        background: var(--primary);
        color: white;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    /* Announcements Section */
    .announcements-section {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        border: 1px solid var(--gray-200);
    }

    .section-header {
        padding: 2rem;
        background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .section-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--gray-800);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title i {
        color: var(--primary);
    }

    .section-subtitle {
        color: var(--gray-600);
        margin: 0.5rem 0 0;
        font-size: 0.95rem;
    }

    .count-badge {
        background: var(--primary);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.875rem;
    }

    /* Announcements Content */
    .announcements-content {
        padding: 2rem;
    }

    .announcements-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        max-height: 800px;
        overflow-y: auto;
        padding-right: 0.5rem;
    }

    /* Custom Scrollbar */
    .announcements-list::-webkit-scrollbar {
        width: 6px;
    }

    .announcements-list::-webkit-scrollbar-track {
        background: var(--gray-100);
        border-radius: 3px;
    }

    .announcements-list::-webkit-scrollbar-thumb {
        background: var(--gray-400);
        border-radius: 3px;
    }

    .announcements-list::-webkit-scrollbar-thumb:hover {
        background: var(--gray-500);
    }

    /* Announcement Card */
    .announcement-card {
        background: white;
        border: 1px solid var(--gray-200);
        border-radius: var(--radius);
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
        animation: slideInUp 0.6s ease forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    @keyframes slideInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .announcement-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
        border-color: var(--primary);
    }

    .priority-bar {
        height: 4px;
        width: 100%;
    }

   .announcement-card.target_audience-new_registrants .priority-bar {
    background: linear-gradient(90deg, var(--danger), #dc2626);
}

   .announcement-card.target_audience-paid_students .priority-bar,
.announcement-card.target_audience-active_students .priority-bar {
    background: linear-gradient(90deg, var(--success), #16a34a);
}
    .announcement-card.target_audience-all_students .priority-bar {
    background: linear-gradient(90deg, var(--warning), #d97706);
}

    .announcement-header {
        padding: 1.5rem 2rem 0;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .announcement-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

   .announcement-card.target_audience-new_registrants .announcement-icon {
    background: #fee2e2;
    color: var(--danger);
}

   .announcement-card.target_audience-paid_students .announcement-icon,
.announcement-card.target_audience-active_students .announcement-icon {
    background: #dcfce7;
    color: var(--success);
}
  .announcement-card.target_audience-all_students .announcement-icon {
    background: #fef3c7;
    color: var(--warning);
}

    .announcement-title-section {
        flex: 1;
    }

    .announcement-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0 0 0.5rem;
        line-height: 1.4;
    }

    .announcement-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.875rem;
        color: var(--gray-500);
    }

    .target-audience,
    .announcement-time {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        justify-content: center;
    }

    .priority-badge {
        flex-shrink: 0;
    }

    .badge-text {
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .announcement-card.priority-high .badge-text {
        background: var(--danger);
        color: white;
    }

    .announcement-card.priority-medium .badge-text {
        background: var(--warning);
        color: white;
    }

    .announcement-card.priority-low .badge-text {
        background: var(--info);
        color: white;
    }

    .announcement-body {
        padding: 1rem 2rem;
    }

    .announcement-content {
        color: var(--gray-700);
        line-height: 1.6;
        margin: 0;
    }

    .announcement-action {
        padding: 0 2rem 1.5rem;
    }

    .action-btn {
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 0.875rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .action-btn:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-content {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        position: relative;
        z-index: 2;
    }

    .btn-ripple {
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .action-btn:hover .btn-ripple {
        left: 100%;
    }

    .announcement-footer {
        padding: 1rem 2rem 1.5rem;
        border-top: 1px solid var(--gray-100);
        background: var(--gray-50);
    }

    .footer-info {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.8rem;
        color: var(--gray-500);
    }

    .auto-type {
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-illustration i {
        font-size: 4rem;
        color: var(--gray-300);
        margin-bottom: 1.5rem;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--gray-600);
        margin-bottom: 0.5rem;
    }

    .empty-subtitle {
        color: var(--gray-500);
        margin: 0;
    }

    /* Mobile Responsive CSS untuk Dashboard - Max Width: 768px */

    @media (max-width: 768px) {
        /* Container dan Layout Utama */
        .dashboard-container {
            padding: 1rem 0.75rem;
        }

        /* Hero Card Mobile */
        .hero-card {
            margin-bottom: 1.5rem;
            border-radius: 12px;
        }

        .hero-content {
            padding: 2rem 1.5rem;
            text-align: center;
        }

        .hero-title {
            font-size: 1.75rem;
            line-height: 1.3;
            margin-bottom: 0.75rem;
        }

        .hero-subtitle {
            font-size: 1rem;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .hero-stats {
            justify-content: center;
            flex-direction: column;
            gap: 0.5rem;
            font-size: 0.85rem;
        }

        .stat-divider {
            display: none;
        }

        .hero-illustration {
            display: none;
        }

        /* Status Card Mobile */
        .status-card {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-radius: 12px;
        }

        .status-header {
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .status-icon {
            align-self: center;
        }

        .status-title {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .status-badge {
            flex-direction: column;
            gap: 0.75rem;
            padding: 1rem;
            text-align: center;
        }

        .status-text strong {
            font-size: 0.95rem;
        }

        .status-text span {
            font-size: 0.85rem;
        }

        /* Progress Section Mobile */
        .progress-section {
            margin-top: 1rem;
            padding-top: 1rem;
        }

        .progress-steps {
            gap: 0.5rem;
        }

        .step-circle {
            width: 28px;
            height: 28px;
            font-size: 0.8rem;
        }

        /* Announcements Section Mobile */
        .announcements-section {
            height: 100%;
            border-radius: 12px;
        }

        .section-header {
            padding: 1.5rem;
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .section-title {
            font-size: 1.5rem;
            justify-content: center;
        }

        .section-subtitle {
            text-align: center;
        }

        .header-badge {
            align-self: center;
        }

        .count-badge {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
        }

        /* Announcements Content Mobile */
        .announcements-content {
            padding: 1rem;
        }

        .announcements-list {
            gap: 1rem;
            max-height: 800px;
            padding-right: 0;
        }

        /* Announcement Card Mobile */
        .announcement-card {
            border-radius: 12px;
        }

        .announcement-header {
            padding: 1rem 1.25rem 0;
            flex-direction: column;
            gap: 0.75rem;
            text-align: center;
        }

        .announcement-icon {
            align-self: center;
            width: 36px;
            height: 36px;
            font-size: 1.1rem;
        }

       .announcement-title-section {
            margin-left: 40px;
            justify-content: center;
            align-items: center; /* biar elemen dalam flex sejajar tengah */
            text-align: center; /* biar teks rata tengah */
        }

        .announcement-title {
            font-size: 1.1rem;
            margin-bottom: 0.75rem;
        }

        .announcement-meta {
            justify-content: center;
            flex-direction: column;
            gap: 0.5rem;
            font-size: 0.8rem;
            text-align: center;
        }

        .priority-badge {
            align-self: center;
        }

        .badge-text {
            padding: 0.3rem 0.6rem;
            font-size: 0.7rem;
        }

        .announcement-body {
            padding: 1rem 1.25rem;
            text-align: center;
        }

        .announcement-content {
            font-size: 0.9rem;
            line-height: 1.5;
        }

        /* Action Section Mobile */
        .announcement-action {
            padding: 0 1.25rem 1rem;
        }

        .action-btn {
            width: 100%;
            padding: 1rem;
            font-size: 0.9rem;
            border-radius: 10px;
        }

        .btn-content {
            justify-content: center;
        }

        .announcement-footer {
            padding: 0.75rem 1.25rem 1rem;
        }

        .footer-info {
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            text-align: center;
        }

        /* Card Action Sections Mobile */
        .card {
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .card-body {
            padding: 1rem;
        }

        .card h5 {
            font-size: 1rem;
            margin-bottom: 0.75rem;
            text-align: center;
        }

        .card p {
            font-size: 0.85rem;
            text-align: center;
            margin-bottom: 1rem;
        }

        .btn {
            width: 100%;
            padding: 0.8rem;
            font-size: 0.9rem;
            border-radius: 8px;
        }

        .btn i {
            margin-right: 0.5rem;
        }

        .d-grid {
            margin-bottom: 0.75rem;
        }

        .card small {
            font-size: 0.75rem;
            text-align: center;
            display: block;
            line-height: 1.4;
        }

        /* Alert Styles Mobile */
        .alert-modern {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 10px;
            flex-direction: column;
            gap: 0.75rem;
            text-align: center;
        }

        .alert-icon {
            font-size: 1.5rem;
            align-self: center;
        }

        .alert-content {
            font-size: 0.9rem;
        }

        /* Toast Mobile */
        .toast-container {
            position: fixed !important;
            top: 10px !important;
            right: 10px !important;
            left: 10px !important;
            padding: 10px !important;
            z-index: 10000 !important;
        }

        .toast {
            min-width: auto;
            max-width: none;
            width: 100%;
            font-size: 0.85rem;
            border-radius: 8px;
        }

        .toast-body {
            padding: 0.75rem;
            line-height: 1.3;
            text-align: center;
        }

        .toast .btn-close {
            margin: 0.2rem;
        }

        /* Empty State Mobile */
        .empty-state {
            padding: 3rem 1rem;
        }

        .empty-illustration i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .empty-title {
            font-size: 1.25rem;
        }

        .empty-subtitle {
            font-size: 0.9rem;
            line-height: 1.4;
        }

        /* Form Elements Mobile */
        form {
            width: 100%;
        }

        .form-control {
            font-size: 0.9rem;
            padding: 0.75rem;
        }

        /* Navigation Mobile (jika ada) */
        .nav-tabs {
            flex-direction: column;
            border-bottom: none;
        }

        .nav-link {
            text-align: center;
            border-radius: 8px;
            margin-bottom: 0.5rem;
        }

        /* Utility Classes Mobile */
        .d-block-mobile {
            display: block !important;
        }

        .d-none-mobile {
            display: none !important;
        }

        .text-center-mobile {
            text-align: center !important;
        }

        .mb-mobile {
            margin-bottom: 1rem !important;
        }

        .p-mobile {
            padding: 1rem !important;
        }

        /* Spacing Adjustments */
        .row {
            margin: 0;
        }

        .col-12 {
            padding: 0;
        }

        /* Custom Mobile Scrollbar */
        .announcements-list::-webkit-scrollbar {
            width: 4px;
        }

        .announcements-list::-webkit-scrollbar-track {
            background: var(--gray-100);
            border-radius: 2px;
        }

        .announcements-list::-webkit-scrollbar-thumb {
            background: var(--gray-400);
            border-radius: 2px;
        }

        /* Animation Adjustments Mobile */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Button Hover Effects Mobile (Touch) */
        .action-btn:active {
            transform: scale(0.98);
        }

        .announcement-card:active {
            transform: translateY(-2px);
        }

        /* Status Indicator Mobile */
        .status-indicator {
            width: 10px;
            height: 10px;
        }

        /* Priority Colors Mobile */
        .priority-bar {
            height: 3px;
        }

        /* Typography Mobile */
        h1 { font-size: 1.75rem; }
        h2 { font-size: 1.5rem; }
        h3 { font-size: 1.25rem; }
        h4 { font-size: 1.1rem; }
        h5 { font-size: 1rem; }
        
        p, span, div {
            font-size: 0.9rem;
            line-height: 1.5;
        }

        /* Loading States Mobile */
        .btn:disabled {
            opacity: 0.6;
            transform: none;
        }

        /* Focus States Mobile */
        .btn:focus,
        .form-control:focus {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // {{-- JavaScript untuk Initialize Toast --}}
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all toasts
        const toastElList = [].slice.call(document.querySelectorAll('.toast'));
        const toastList = toastElList.map(function (toastEl) {
            return new bootstrap.Toast(toastEl, {
                autohide: true,
                delay: toastEl.dataset.bsDelay || 3000
            });
        });

        // Show all toasts
        toastList.forEach(toast => {
            toast.show();
        });

        // Add sound notification for error messages (optional)
        const errorToast = document.querySelector('.text-bg-danger');
        if (errorToast) {
            // You can add sound here if needed
            console.log('Error notification displayed');
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Handle action button clicks
        document.querySelectorAll('.announcement-action-button').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const action = this.dataset.action;
                const url = this.dataset.actionUrl;

                // Add loading state
                const originalContent = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
                this.disabled = true;

                setTimeout(() => {
                    switch (action) {
                        case 'payment_booking':
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = url;

                            const token = document.createElement('input');
                            token.type = 'hidden';
                            token.name = '_token';
                            token.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                            form.appendChild(token);
                            document.body.appendChild(form);
                            form.submit();
                            break;

                        case 'show_meet_link':
                        case 'payment_dp':
                        case 'info_class_active':
                            window.location.href = url;
                            break;

                        default:
                            console.warn('Unknown action:', action);
                            this.innerHTML = originalContent;
                            this.disabled = false;
                    }
                }, 500);
            });
        });

        // Animate progress bar on load
        setTimeout(() => {
            const progressFill = document.querySelector('.progress-fill');
            if (progressFill) {
                const targetWidth = progressFill.style.width;
                progressFill.style.width = '0%';
                setTimeout(() => {
                    progressFill.style.width = targetWidth;
                }, 300);
            }
        }, 500);

        // Auto-refresh announcements every 5 minutes
        let refreshInterval;
        
        function startAutoRefresh() {
            refreshInterval = setInterval(function() {
                // Add visual indicator for refresh
                const countBadge = document.querySelector('.count-badge');
                if (countBadge) {
                    const originalText = countBadge.textContent;
                    countBadge.innerHTML = '<i class="fas fa-sync-alt fa-spin"></i>';
                    
                    // Simulate refresh (in real app, you'd fetch new data)
                    setTimeout(() => {
                        countBadge.textContent = originalText;
                    }, 2000);
                }
                
                console.log('Auto-refresh announcements');
            }, 300000); // 5 minutes
        }

        // Start auto-refresh
        startAutoRefresh();

        // Pause auto-refresh when page is not visible
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                clearInterval(refreshInterval);
            } else {
                startAutoRefresh();
            }
        });

        // Add smooth scroll behavior for any anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add intersection observer for animation triggers
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, observerOptions);

        // Observe announcement cards for stagger animation
        document.querySelectorAll('.announcement-card').forEach(card => {
            observer.observe(card);
        });

        // Add click effect to cards
        document.querySelectorAll('.announcement-card').forEach(card => {
            card.addEventListener('click', function(e) {
                // Don't trigger if clicking on button
                if (e.target.closest('.action-btn')) return;
                
                // Add ripple effect
                const ripple = document.createElement('div');
                ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(99, 102, 241, 0.1);
                    pointer-events: none;
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    z-index: 1;
                `;
                
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                
                this.appendChild(ripple);
                
                setTimeout(() => ripple.remove(), 600);
            });
        });

        // Add CSS for ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
            
            .announcement-card {
                position: relative;
                overflow: hidden;
            }
        `;
        document.head.appendChild(style);
    });
</script>
@endpush
@endsection