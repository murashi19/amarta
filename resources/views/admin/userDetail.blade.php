@extends('layouts.dashboardAdmin')

@section('title', 'Detail User')

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
        --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.1);
        --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.15);
        --shadow-lg: 0 8px 25px rgba(0, 0, 0, 0.2);
        --shadow-xl: 0 20px 50px rgba(0, 0, 0, 0.3);
    }

    .profile-header {
        background: var(--gradient-primary);
        color: white;
        padding: 2.5rem 0;
        border-radius: 0 0 25px 25px;
        box-shadow: var(--shadow-soft);
        position: relative;
        overflow: hidden;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="1.5" fill="rgba(255,255,255,0.1)"/></svg>');
        opacity: 0.3;
    }

    .profile-photo {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        border: 5px solid rgba(255, 255, 255, 0.9);
        object-fit: cover;
        box-shadow: var(--shadow-lg);
        transition: transform 0.3s ease;
    }

    .profile-photo:hover {
        transform: scale(1.05);
    }

    .profile-photo-placeholder {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        border: 5px solid rgba(255, 255, 255, 0.9);
        background: rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
    }

    .status-badge {
        font-size: 0.875rem;
        font-weight: 600;
        padding: 0.6rem 1.2rem;
        border-radius: 25px;
        border: none;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
    }

    .status-badge:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .status-registered { background-color: var(--color-warning); color: var(--color-dark); }
    .status-booking-paid { background-color: var(--color-info); color: white; }
    .status-meeting-joined { background-color: var(--color-primary); color: white; }
    .status-dp-paid, .status-active { background-color: var(--color-success); color: white; }
    .status-default { background-color: var(--color-disabletxt); color: white; }

    .info-card {
        border: none;
        border-radius: 20px;
        box-shadow: var(--shadow-soft);
        transition: all 0.3s ease;
        background: white;
        overflow: hidden;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
    }

    .card-header {
        background: var(--gradient-light) !important;
        border: none !important;
        padding: 1.5rem;
    }

    .section-title {
        color: var(--color-dark);
        font-weight: 700;
        font-size: 1.1rem;
        margin: 0;
        display: flex;
        align-items: center;
    }

    .section-title i {
        font-size: 1.2rem;
        margin-right: 0.75rem;
    }

    .detail-row {
        padding: 1rem 0;
        border-bottom: 1px solid rgba(13, 94, 166, 0.1);
        transition: background-color 0.2s ease;
    }

    .detail-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .detail-row:hover {
        background-color: rgba(214, 234, 254, 0.3);
        margin: 0 -1.5rem;
        padding-left: 1.5rem;
        padding-right: 1.5rem;
        border-radius: 10px;
    }

    .detail-label {
        font-weight: 700;
        color: var(--color-dark);
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        color: var(--color-dark);
        font-weight: 500;
        word-wrap: break-word;
    }

    .btn-action {
        border-radius: 25px;
        padding: 0.75rem 1.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        border: none;
        box-shadow: var(--shadow-sm);
        margin: 0.25rem;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-action.btn-warning {
        background: var(--color-warning);
        color: var(--color-dark);
    }

    .btn-action.btn-info {
        background: var(--color-info);
        color: white;
    }

    .btn-action.btn-success {
        background: var(--color-success);
        color: white;
    }

    .btn-action.btn-danger {
        background: var(--color-danger);
        color: white;
    }

    .action-card {
        background: var(--gradient-light);
        border: none;
        border-radius: 20px;
        box-shadow: var(--shadow-soft);
    }

    .action-card .card-body {
        padding: 2rem;
    }

    .action-card .card-title {
        color: var(--color-dark);
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 1.5rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .modal-content {
        border: none;
        border-radius: 20px;
        box-shadow: var(--shadow-xl);
    }

    .modal-header {
        border-radius: 20px 20px 0 0;
        border-bottom: 1px solid rgba(13, 94, 166, 0.1);
        padding: 1.5rem;
    }

    .modal-header.bg-danger {
        background: var(--color-danger) !important;
    }

    .modal-title {
        font-weight: 700;
        font-size: 1.2rem;
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-footer {
        border-top: 1px solid rgba(13, 94, 166, 0.1);
        padding: 1.5rem;
    }

    .form-select, .form-control {
        border: 2px solid rgba(13, 94, 166, 0.1);
        border-radius: 15px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-select:focus, .form-control:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(13, 94, 166, 0.1);
    }

    .gender-icon.text-primary { color: var(--color-primary) !important; }
    .gender-icon.text-danger { color: var(--color-danger) !important; }

    .badge {
        font-weight: 600;
        padding: 0.5rem 0.8rem;
        border-radius: 15px;
        font-size: 0.8rem;
    }

    .badge.bg-dark {
        background-color: var(--color-dark) !important;
    }

    .alert {
        border: none;
        border-radius: 15px;
        padding: 1rem 1.5rem;
        font-weight: 600;
        box-shadow: var(--shadow-md);
    }

    .alert-success {
        background-color: var(--color-success);
        color: white;
    }

    .text-primary { color: var(--color-primary) !important; }
    .text-success { color: var(--color-success) !important; }
    .text-info { color: var(--color-info) !important; }
    .text-warning { color: var(--color-warning) !important; }
    .text-danger { color: var(--color-danger) !important; }

    @media (max-width: 768px) {
        .profile-header {
            padding: 2rem 0;
        }
        
        .profile-photo, .profile-photo-placeholder {
            width: 100px;
            height: 100px;
        }
        
        .btn-action {
            margin: 0.25rem 0;
            width: 100%;
        }
        
        .detail-row .col-5, .detail-row .col-4 {
            margin-bottom: 0.5rem;
        }
    }
</style>
@endpush

<div class="container mt-4">
    <!-- Profile Header -->
    <div class="profile-header mb-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3 text-center">
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile Photo" class="profile-photo">
                    @else
                        <div class="profile-photo-placeholder">
                            <i class="fas fa-user fa-3x text-white"></i>
                        </div>
                    @endif
                </div>
                <div class="col-md-9">
                    <h1 class="mb-3 fw-bold">{{ $user->name }}</h1>
                    <p class="mb-2 fs-5"><i class="fas fa-envelope me-2"></i>{{ $user->email }}</p>
                    <p class="mb-3 fs-5"><i class="fas fa-phone me-2"></i>{{ $user->phone_number ?? 'Tidak ada' }}</p>
                    
                    <!-- Status Badge -->
                    @if($user->status)
                        <span class="badge status-badge 
                            @switch($user->status->name)
                                @case('Registered')
                                    status-registered
                                    @break
                                @case('Booking Paid')
                                    status-booking-paid
                                    @break
                                @case('Meeting Joined')
                                    status-meeting-joined
                                    @break
                                @case('DP Paid')
                                @case('Active')
                                    status-active
                                    @break
                                @default
                                    status-default
                            @endswitch
                        ">
                            <i class="fas fa-circle me-1"></i>{{ $user->status->name }}
                        </span>
                    @else
                        <span class="badge status-badge status-default">
                            <i class="fas fa-question-circle me-1"></i>Status Tidak Diketahui
                        </span>
                    @endif

                    <!-- Role Badge -->
                    @if($user->roles->isNotEmpty())
                        @foreach($user->roles as $role)
                            <span class="badge bg-dark status-badge ms-2">
                                <i class="fas fa-user-tag me-1"></i>{{ $role->name }}
                            </span>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Personal Information -->
        <div class="col-lg-6 mb-4">
            <div class="card info-card h-100">
                <div class="card-header">
                    <h5 class="section-title">
                        <i class="fas fa-user-circle text-primary"></i>
                        Informasi Pribadi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="detail-row">
                        <div class="row">
                            <div class="col-5 detail-label">Nama Lengkap:</div>
                            <div class="col-7 detail-value">{{ $user->name }}</div>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="row">
                            <div class="col-5 detail-label">Email:</div>
                            <div class="col-7 detail-value">{{ $user->email }}</div>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="row">
                            <div class="col-5 detail-label">No. Telepon:</div>
                            <div class="col-7 detail-value">{{ $user->phone_number ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="row">
                            <div class="col-5 detail-label">Jenis Kelamin:</div>
                            <div class="col-7 detail-value">
                                @if($user->gender)
                                    <i class="fas fa-{{ $user->gender == 'Laki-laki' ? 'mars' : 'venus' }} me-1 gender-icon text-{{ $user->gender == 'Laki-laki' ? 'primary' : 'danger' }}"></i>
                                    {{ $user->gender }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="row">
                            <div class="col-5 detail-label">Tempat Lahir:</div>
                            <div class="col-7 detail-value">{{ $user->birth_place ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="row">
                            <div class="col-5 detail-label">Tanggal Lahir:</div>
                            <div class="col-7 detail-value">
                                @if($user->birth_date)
                                    {{ \Carbon\Carbon::parse($user->birth_date)->format('d M Y') }}
                                    <small class="text-muted">({{ \Carbon\Carbon::parse($user->birth_date)->age }} tahun)</small>
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="row">
                            <div class="col-5 detail-label">Pendidikan:</div>
                            <div class="col-7 detail-value">{{ $user->education_level ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Address & Additional Info -->
        <div class="col-lg-6 mb-4">
            <div class="card info-card h-100">
                <div class="card-header">
                    <h5 class="section-title">
                        <i class="fas fa-map-marker-alt text-success"></i>
                        Informasi Tambahan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="detail-row">
                        <div class="row">
                            <div class="col-4 detail-label">Alamat:</div>
                            <div class="col-8 detail-value">
                                {{ $user->address ?? '-' }}
                            </div>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="row">
                            <div class="col-4 detail-label">Catatan:</div>
                            <div class="col-8 detail-value">
                                {{ $user->notes ?? '-' }}
                            </div>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="row">
                            <div class="col-4 detail-label">Status:</div>
                            <div class="col-8 detail-value">
                                @if($user->status)
                                    <strong>{{ $user->status->name }}</strong><br>
                                    <small class="text-muted">{{ $user->status->description }}</small>
                                @else
                                    <span class="text-muted">Belum ada status</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="row">
                            <div class="col-4 detail-label">Role:</div>
                            <div class="col-8 detail-value">
                                @if($user->roles->isNotEmpty())
                                    @foreach($user->roles as $role)
                                        <span class="badge bg-dark me-1">{{ $role->name }}</span>
                                        @if($role->description)
                                            <br><small class="text-muted">{{ $role->description }}</small>
                                        @endif
                                    @endforeach
                                @else
                                    <span class="text-muted">Tidak ada role</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="row">
                            <div class="col-4 detail-label">Terdaftar:</div>
                            <div class="col-8 detail-value">
                                @if($user->created_at)
                                    {{ $user->created_at->format('d M Y, H:i') }}<br>
                                    <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card action-card">
                <div class="card-body text-center">
                    <h6 class="card-title">Kelola Akun User</h6>
                    <div class="d-flex flex-wrap justify-content-center">
                        <a href="{{ route('admin.editUser', $user->id) }}" class="btn btn-warning btn-action">
                            <i class="fas fa-edit me-2"></i>Edit User
                        </a>
                        <button type="button" class="btn btn-success btn-action" data-bs-toggle="modal" data-bs-target="#changeStatusModal">
                            <i class="fas fa-exchange-alt me-2"></i>Ubah Status
                        </button>
                        <button type="button" class="btn btn-danger btn-action" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i>Hapus User
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Status Modal -->
<div class="modal fade" id="changeStatusModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: var(--gradient-primary); color: white;">
                <h5 class="modal-title">
                    <i class="fas fa-exchange-alt me-2"></i>Ubah Status User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.users.updateStatus', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status_id" class="form-label fw-bold">Pilih Status Baru:</label>
                        <select class="form-select" id="status_id" name="status_id" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="1" {{ $user->status_id == 1 ? 'selected' : '' }}>Registered</option>
                            <option value="2" {{ $user->status_id == 2 ? 'selected' : '' }}>Booking Paid</option>
                            <option value="3" {{ $user->status_id == 3 ? 'selected' : '' }}>Meeting Joined</option>
                            <option value="4" {{ $user->status_id == 4 ? 'selected' : '' }}>DP Paid</option>
                            <option value="5" {{ $user->status_id == 5 ? 'selected' : '' }}>Active</option>
                            <option value="6" {{ $user->status_id == 6 ? 'selected' : '' }}>Departure Paid</option>
                            <option value="7" {{ $user->status_id == 7 ? 'selected' : '' }}>Ready to Depart</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-user-times fa-3x text-danger mb-3"></i>
                </div>
                <p class="text-center">Apakah Anda yakin ingin menghapus user <strong>{{ $user->name }}</strong>?</p>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Peringatan!</strong> Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait user.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <form action="{{ route('admin.usersManage.deleteUser', $user->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Ya, Hapus User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            // Create success notification
            const notification = document.createElement('div');
            notification.className = 'alert alert-success position-fixed';
            notification.style.cssText = `
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
                border-radius: 15px;
                box-shadow: var(--shadow-lg);
                animation: slideIn 0.5s ease-out;
            `;
            notification.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2 fs-5"></i>
                    <div class="flex-grow-1">{{ session('success') }}</div>
                    <button type="button" class="btn-close btn-close-white ms-2" onclick="this.parentElement.parentElement.remove()"></button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.style.animation = 'slideOut 0.5s ease-in';
                    setTimeout(() => notification.remove(), 500);
                }
            }, 5000);
        @endif
    });

    // Add animation keyframes
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
</script>
@endpush

@endsection