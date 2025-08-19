@extends('layouts.dashboardAdmin')

@section('title', 'Manajemen Pengguna')

@push('styles')
<style>
    .badge {
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 500;
    }
    .badge-success { background-color: #dcfce7; color: #166534; }
    .badge-warning { background-color: #fef3c7; color: #92400e; }
    .badge-danger { background-color: #fee2e2; color: #991b1b; }
    .badge-info { background-color: #dbeafe; color: #1e40af; }
    
    .card-stats {
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    
    .card-stats:hover {
        transform: translateY(-2px);
    }
    
    .table-actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
    
    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 0.375rem;
    }
    
    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
    }
    
    .section-title {
        font-size: 1rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .required {
        color: #dc2626;
    }

    .form-check {
        margin-bottom: 0.5rem;
    }
    
    .opacity-75 {
        opacity: 0.75;
    }

    /* CSS Responsive untuk Mobile - Manajemen Pengguna */

    @media (max-width: 768px) {
        /* Container adjustments */
        .container-fluid {
            padding: 0.75rem;
        }

        /* Header section */
        .d-flex.justify-content-between.align-items-center.mb-4 {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 1rem;
        }

        .d-flex.justify-content-between.align-items-center.mb-4 h2 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        /* Stats cards responsive */
        .row.mb-4 .col-md-3 {
            margin-bottom: 1rem;
        }

        .card-stats {
            margin-bottom: 1rem;
        }

        .card-stats .card-body {
            padding: 1rem;
        }

        .card-stats h3 {
            font-size: 1.5rem;
        }

        .card-stats i {
            font-size: 1.5rem !important;
        }

        /* Filter section */
        .card-body .row.g-3 {
            gap: 0.5rem !important;
        }

        .card-body .row.g-3 > div {
            margin-bottom: 1rem;
        }

        /* Action buttons di filter */
        .card-body .d-flex.gap-2 {
            flex-direction: column;
            gap: 0.5rem !important;
        }

        .card-body .d-flex.gap-2 .btn {
            width: 100%;
            justify-content: center;
        }

        /* Table responsive improvements */
        .table-responsive {
            font-size: 0.875rem;
        }

        /* Hide less important columns on mobile */
        .table th:nth-child(4), /* Gender */
        .table td:nth-child(4),
        .table th:nth-child(5), /* Tempat/Tanggal Lahir */
        .table td:nth-child(5) {
            display: none;
        }

        /* Adjust remaining columns */
        .table th:nth-child(1), .table td:nth-child(1) { width: 8%; }
        .table th:nth-child(2), .table td:nth-child(2) { width: 35%; }
        .table th:nth-child(3), .table td:nth-child(3) { width: 25%; }
        .table th:nth-child(6), .table td:nth-child(6) { width: 15%; }
        .table th:nth-child(7), .table td:nth-child(7) { width: 12%; }
        .table th:nth-child(8), .table td:nth-child(8) { width: 5%; }

        /* User avatar and info */
        .avatar {
            width: 32px;
            height: 32px;
            font-size: 0.75rem;
        }

        .d-flex.align-items-center .fw-bold {
            font-size: 0.875rem;
            line-height: 1.2;
        }

        .d-flex.align-items-center .text-muted {
            font-size: 0.75rem;
        }

        /* Contact info adjustments */
        .table td:nth-child(3) div {
            font-size: 0.75rem;
        }

        .table td:nth-child(3) small {
            font-size: 0.7rem;
        }

        /* Badge adjustments */
        .badge {
            font-size: 0.7rem;
            padding: 0.2rem 0.4rem;
        }

        /* Dropdown actions */
        .dropdown-toggle {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .dropdown-menu {
            font-size: 0.875rem;
            min-width: 150px;
        }

        /* Pagination adjustments */
        .card-footer {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .pagination {
            justify-content: center;
            margin: 0;
        }

        .pagination .page-link {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }

        /* Modal adjustments */
        .modal-dialog {
            margin: 0.5rem;
            max-width: calc(100vw - 1rem);
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            flex-direction: column;
            gap: 0.5rem;
        }

        .modal-footer .btn {
            width: 100%;
            margin: 0;
        }

        /* Alert adjustments */
        .alert {
            font-size: 0.875rem;
            padding: 0.75rem;
        }

        .alert .btn-close {
            padding: 0.375rem;
            font-size: 0.875rem;
        }
    }

    /* Extra small devices (portrait phones, less than 576px) */
    @media (max-width: 576px) {
        .container-fluid {
            padding: 0.5rem;
        }

        /* Further reduce font sizes */
        .card-stats h3 {
            font-size: 1.25rem;
        }

        .card-stats p {
            font-size: 0.875rem;
        }

        /* Make table even more compact */
        .table {
            font-size: 0.75rem;
        }

        .table th, .table td {
            padding: 0.5rem 0.25rem;
            vertical-align: middle;
        }

        /* Stack user info vertically on very small screens */
        .d-flex.align-items-center {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 0.5rem;
        }

        .d-flex.align-items-center .avatar {
            align-self: center;
        }

        /* Adjust contact column */
        .table td:nth-child(3) {
            width: 30%;
        }

        /* Hide role column on very small screens */
        .table th:nth-child(7),
        .table td:nth-child(7) {
            display: none;
        }

        /* Adjust remaining column widths */
        .table th:nth-child(6), .table td:nth-child(6) { width: 20%; }
        .table th:nth-child(8), .table td:nth-child(8) { width: 10%; }
    }

    /* Landscape phones and small tablets */
    @media (min-width: 576px) and (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }

        /* Show gender column back on landscape */
        .table th:nth-child(4),
        .table td:nth-child(4) {
            display: table-cell;
        }

        /* Adjust column widths for landscape */
        .table th:nth-child(1), .table td:nth-child(1) { width: 5%; }
        .table th:nth-child(2), .table td:nth-child(2) { width: 25%; }
        .table th:nth-child(3), .table td:nth-child(3) { width: 20%; }
        .table th:nth-child(4), .table td:nth-child(4) { width: 10%; }
        .table th:nth-child(6), .table td:nth-child(6) { width: 12%; }
        .table th:nth-child(7), .table td:nth-child(7) { width: 12%; }
        .table th:nth-child(8), .table td:nth-child(8) { width: 8%; }
    }

    /* Medium devices (tablets, 768px and up) */
    @media (min-width: 768px) and (max-width: 992px) {
        /* Show all columns on tablets */
        .table th, .table td {
            display: table-cell !important;
        }

        /* Slightly reduce padding */
        .table th, .table td {
            padding: 0.75rem 0.5rem;
        }
    }

    /* Additional mobile-specific improvements */
    @media (max-width: 768px) {
        /* Improve touch targets */
        .btn {
            min-height: 44px;
            touch-action: manipulation;
        }

        .form-control, .form-select {
            min-height: 44px;
            font-size: 16px; /* Prevents zoom on iOS */
        }

        /* Sticky header on mobile */
        .table thead th {
            position: sticky;
            top: 0;
            background: var(--bs-dark);
            z-index: 10;
        }

        /* Improve table scrolling */
        .table-responsive {
            border-radius: 0.375rem;
            border: 1px solid var(--bs-border-color);
            max-height: 70vh;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Loading states */
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Better focus states for accessibility */
        .btn:focus,
        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            outline: none;
        }
    }

</style>
@endpush
@section('content')

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="fas fa-users me-2"></i> Manajemen Pengguna</h2>
            <p class="text-muted mb-0">Kelola data pengguna sistem LPK</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card card-stats bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="mb-0">{{ isset($users) ? $users->total() : 0 }}</h3>
                            <p class="mb-0">Total Pengguna</p>
                        </div>
                        <div>
                            <i class="fas fa-users fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="mb-0">
                                {{ isset($users) ? $users->filter(function($user) { 
                                    return $user->status && $user->status->name === 'Active'; 
                                })->count() : 0 }}
                            </h3>
                            <p class="mb-0">Pengguna Aktif</p>
                        </div>
                        <div>
                            <i class="fas fa-user-check fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="mb-0">
                                {{ isset($users) ? $users->filter(function($user) { 
                                    return $user->roles()->where('name', 'User')->exists()
                                        && $user->status 
                                        && in_array($user->status->name, ['Booking Paid', 'Meeting Joined', 'DP Paid', 'Active']); 
                                })->count() : 0 }}

                            </h3>
                            <p class="mb-0">Sudah Bayar Booking</p>
                        </div>
                        <div>
                            <i class="fas fa-credit-card fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="mb-0">
                                {{ isset($users) ? $users->filter(function($user) { 
                                    return $user->status && $user->status->name === 'Registered'; 
                                })->count() : 0 }}
                            </h3>
                            <p class="mb-0">Belum Bayar Booking</p>
                        </div>
                        <div>
                            <i class="fas fa-clock fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="mt-4">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <!-- Filter Status -->
                    <div class="col-lg-3 col-md-6">
                        <label for="filterStatus" class="form-label">Status</label>
                        <select class="form-select" id="filterStatus">
                            <option value="">Semua Status</option>
                            <option value="Registered">Registered</option>
                            <option value="Booking Paid">Booking Paid</option>
                            <option value="Meeting Joined">Meeting Joined</option>
                            <option value="Active">Active</option>
                            <option value="Pemantapan">Pemantapan</option>
                            <option value="Pemberangkatan">Pemberangkatan</option>
                        </select>
                    </div>

                    <!-- Filter Type -->
                    <div class="col-lg-3 col-md-6">
                        <label for="filterRole" class="form-label">Role</label>
                        <select class="form-select" id="filterRole">
                            <option value="">Semua Role</option>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                        </select>
                    </div>

                    <!-- Search Input -->
                    <div class="col-lg-4 col-md-8">
                        <label for="searchUsers" class="form-label">Pencarian</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            placeholder="Cari pengguna..." 
                            id="searchUsers"
                        >
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-primary flex-fill" onclick="filterUsers()">
                                <i class="fas fa-search"></i>
                            </button>
                            <a 
                                href="{{ route('admin.usersManage') }}" 
                                class="btn btn-outline-secondary flex-fill"
                                title="Reset Filter"
                            >
                                <i class="fas fa-undo"></i>
                            </a>
                            <a 
                                href="{{ route('admin.createUser') }}" 
                                class="btn btn-primary flex-fill" 
                                title="Tambah Pengguna"
                            >
                                <i class="fas fa-plus"></i>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <table class="table table-striped table-hover" id="usersTable">
                    <thead class="table-dark">
                        <tr>
                            <th width="3%">#</th>
                            <th width="20%">Pengguna</th>
                            <th width="15%">Kontak</th>
                            <th width="10%">Gender</th>
                            <th width="15%">Tempat/Tanggal Lahir</th>
                            <th width="10%">Status</th>
                            <th width="12%">Role</th>
                            <th width="5%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($users) && $users->count() > 0)
                            @foreach($users as $index => $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($user->photo)
                                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Pengguna" width="35" height="35" class="avatar bg-primary me-3">
                                        @else
                                            <div class="avatar bg-primary me-3">
                                                {{ strtoupper(substr($user->name ?? 'U', 0, 2)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold">{{ $user->name ?? 'N/A' }}</div>
                                            <small class="text-muted">{{ $user->email ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        @if($user->phone_number)
                                            <div><i class="fas fa-phone text-muted me-1"></i> {{ $user->phone_number }}</div>
                                        @endif
                                        @if($user->address)
                                            <small class="text-muted">
                                                <i class="fas fa-map-marker-alt text-muted me-1"></i> 
                                                {{ Str::limit($user->address, 30) }}
                                            </small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($user->gender)
                                        <span class="badge {{ $user->gender == 'Laki-laki' ? 'bg-info' : 'bg-success' }} text-white">
                                            {{ $user->gender }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        @if($user->birth_place)
                                            <div>{{ $user->birth_place }}</div>
                                        @endif
                                        @if($user->birth_date)
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($user->birth_date)->format('d/m/Y') }}
                                            </small>
                                        @endif
                                        @if(!$user->birth_place && !$user->birth_date)
                                            <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if(isset($user->status))
                                        <span class="badge {{ $user->status->name == 'Active' ? 'bg-success' : 'bg-warning text-dark' }}">
                                            {{ $user->status->name }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">Unknown</span>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($user->roles) && $user->roles->count() > 0)
                                        @foreach($user->roles as $role)
                                            <span class="badge bg-info text-white me-1">{{ $role->name }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.editUser', $user->id) }}">
                                                    <i class="fas fa-edit me-2 text-warning"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#" onclick="viewUserDetail({{ $user->id }})">
                                                    <i class="fas fa-eye me-2 text-info"></i> Lihat Detail
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" 
                                                   data-bs-toggle="modal" 
                                                   data-bs-target="#deleteModal"
                                                   data-user-id="{{ $user->id }}"
                                                   data-user-name="{{ $user->name }}">
                                                    <i class="fas fa-trash me-2"></i> Hapus
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-users fa-3x mb-3"></i>
                                    <p>Tidak ada data pengguna</p>
                                </div>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        @if(isset($users) && $users->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center">
            <div class="text-muted">
                Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} 
                dari {{ $users->total() }} data
            </div>
            {{ $users->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title text-danger" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-3">
                    <i class="fas fa-trash-alt text-danger" style="font-size: 3rem;"></i>
                </div>
                <h6 class="mb-3">Apakah Anda yakin ingin menghapus pengguna:</h6>
                <p class="fw-bold text-dark mb-3" id="userNameToDelete"></p>
                <div class="alert alert-warning">
                    <small>
                        <i class="fas fa-info-circle me-1"></i>
                        Data yang dihapus tidak dapat dikembalikan!
                    </small>
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4" id="confirmDeleteBtn">
                        <i class="fas fa-trash me-2"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="mb-3">
                    <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                </div>
                <h6 class="text-success mb-3">Berhasil!</h6>
                <p class="mb-0">Pengguna berhasil dihapus.</p>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-success px-4" data-bs-dismiss="modal">
                    <i class="fas fa-check me-2"></i>OK
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function viewUserDetail(userId) {
        window.location.href = "{{ route('admin.userDetail', ':userId') }}".replace(':userId', userId);
    }
     // Fungsi: Filter 
       function filterUsers() {
        const statusFilter = document.getElementById('filterStatus').value.toLowerCase();
        const roleFilter = document.getElementById('filterRole').value.toLowerCase();
        const searchFilter = document.getElementById('searchUsers').value.toLowerCase();

        const table = document.getElementById('usersTable');
        const rows = table.querySelectorAll('tbody tr');

        let visibleCount = 0;

        rows.forEach(row => {
            // Ambil isi kolom yang sesuai urutan tabel
            const nameCol   = row.querySelector('td:nth-child(2)')?.innerText.toLowerCase() || ""; // Nama pengguna
            const statusCol = row.querySelector('td:nth-child(6)')?.innerText.toLowerCase() || ""; // Status
            const roleCol   = row.querySelector('td:nth-child(7)')?.innerText.toLowerCase() || ""; // Role

            // Cek apakah row cocok filter
            const matchesStatus = !statusFilter || statusCol.includes(statusFilter);
            const matchesRole   = !roleFilter || roleCol.includes(roleFilter);
            const matchesSearch = !searchFilter || nameCol.includes(searchFilter);

            if (matchesStatus && matchesRole && matchesSearch) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Pesan jika tidak ada hasil
        const tbody = table.querySelector('tbody');
        let noDataRow = tbody.querySelector('.no-data-row');

        if (visibleCount === 0) {
            if (!noDataRow) {
                const tr = document.createElement('tr');
                tr.classList.add('no-data-row');
                tr.innerHTML = `<td colspan="9" class="text-center py-4">Tidak ada pengguna ditemukan.</td>`;
                tbody.appendChild(tr);
            }
        } else {
            if (noDataRow) noDataRow.remove();
        }
    }

    // Handle delete modal
    document.addEventListener('DOMContentLoaded', function() {
        const deleteModal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');
        const userNameElement = document.getElementById('userNameToDelete');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');
            const userName = button.getAttribute('data-user-name');

            // Update modal content
            userNameElement.textContent = userName;
            deleteForm.action = "{{ route('admin.usersManage.deleteUser', ':userId') }}".replace(':userId', userId);
        });

        // Handle form submission with loading state
        deleteForm.addEventListener('submit', function(e) {
            confirmDeleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...';
            confirmDeleteBtn.disabled = true;
        });
    });

    // Show success modal if there's a success message
    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        });
    @endif
</script>
@endpush


