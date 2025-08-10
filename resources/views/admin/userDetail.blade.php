@extends('layouts.dashboardAdmin')

@section('title', 'Detail User')

@section('content')
@push('styles')
<style>
    .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            border-radius: 0 0 20px 20px;
        }
        .profile-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid white;
            object-fit: cover;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .status-badge {
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
        }
        .info-card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 15px;
            transition: transform 0.2s;
        }
        .info-card:hover {
            transform: translateY(-2px);
        }
        .section-title {
            color: #495057;
            font-weight: 600;
            margin-bottom: 1rem;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 0.5rem;
        }
        .detail-row {
            border-bottom: 1px solid #f8f9fa;
            padding: 0.75rem 0;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #6c757d;
        }
        .detail-value {
            color: #212529;
        }
        .btn-action {
            border-radius: 20px;
            padding: 0.5rem 1.5rem;
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
                            <div class="profile-photo bg-light d-flex align-items-center justify-content-center">
                                <i class="fas fa-user fa-3x text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-9">
                        <h2 class="mb-2">{{ $user->name }}</h2>
                        <p class="mb-2"><i class="fas fa-envelope me-2"></i>{{ $user->email }}</p>
                        <p class="mb-3"><i class="fas fa-phone me-2"></i>{{ $user->phone_number ?? 'Tidak ada' }}</p>
                        
                        <!-- Status Badge -->
                        @if($user->status)
                            <span class="badge status-badge 
                                @switch($user->status->name)
                                    @case('Registered')
                                        bg-warning text-dark
                                        @break
                                    @case('Booking Paid')
                                        bg-info text-white
                                        @break
                                    @case('Meeting Joined')
                                        bg-primary text-white
                                        @break
                                    @case('DP Paid')
                                        bg-success text-white
                                        @break
                                    @case('Active')
                                        bg-success text-white
                                        @break
                                    @default
                                        bg-secondary text-white
                                @endswitch
                            ">
                                <i class="fas fa-circle me-1"></i>{{ $user->status->name }}
                            </span>
                        @else
                            <span class="badge bg-secondary status-badge">
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
                    <div class="card-header bg-white border-0">
                        <h5 class="section-title mb-0">
                            <i class="fas fa-user-circle me-2 text-primary"></i>
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
                                        <i class="fas fa-{{ $user->gender == 'Laki-laki' ? 'mars' : 'venus' }} me-1 text-{{ $user->gender == 'Laki-laki' ? 'primary' : 'danger' }}"></i>
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
                    <div class="card-header bg-white border-0">
                        <h5 class="section-title mb-0">
                            <i class="fas fa-map-marker-alt me-2 text-success"></i>
                            Informasi Tambahan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="detail-row">
                            <div class="row">
                                <div class="col-4 detail-label">Alamat:</div>
                                <div class="col-8 detail-value">
                                    @if($user->address)
                                        <span class="d-block">{{ $user->address }}</span>
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="row">
                                <div class="col-4 detail-label">Catatan:</div>
                                <div class="col-8 detail-value">
                                    @if($user->notes)
                                        <span class="d-block">{{ $user->notes }}</span>
                                    @else
                                        -
                                    @endif
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
                <div class="card info-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">Aksi</h6>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-action">
                                <i class="fas fa-edit me-2"></i>Edit User
                            </a>
                            <a href="{{ route('admin.transactions.index', ['user_id' => $user->id]) }}" class="btn btn-info btn-action">
                                <i class="fas fa-money-bill-wave me-2"></i>Lihat Transaksi
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Status User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.users.updateStatus', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="status_id" class="form-label">Pilih Status Baru:</label>
                            <select class="form-select" id="status_id" name="status_id" required>
                                <option value="">-- Pilih Status --</option>
                                <!-- You would populate this with available statuses -->
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
                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Konfirmasi Hapus User</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus user <strong>{{ $user->name }}</strong>?</p>
                    <p class="text-danger"><small><i class="fas fa-exclamation-triangle me-1"></i>Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait user.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Ya, Hapus User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    // Show success alert
    document.addEventListener('DOMContentLoaded', function() {
        
        @if(session('success'))
            const alert = document.createElement('div');
            alert.className = 'alert alert-success alert-dismissible fade show position-fixed';
            alert.style.top = '20px';
            alert.style.right = '20px';
            alert.style.zIndex = '9999';
            alert.innerHTML = `
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(alert);
            
            setTimeout(() => {
                alert.remove();
            }, 5000);
        @endif
    });
</script>
@endpush

@endsection