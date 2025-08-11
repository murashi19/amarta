@extends('layouts.dashboardAdmin')

@section('title', 'Profil Admin')

@section('content')
@push('styles')
    <style>
        :root {
            --color-primary: #0d5ea6;
            --color-secondary: #a6550d;
            --color-success: #24c224;
            --color-warning: #e2b11e;
            --color-danger: #ac2020;
            --color-info: #297ba3;
            --color-light: #eff2f6;
            --color-dark: #162737;
            --color-hover: #d6eafe;
            --color-disabletxt: #9e9e9e;
            --gradient-primary: linear-gradient(135deg, #0d5ea6 0%, #1e7bb8 100%);
            --gradient-light: linear-gradient(135deg, #d6eafe 0%, #e8f4fd 100%);
            --shadow-soft: 0 10px 40px rgba(13, 94, 166, 0.1);
            --shadow-hover: 0 20px 60px rgba(13, 94, 166, 0.2);
            
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --radius: 12px;
            --radius-lg: 16px;
        }

        body {
            background: var(--gradient-light);
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
            box-shadow: var(--shadow-soft);
            border: 1px solid var(--color-light);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .profile-card:hover {
            box-shadow: var(--shadow-hover);
        }

        .profile-header {
            background: var(--gradient-primary);
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
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M30 15L45 30L30 45L15 30z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
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

        .badge-admin {
            background: linear-gradient(135deg, var(--color-warning), var(--color-secondary));
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
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
            background: linear-gradient(135deg, var(--color-success), #1ba01b);
            color: white;
        }

        .status-registered {
            background: linear-gradient(135deg, var(--color-warning), var(--color-secondary));
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
            background: var(--gradient-primary);
            color: white;
            box-shadow: var(--shadow-soft);
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
            color: white;
        }

        .btn-secondary-modern {
            background: white;
            color: var(--color-dark);
            border: 1px solid var(--color-light);
        }

        .btn-secondary-modern:hover {
            background: var(--color-hover);
            transform: translateY(-2px);
            box-shadow: var(--shadow-soft);
            color: var(--color-dark);
        }

        .info-section {
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-soft);
            border: 1px solid var(--color-light);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .section-header {
            background: var(--color-light);
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--color-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-icon {
            width: 20px;
            height: 20px;
            color: var(--color-primary);
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
            color: var(--color-disabletxt);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            color: var(--color-dark);
            font-size: 1rem;
            word-break: break-word;
        }

        .admin-stats {
            background: var(--gradient-primary);
            color: white;
            border-radius: var(--radius-lg);
            padding: 2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .admin-stats::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M20 20L30 10L40 20L30 30z'/%3E%3C/g%3E%3C/svg%3E") repeat;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--radius);
            padding: 1.5rem;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .toast-modern {
            border-radius: var(--radius);
            border: none;
            box-shadow: var(--shadow-soft);
            backdrop-filter: blur(10px);
        }

        .toast-success {
            background: rgba(36, 194, 36, 0.95);
            color: white;
        }

        .toast-error {
            background: rgba(172, 32, 32, 0.95);
            color: white;
        }

        .quick-actions {
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-soft);
            border: 1px solid var(--color-light);
            padding: 2rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .quick-actions h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--color-dark);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .action-btn {
            background: var(--color-light);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius);
            padding: 1rem;
            text-decoration: none;
            color: var(--color-dark);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            background: var(--color-primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-soft);
        }

        .action-btn i {
            font-size: 1.2rem;
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
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .action-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

<div class="profile-container">
    <!-- Admin Stats Header -->
    <div class="admin-stats">
        <h2 style="margin-bottom: 1.5rem; font-size: 1.5rem; font-weight: 600;">
            <i class="fas fa-crown" style="margin-right: 0.5rem;"></i>
            Dashboard Admin
        </h2>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">{{ \App\Models\User::count() }}</div>
                <div class="stat-label text-white">Total Pengguna</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ \App\Models\User::where('status_id', 1)->count() }}</div>
                <div class="stat-label text-white">Pengguna Aktif</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ \App\Models\Transaction::where('status', 'Completed')->count() }}</div>
                <div class="stat-label text-white">Transaksi Selesai</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Profile Sidebar -->
        <div class="col-lg-4">
            <div class="profile-card">
                <div class="profile-header">
                    <!-- Profile Photo -->
                    @if($admin->photo)
                        <img src="{{ Storage::url($admin->photo) }}" 
                             class="profile-avatar" 
                             alt="Admin Photo">
                    @else
                        <div class="profile-placeholder">
                            <i class="fas fa-user-shield fa-2x" style="opacity: 0.7;"></i>
                        </div>
                    @endif

                    <!-- User Info -->
                    <h2 class="profile-name">{{ $admin->name }}</h2>
                    <p class="profile-email">{{ $admin->email }}</p>
                    
                    <!-- Admin Badge -->
                    <div class="badge-admin">
                        <i class="fas fa-shield-alt"></i>
                        Administrator
                    </div>
                    
                    <!-- Status -->
                    <span class="status-badge status-{{ $admin->status->name == 'Active' ? 'active' : 'registered' }}">
                        {{ $admin->status->name ?? 'Unknown' }}
                    </span>
                </div>

                <!-- Action Buttons -->
                <div class="profile-actions">
                    <a href="{{ route('admin.editProfile') }}" class="btn-modern btn-primary-modern">
                        <i class="fas fa-edit"></i>
                        Edit Profil
                    </a>
                    <a href="#" class="btn-modern btn-secondary-modern" onclick="showPasswordModal()">
                        <i class="fas fa-lock"></i>
                        Password
                    </a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <h3>
                    <i class="fas fa-bolt" style="color: var(--color-primary);"></i>
                    Aksi Cepat
                </h3>
                <div class="action-grid">
                    <a href="{{ route('admin.usersManage') }}" class="action-btn">
                        <i class="fas fa-users"></i>
                        <span>Kelola Pengguna</span>
                    </a>
                    <a href="{{ route('admin.transaksi') }}" class="action-btn">
                        <i class="fas fa-receipt"></i>
                        <span>Transaksi</span>
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
                        <i class="fas fa-user-cog section-icon"></i>
                        Informasi Admin
                    </h3>
                </div>
                <div class="section-content">
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Nama Lengkap</span>
                            <span class="info-value">{{ $admin->name ?: 'Belum diisi' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email</span>
                            <span class="info-value">{{ $admin->email ?: 'Belum diisi' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Nomor Telepon</span>
                            <span class="info-value">{{ $admin->phone_number ?: 'Belum diisi' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Jenis Kelamin</span>
                            <span class="info-value">{{ $admin->gender ?: 'Belum diisi' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tempat Lahir</span>
                            <span class="info-value">{{ $admin->birth_place ?: 'Belum diisi' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tanggal Lahir</span>
                            <span class="info-value">
                                {{ $admin->birth_date ? \Carbon\Carbon::parse($admin->birth_date)->format('d F Y') : 'Belum diisi' }}
                            </span>
                        </div>
                        <div class="info-item" style="grid-column: 1 / -1;">
                            <span class="info-label">Alamat</span>
                            <span class="info-value">{{ $admin->address ?: 'Belum diisi' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Pendidikan</span>
                            <span class="info-value">{{ $admin->education_level ?: 'Belum diisi' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Bergabung Sejak</span>
                            <span class="info-value">{{ $admin->created_at->format('d F Y') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Terakhir Login</span>
                            <span class="info-value">{{ $admin->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Information -->
            <div class="info-section">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-server section-icon"></i>
                        Informasi Sistem
                    </h3>
                </div>
                <div class="section-content">
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Laravel Version</span>
                            <span class="info-value">{{ app()->version() }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">PHP Version</span>
                            <span class="info-value">{{ phpversion() }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Environment</span>
                            <span class="info-value">{{ app()->environment() }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Timezone</span>
                            <span class="info-value">{{ config('app.timezone') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="passwordForm" method="POST" action="#">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Password Saat Ini</label>
                        <input type="password" class="form-control" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" name="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ubah Password</button>
                </div>
            </form>
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
            document.querySelectorAll('.btn-modern, .action-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    if (this.getAttribute('href') !== '#' && !this.hasAttribute('onclick')) {
                        const icon = this.querySelector('i');
                        if (icon) {
                            const originalIcon = icon.className;
                            icon.className = 'fas fa-spinner fa-spin';
                            
                            setTimeout(() => {
                                icon.className = originalIcon;
                            }, 2000);
                        }
                    }
                });
            });
        });

        function showPasswordModal() {
            const modal = new bootstrap.Modal(document.getElementById('passwordModal'));
            modal.show();
        }

        // Form validation for password change
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            const password = document.querySelector('input[name="password"]').value;
            const passwordConfirmation = document.querySelector('input[name="password_confirmation"]').value;
            
            if (password !== passwordConfirmation) {
                e.preventDefault();
                alert('Password baru dan konfirmasi password tidak cocok!');
                return false;
            }
            
            if (password.length < 8) {
                e.preventDefault();
                alert('Password minimal 8 karakter!');
                return false;
            }
        });
    </script>
@endpush

@endsection