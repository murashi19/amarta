@extends('layouts.dashboard')

@section('title', 'Profil Saya')

@section('content')
@push('styles')
    <style>
        :root {;
            --primary-color: #0d5ea6;
            --primary-dark: #4f46e5;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --radius: 12px;
            --radius-lg: 16px;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
        }

        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .profile-card {
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .profile-card:hover {
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        .profile-header {
            background: var(--primary-color);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
            opacity: 0.1;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            object-fit: cover;
            margin: 0 auto 1rem;
            position: relative;
            z-index: 1;
        }

        .profile-placeholder {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            position: relative;
            z-index: 1;
        }

        .profile-name {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .profile-email {
            opacity: 0.9;
            font-size: 0.95rem;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .badge-custom {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            margin: 0 0.25rem 0.5rem;
            display: inline-block;
            backdrop-filter: blur(10px);
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
            margin-top: 0.5rem;
        }

        .status-active {
            background: linear-gradient(135deg, var(--success-color), #059669);
            color: white;
        }

        .status-registered {
            background: linear-gradient(135deg, var(--warning-color), #d97706);
            color: white;
        }

        .profile-actions {
            padding: 1.5rem 2rem 2rem;
            display: flex;
            gap: 0.75rem;
            justify-content: center;
        }

        .btn-modern {
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius);
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-modern:hover::before {
            left: 100%;
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: white;
        }

        .btn-secondary-modern {
            background: white;
            color: var(--gray-700);
            border: 1px solid var(--gray-300);
        }

        .btn-secondary-modern:hover {
            background: var(--gray-50);
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
            color: var(--gray-700);
        }

        .info-section {
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--gray-200);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .section-header {
            background: var(--gray-50);
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-800);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-icon {
            width: 20px;
            height: 20px;
            color: var(--primary-color);
        }

        .section-content {
            padding: 2rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .info-label {
            font-weight: 600;
            color: var(--gray-600);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            color: var(--gray-800);
            font-size: 1rem;
            word-break: break-word;
        }

        .table-modern {
            border-collapse: separate;
            border-spacing: 0;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .table-modern th {
            background: var(--gray-50);
            padding: 1rem;
            font-weight: 600;
            color: var(--gray-700);
            border: none;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-modern td {
            padding: 1rem;
            border-top: 1px solid var(--gray-200);
            vertical-align: middle;
        }

        .table-modern tbody tr:hover {
            background: var(--gray-50);
        }

        .badge-type {
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: capitalize;
        }

        .badge-subscription {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-purchase {
            background: #e0e7ff;
            color: var(--primary-dark);
        }

        .badge-completed {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-failed {
            background: #fee2e2;
            color: #991b1b;
        }

        .meeting-card {
            background: white;
            border-radius: var(--radius);
            border: 1px solid var(--gray-200);
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .meeting-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: var(--primary-color);
        }

        .meeting-header {
            display: flex;
            justify-content: between;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .meeting-date {
            font-weight: 600;
            color: var(--gray-800);
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .meeting-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            background: #f0f9ff;
            border-radius: var(--radius);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .meeting-link:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-1px);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--gray-600);
        }

        .empty-icon {
            font-size: 3rem;
            color: var(--gray-400);
            margin-bottom: 1rem;
        }

        .toast-modern {
            border-radius: var(--radius);
            border: none;
            box-shadow: var(--shadow-lg);
            backdrop-filter: blur(10px);
        }

        .toast-success {
            background: rgba(16, 185, 129, 0.95);
            color: white;
        }

        .toast-error {
            background: rgba(239, 68, 68, 0.95);
            color: white;
        }

        @media (max-width: 768px) {
            .profile-container {
                padding: 1rem;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .profile-actions {
                flex-direction: column;
            }
            
            .section-content {
                padding: 1.5rem;
            }
            
            .meeting-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endpush
<div class="profile-container">
    <div class="row g-4">
        <!-- Profile Sidebar -->
        <div class="col-lg-4">
            <div class="profile-card">
                <div class="profile-header">
                    <!-- Profile Photo -->
                    @if($user->photo)
                        <img src="{{ Storage::url($user->photo) }}" 
                             class="profile-avatar" 
                             alt="Profile Photo">
                    @else
                        <div class="profile-placeholder">
                            <i class="fas fa-user fa-2x" style="opacity: 0.7;"></i>
                        </div>
                    @endif

                    <!-- User Info -->
                    <h2 class="profile-name">{{ $user->name }}</h2>
                    <p class="profile-email">{{ $user->email }}</p>
                    
                    <!-- Roles -->
                    <div class="mb-3">
                        @foreach($user->roles as $role)
                            <span class="badge-custom">{{ $role->name }}</span>
                        @endforeach
                    </div>
                    
                    <!-- Status -->
                    <span class="status-badge status-{{ $user->status->name == 'Active' ? 'active' : 'registered' }}">
                        {{ $user->status->name ?? 'Unknown' }}
                    </span>
                </div>

                <!-- Action Buttons -->
                <div class="profile-actions">
                    <a href="{{ route('users.editProfile') }}" class="btn-modern btn-primary-modern">
                        <i class="fas fa-edit"></i>
                        Edit Profil
                    </a>
                    <a href="#" class="btn-modern btn-secondary-modern">
                        <i class="fas fa-lock"></i>
                        Password
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Personal Information -->
            <div class="info-section">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-user-edit section-icon"></i>
                        Informasi Personal
                    </h3>
                </div>
                <div class="section-content">
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Nama Lengkap</span>
                            <span class="info-value">{{ $user->name ?: 'Belum diisi' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email</span>
                            <span class="info-value">{{ $user->email ?: 'Belum diisi' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Nomor Telepon</span>
                            <span class="info-value">{{ $user->phone_number ?: 'Belum diisi' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Jenis Kelamin</span>
                            <span class="info-value">{{ $user->gender ?: 'Belum diisi' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tempat Lahir</span>
                            <span class="info-value">{{ $user->birth_place ?: 'Belum diisi' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tanggal Lahir</span>
                            <span class="info-value">
                                {{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d F Y') : 'Belum diisi' }}
                            </span>
                        </div>
                        <div class="info-item" style="grid-column: 1 / -1;">
                            <span class="info-label">Alamat</span>
                            <span class="info-value">{{ $user->address ?: 'Belum diisi' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Pendidikan</span>
                            <span class="info-value">{{ $user->education_level ?: 'Belum diisi' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tanggal Gabung</span>
                            <span class="info-value">{{ $user->created_at->format('d F Y') }}</span>
                        </div>
                        @if($user->notes)
                        <div class="info-item" style="grid-column: 1 / -1;">
                            <span class="info-label">Catatan</span>
                            <span class="info-value">{{ $user->notes }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Transaction History -->
            @if($user->transactions->count())
            <div class="info-section">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-receipt section-icon"></i>
                        Riwayat Transaksi
                    </h3>
                </div>
                <div class="section-content">
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Dibayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->transactions as $trx)
                                <tr>
                                    <td>
                                        <div style="font-weight: 500;">
                                            {{ $trx->created_at->format('d M Y') }}
                                        </div>
                                        <small class="text-muted">{{ $trx->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge-type badge-{{ $trx->type }}">
                                            {{ $trx->type == 'subscription' ? 'Berlangganan' : 'Pembelian' }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong style="color: var(--gray-800);">
                                            Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                        </strong>
                                    </td>
                                    <td>
                                        <span class="badge-type badge-{{ strtolower($trx->status) }}">
                                            {{ $trx->status == 'Completed' ? 'Selesai' : ($trx->status == 'Pending' ? 'Menunggu' : 'Gagal') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($trx->paid_at)
                                            <div style="font-weight: 500;">
                                                {{ \Carbon\Carbon::parse($trx->paid_at)->format('d M Y') }}
                                            </div>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($trx->paid_at)->format('H:i') }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Meeting Schedule -->
            @if($user->meetings->count())
            <div class="info-section">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-video section-icon"></i>
                        Jadwal Meeting
                    </h3>
                </div>
                <div class="section-content">
                    @foreach($user->meetings->take(5) as $meeting)
                    <div class="meeting-card">
                        <div class="meeting-header">
                            <div class="flex-grow-1">
                                <div class="meeting-date">
                                    <i class="fas fa-calendar-alt" style="color: var(--primary-color);"></i>
                                    {{ \Carbon\Carbon::parse($meeting->schedule_at)->format('d F Y, H:i') }} WIB
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                @if($meeting->is_attended)
                                    <span class="badge-type badge-completed">Hadir</span>
                                @else
                                    <span class="badge-type badge-pending">Belum Hadir</span>
                                @endif
                            </div>
                        </div>
                        @if($meeting->meet_link)
                        <a href="{{ $meeting->meet_link }}" target="_blank" class="meeting-link">
                            <i class="fas fa-external-link-alt"></i>
                            Gabung Meeting
                        </a>
                        @endif
                    </div>
                    @endforeach
                    
                    @if($user->meetings->count() > 5)
                    <div class="text-center mt-3">
                        <a href="{{ route('meetings.index') }}" class="btn-modern btn-secondary-modern">
                            <i class="fas fa-eye"></i>
                            Lihat Semua ({{ $user->meetings->count() }})
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Empty State -->
            @if(!$user->transactions->count() && !$user->meetings->count())
            <div class="info-section">
                <div class="empty-state">
                    <i class="fas fa-inbox empty-icon"></i>
                    <h4 style="color: var(--gray-600); margin-bottom: 0.5rem;">Belum Ada Aktivitas</h4>
                    <p style="color: var(--gray-500);">Transaksi dan jadwal meeting Anda akan muncul di sini.</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Toast Messages -->
@if(session('success'))
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
    <div class="toast toast-modern toast-success show" role="alert">
        <div class="toast-header" style="background: rgba(255, 255, 255, 0.2); border: none; color: white;">
            <i class="fas fa-check-circle me-2"></i>
            <strong class="me-auto">Berhasil</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" style="color: white;">
            {{ session('success') }}
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
    <div class="toast toast-modern toast-error show" role="alert">
        <div class="toast-header" style="background: rgba(255, 255, 255, 0.2); border: none; color: white;">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong class="me-auto">Error</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" style="color: white;">
            {{ session('error') }}
        </div>
    </div>
</div>
@endif

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto hide toasts
            setTimeout(function() {
                const toasts = document.querySelectorAll('.toast');
                toasts.forEach(function(toast) {
                    const bsToast = new bootstrap.Toast(toast);
                    bsToast.hide();
                });
            }, 5000);
            
            // Smooth scroll for anchor links
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

            // Add loading states for buttons
            document.querySelectorAll('.btn-modern').forEach(button => {
                button.addEventListener('click', function(e) {
                    if (this.getAttribute('href') !== '#') {
                        const icon = this.querySelector('i');
                        const originalIcon = icon.className;
                        icon.className = 'fas fa-spinner fa-spin';
                        
                        setTimeout(() => {
                            icon.className = originalIcon;
                        }, 2000);
                    }
                });
            });
        });
    </script>
@endpush

@endsection