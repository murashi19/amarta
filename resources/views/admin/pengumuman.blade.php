@extends('layouts.dashboardAdmin')

@section('title', 'Pengumuman')

@push('styles')
<style>
    /* CSS Responsive untuk Mobile - Manajemen Pengumuman */
    .card-stats {
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }

    .card-stats:hover {
        transform: translateY(-2px);
    }

    .opacity-75 {
        opacity: 0.75;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }

    /* Mobile First Approach - Base styles untuk mobile */
    @media (max-width: 768px) {
        /* Container adjustments */
        .col-md-12.p-4 {
            padding: 0.75rem !important;
        }

        /* Header section */
        .d-flex.justify-content-between.align-items-center.mb-4 {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 1rem;
            margin-bottom: 2rem !important;
        }

        .d-flex.justify-content-between.align-items-center.mb-4 h2 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
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

        .card-stats p {
            font-size: 0.875rem;
            margin-bottom: 0;
        }

        .card-stats i {
            font-size: 1.5rem !important;
        }

        /* Filter section mobile optimization */
        .card-body .row.g-3 {
            gap: 0.5rem !important;
        }

        .card-body .row.g-3 > div {
            margin-bottom: 1rem;
        }

        /* Search and filter inputs */
        .form-control, .form-select {
            font-size: 16px; /* Prevents zoom on iOS */
            min-height: 44px; /* Touch-friendly */
        }

        /* Action buttons di filter */
        .card-body .d-flex.gap-2 {
            flex-direction: column;
            gap: 0.5rem !important;
        }

        .card-body .d-flex.gap-2 .btn {
            width: 100%;
            justify-content: center;
            min-height: 44px;
            font-size: 0.875rem;
        }

        .card-body .d-flex.gap-2 .btn i {
            margin-right: 0.5rem;
        }

        /* Table responsive improvements */
        .table-responsive {
            font-size: 0.875rem;
            border-radius: 0.375rem;
            border: 1px solid var(--bs-border-color);
            max-height: 70vh;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Hide less important columns on mobile */
        .table th:nth-child(5), /* Prioritas */
        .table td:nth-child(5),
        .table th:nth-child(6), /* Target Audiens */
        .table td:nth-child(6),
        .table th:nth-child(7), /* Tanggal */
        .table td:nth-child(7) {
            display: none;
        }

        /* Adjust remaining columns for mobile */
        .table th:nth-child(1), .table td:nth-child(1) { width: 8%; }
        .table th:nth-child(2), .table td:nth-child(2) { width: 50%; }
        .table th:nth-child(3), .table td:nth-child(3) { width: 20%; }
        .table th:nth-child(4), .table td:nth-child(4) { width: 15%; }
        .table th:nth-child(8), .table td:nth-child(8) { width: 7%; }

        /* Table content adjustments */
        .table th, .table td {
            padding: 0.5rem 0.25rem;
            vertical-align: middle;
        }

        /* Title column improvements for mobile */
        .table td:nth-child(2) strong {
            font-size: 0.875rem;
            line-height: 1.2;
            display: block;
            margin-bottom: 0.25rem;
        }

        .table td:nth-child(2) small {
            font-size: 0.75rem;
            line-height: 1.3;
            display: block;
            color: #6c757d;
        }

        /* Badge adjustments for mobile */
        .badge {
            font-size: 0.7rem;
            padding: 0.2rem 0.4rem;
            margin: 0.1rem;
            display: inline-block;
        }

        .table td .badge {
            margin-bottom: 0.25rem;
            white-space: nowrap;
        }

        /* Dropdown actions */
        .dropdown-toggle {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            min-height: 32px;
            border: 1px solid #dee2e6;
        }

        .dropdown-menu {
            font-size: 0.875rem;
            min-width: 150px;
            z-index: 1050;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .dropdown-item i {
            width: 16px;
            text-align: center;
        }

        /* Alert adjustments */
        .alert {
            font-size: 0.875rem;
            padding: 0.75rem;
            margin-bottom: 1rem;
        }

        .alert .btn-close {
            padding: 0.375rem;
            font-size: 0.875rem;
        }

        /* Modal adjustments for mobile */
        .modal-dialog {
            margin: 0.5rem;
            max-width: calc(100vw - 1rem);
        }

        .modal-dialog-scrollable .modal-content {
            max-height: calc(100vh - 1rem);
        }

        .modal-body {
            padding: 1rem;
        }

        .modal-header {
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
        }

        .modal-footer {
            padding: 1rem;
            flex-direction: column;
            gap: 0.5rem;
            border-top: 1px solid #dee2e6;
        }

        .modal-footer .btn {
            width: 100%;
            margin: 0;
            min-height: 44px;
        }

        /* Form dalam modal */
        .modal .form-control,
        .modal .form-select {
            font-size: 16px;
            min-height: 44px;
        }

        .modal .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .modal textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        /* Row dalam modal form */
        .modal .row {
            margin-bottom: 1rem;
        }

        .modal .row:last-child {
            margin-bottom: 0;
        }

        /* Card dalam view modal */
        .modal .card {
            border: 1px solid #dee2e6;
            margin-bottom: 1rem;
        }

        .modal .card-header {
            background-color: #f8f9fa;
            padding: 0.75rem 1rem;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .modal .card-body {
            padding: 0.75rem 1rem;
        }

        /* Loading states dalam modal */
        #viewAnnouncementLoading,
        #viewAnnouncementError {
            padding: 2rem 1rem;
            text-align: center;
        }

        #viewAnnouncementLoading i,
        #viewAnnouncementError i {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        /* Sticky table header */
        .table thead th {
            position: sticky;
            top: 0;
            background: var(--bs-dark);
            z-index: 10;
            border-bottom: 2px solid #dee2e6;
        }

        /* Empty state */
        .table tbody td[colspan] {
            text-align: center;
            padding: 2rem 1rem;
        }

        .table tbody td[colspan] i {
            font-size: 2rem;
            color: #6c757d;
            margin-bottom: 1rem;
            display: block;
        }
    }

    /* Extra small devices (portrait phones, less than 576px) */
    @media (max-width: 576px) {
        .col-md-12.p-4 {
            padding: 0.5rem !important;
        }

        /* Further reduce font sizes */
        .card-stats h3 {
            font-size: 1.25rem;
        }

        .card-stats p {
            font-size: 0.8rem;
        }

        /* Make table even more compact */
        .table {
            font-size: 0.75rem;
        }

        .table th, .table td {
            padding: 0.4rem 0.2rem;
        }

        /* Hide jenis column on very small screens */
        .table th:nth-child(3),
        .table td:nth-child(3) {
            display: none;
        }

        /* Adjust remaining columns for very small screens */
        .table th:nth-child(2), .table td:nth-child(2) { width: 70%; }
        .table th:nth-child(4), .table td:nth-child(4) { width: 15%; }
        .table th:nth-child(8), .table td:nth-child(8) { width: 10%; }

        /* Stack badges vertically on very small screens */
        .table td .badge {
            display: block;
            margin: 0.1rem 0;
            text-align: center;
        }

        /* Modal improvements for very small screens */
        .modal-dialog {
            margin: 0.25rem;
            max-width: calc(100vw - 0.5rem);
        }

        .modal-body {
            padding: 0.75rem;
        }

        .modal-header,
        .modal-footer {
            padding: 0.75rem;
        }

        /* Form adjustments for very small screens */
        .modal .row > div {
            margin-bottom: 1rem;
        }

        .modal .col-md-8,
        .modal .col-md-6,
        .modal .col-md-4 {
            width: 100%;
            max-width: 100%;
        }
    }

    /* Landscape phones and small tablets (576px to 768px) */
    @media (min-width: 576px) and (max-width: 768px) {
        .col-md-12.p-4 {
            padding: 1rem !important;
        }

        /* Show jenis column back on landscape */
        .table th:nth-child(3),
        .table td:nth-child(3) {
            display: table-cell;
        }

        /* Show prioritas column on landscape */
        .table th:nth-child(5),
        .table td:nth-child(5) {
            display: table-cell;
        }

        /* Adjust column widths for landscape */
        .table th:nth-child(1), .table td:nth-child(1) { width: 5%; }
        .table th:nth-child(2), .table td:nth-child(2) { width: 40%; }
        .table th:nth-child(3), .table td:nth-child(3) { width: 15%; }
        .table th:nth-child(4), .table td:nth-child(4) { width: 12%; }
        .table th:nth-child(5), .table td:nth-child(5) { width: 12%; }
        .table th:nth-child(8), .table td:nth-child(8) { width: 6%; }

        /* Filter buttons can be horizontal on landscape tablets */
        .card-body .d-flex.gap-2 {
            flex-direction: row;
        }

        .card-body .d-flex.gap-2 .btn {
            width: auto;
            flex: 1;
        }
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

        /* Reset column widths for tablets */
        .table th:nth-child(1), .table td:nth-child(1) { width: 3%; }
        .table th:nth-child(2), .table td:nth-child(2) { width: 25%; }
        .table th:nth-child(3), .table td:nth-child(3) { width: 15%; }
        .table th:nth-child(4), .table td:nth-child(4) { width: 10%; }
        .table th:nth-child(5), .table td:nth-child(5) { width: 10%; }
        .table th:nth-child(6), .table td:nth-child(6) { width: 15%; }
        .table th:nth-child(7), .table td:nth-child(7) { width: 10%; }
        .table th:nth-child(8), .table td:nth-child(8) { width: 4%; }
    }

    /* Additional mobile-specific improvements */
    @media (max-width: 768px) {
        /* Improve touch targets */
        .btn {
            min-height: 44px;
            touch-action: manipulation;
        }

        .btn-sm {
            min-height: 36px;
            padding: 0.375rem 0.75rem;
        }

        /* Better focus states for accessibility */
        .btn:focus,
        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            outline: none;
        }

        /* Loading states */
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Scrollable content dalam modal */
        .modal-body {
            overflow-y: auto;
            max-height: calc(100vh - 200px);
        }

        /* Sticky modal header dan footer */
        .modal-header {
            position: sticky;
            top: 0;
            z-index: 1051;
            background: white;
            border-bottom: 1px solid #dee2e6;
        }

        .modal-footer {
            position: sticky;
            bottom: 0;
            z-index: 1051;
            background: white;
            border-top: 1px solid #dee2e6;
        }
    }

    /* Print styles */
    @media print {
        .btn, .dropdown, .modal, .alert {
            display: none !important;
        }
        
        .table-responsive {
            overflow: visible !important;
            max-height: none !important;
        }
    }

    /* Utilities untuk consistency */
    .text-nowrap-mobile {
        @media (max-width: 768px) {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    }

    .d-mobile-block {
        @media (max-width: 768px) {
            display: block !important;
        }
    }

    .d-mobile-none {
        @media (max-width: 768px) {
            display: none !important;
        }
    }
</style>
@endpush
@section('content')
<!-- Main Content -->
<div class="col-md-12 p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-bullhorn me-2"></i> Manajemen Pengumuman</h2>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card card-stats bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="mb-0">{{ $totalAnnouncements }}</h3>
                            <p class="mb-0">Total Pengumuman</p>
                        </div>
                        <div>
                            <i class="fas fa-file-alt fa-2x opacity-75"></i>
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
                            <h3 class="mb-0">{{ $publishedCount}}</h3>
                            <p class="mb-0">Terbit</p>
                        </div>
                        <div>
                            <i class="fas fa-check-circle fa-2x opacity-75"></i>
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
                            <h3 class="mb-0">{{ $draftCount }}</h3>
                            <p class="mb-0">Draft</p>
                        </div>
                        <div>
                            <i class="fas fa-clock fa-2x opacity-75"></i>
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
                            <h3 class="mb-0">{{ $scheduledCount }}</h3>
                            <p class="mb-0">Terjadwal</p>
                        </div>
                        <div>
                            <i class="fas fa-calendar-alt fa-2x opacity-75"></i>
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
                            <option value="published">Terbit</option>
                            <option value="draft">Draft</option>
                            <option value="scheduled">Terjadwal</option>
                        </select>
                    </div>

                    <!-- Filter Type -->
                    <div class="col-lg-3 col-md-6">
                        <label for="filterType" class="form-label">Jenis</label>
                        <select class="form-select" id="filterType">
                            <option value="">Semua Jenis</option>
                            <option value="auto welcome">Otomatis - Welcome</option>
                            <option value="auto booking success">Otomatis - Booking Berhasil</option>
                            <option value="auto dp request">Otomatis - DP Request</option>
                            <option value="auto success">Otomatis - Installment Lunas</option>
                            <option value="auto installment">Otomatis - Installment</option>
                            <option value="umum">Umum</option>
                        </select>
                    </div>

                    <!-- Search Input -->
                    <div class="col-lg-4 col-md-8">
                        <label for="searchAnnouncement" class="form-label">Pencarian</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            placeholder="Cari pengumuman..." 
                            id="searchAnnouncement"
                        >
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-lg-2 col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-primary flex-fill" onclick="filterAnnouncements()">
                                 <i class="fas fa-search mr-2">
                                 </i>
                                 Cari
                            </button>
                            <button 
                                class="btn btn-primary flex-fill" 
                                data-bs-toggle="modal" 
                                data-bs-target="#announcementModal"
                                title="Buat Pengumuman Baru"
                            >
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Announcements Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('delete_success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('delete_success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <table class="table table-striped table-hover" id="announcementsTable">
                    <thead class="table-dark">
                        <tr>
                            <th width="3%">#</th>
                            <th width="25%">Judul</th>
                            <th width="15%">Jenis</th>
                            <th width="10%">Status</th>
                            <th width="10%">Prioritas</th>
                            <th width="15%">Target Audiens</th>
                            <th width="10%">Tanggal</th>
                            <th width="4%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($announcements as $index => $announcement)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div>
                                        <strong>{{ $announcement->title }}</strong><br>
                                        <small class="text-muted">{{ Str::limit($announcement->content, 100) }}</small>
                                        @if($announcement->has_payment_button)
                                            <br>
                                            <span class="badge bg-primary mt-1"><i class="fas fa-credit-card me-1"></i> Ada Button Bayar</span>
                                        @endif
                                        @if($announcement->meet_link)
                                            <br>
                                            <span class="badge bg-success mt-1"><i class="fas fa-video me-1"></i> Ada Link Meet</span>
                                        @endif
                                    </div>
                                </td>
                                <td><span class="badge bg-info text-white">{{ $announcement->type }}</span></td>
                                <td>
                                    <span class="badge {{ $announcement->status === 'published' ? 'bg-success' : ($announcement->status === 'scheduled' ? 'bg-info' : 'bg-warning text-dark') }}">
                                        {{ ucfirst($announcement->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $announcement->priority === 'high' ? 'bg-danger' : ($announcement->priority === 'medium' ? 'bg-warning' : 'bg-success') }}">
                                        Prioritas {{ ucfirst($announcement->priority) }}
                                    </span>
                                </td>
                                <td><i class="fas fa-users me-1"></i> {{ $announcement->target_audience }}</td>
                                <td><small>{{ \Carbon\Carbon::parse($announcement->created_at)->format('d M Y') }}</small></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="viewAnnouncement({{ $announcement->id }})">
                                                    <i class="fas fa-eye me-2"></i> Lihat
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="editAnnouncement({{ $announcement->id }})">
                                                    <i class="fas fa-edit me-2"></i> Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="confirmDelete({{ $announcement->id }}, '{{ addslashes($announcement->title) }}')">
                                                    <i class="fas fa-trash me-2"></i> Hapus
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                    <p class="text-muted mb-0">Belum ada pengumuman</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Form for Delete -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Modal Form Pengumuman (Create) -->
<div class="modal fade" id="announcementModal" tabindex="-1" aria-labelledby="announcementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="announcementModalLabel">
                    <i class="fas fa-plus me-2"></i> Buat Pengumuman Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="announcementForm" action="{{ route('admin.pengumuman.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="_method" value="POST">
                    
                    <div class="row">
                        <div class="col-md-8">
                            <label for="title" class="form-label">Judul Pengumuman</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="col-md-4">
                            <label for="priority" class="form-label">Prioritas</label>
                            <select class="form-select" id="priority" name="priority">
                                <option value="low">Rendah</option>
                                <option value="medium" selected>Sedang</option>
                                <option value="high">Tinggi</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="type" class="form-label">Jenis Pengumuman</label>
                            <select class="form-select" id="type" name="type" onchange="toggleAutoFields()">
                                <option value="umum">Umum</option>
                                <option value="auto welcome">Otomatis - Welcome</option>
                                <option value="auto booking success">Otomatis - Booking Berhasil</option>
                                <option value="auto dp request">Otomatis - DP Request</option>
                                <option value="auto success">Otomatis - Installment Lunas</option>
                                <option value="auto installment">Otomatis - Installment</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="target_audience" class="form-label">Target Audiens</label>
                            <select class="form-select" id="target_audience" name="target_audience">
                                <option value="all students">Semua Siswa</option>
                                <option value="new registrants">Pendaftar Baru</option>
                                <option value="paid students">Siswa yang Sudah Bayar Booking</option>
                                <option value="meeting joined">Siswa yang Sudah Join Meeting</option>
                                <option value="active students">Siswa Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" onchange="toggleAutoFields()">
                                <option value="draft">Draft</option>
                                <option value="published">Terbit</option>
                                <option value="scheduled">Terjadwal</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label for="content" class="form-label">Isi Pengumuman</label>
                        <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                    </div>

                    <!-- Fields untuk pengumuman otomatis -->
                    <div id="paymentButtonField" class="mt-3" style="display: none;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="has_payment_button" name="has_payment_button" value="1">
                            <label class="form-check-label" for="has_payment_button">
                                Tampilkan Button Pembayaran
                            </label>
                        </div>
                    </div>

                    <div id="meetLinkField" class="mt-3" style="display: none;">
                        <label for="meet_link" class="form-label">Link Google Meet</label>
                        <input type="url" class="form-control" id="meet_link" name="meet_link" placeholder="https://meet.google.com/...">
                    </div>

                    <div id="scheduledDateField" class="mt-3" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="scheduled_date" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="scheduled_date" name="scheduled_date">
                            </div>
                            <div class="col-md-6">
                                <label for="scheduled_time" class="form-label">Jam</label>
                                <input type="time" class="form-control" id="scheduled_time" name="scheduled_time">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form Edit Pengumuman -->
<div class="modal fade" id="editAnnouncementModal" tabindex="-1" aria-labelledby="editAnnouncementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAnnouncementModalLabel">
                    <i class="fas fa-edit me-2"></i> Edit Pengumuman
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAnnouncementForm" encript="multipart/form-data" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8">
                            <label for="editTitle" class="form-label">Judul Pengumuman</label>
                            <input type="text" class="form-control" id="editTitle" name="title" required>
                        </div>
                        <div class="col-md-4">
                            <label for="editPriority" class="form-label">Prioritas</label>
                            <select class="form-select" id="editPriority" name="priority">
                                <option value="low">Rendah</option>
                                <option value="medium">Sedang</option>
                                <option value="high">Tinggi</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="editType" class="form-label">Jenis Pengumuman</label>
                            <select class="form-select" id="editType" name="type" onchange="toggleEditAutoFields()">
                                <option value="umum">Umum</option>
                                <option value="auto welcome">Otomatis - Welcome</option>
                                <option value="auto booking success">Otomatis - Booking Berhasil</option>
                                <option value="auto dp request">Otomatis - DP Request</option>
                                <option value="auto success">Otomatis - Installment Lunas</option>
                                <option value="auto installment">Otomatis - Installment</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="editTargetAudience" class="form-label">Target Audiens</label>
                            <select class="form-select" id="editTargetAudience" name="target_audience">
                                <option value="all students">Semua Siswa</option>
                                <option value="new registrants">Pendaftar Baru</option>
                                <option value="paid students">Siswa yang Sudah Bayar Booking</option>
                                <option value="meeting joined">Siswa yang Sudah Join Meeting</option>
                                <option value="active students">Siswa Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="editStatus" class="form-label">Status</label>
                            <select class="form-select" id="editStatus" name="status" onchange="toggleEditAutoFields()">
                                <option value="draft">Draft</option>
                                <option value="published">Terbit</option>
                                <option value="scheduled">Terjadwal</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label for="editContent" class="form-label">Isi Pengumuman</label>
                        <textarea class="form-control" id="editContent" name="content" rows="5" required></textarea>
                    </div>

                    <!-- Fields untuk pengumuman otomatis -->
                    <div id="editPaymentButtonField" class="mt-3" style="display: none;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="editHasPaymentButton" name="has_payment_button">
                            <label class="form-check-label" for="editHasPaymentButton">
                                Tampilkan Button Pembayaran
                            </label>
                        </div>
                    </div>

                    <div id="editMeetLinkField" class="mt-3" style="display: none;">
                        <label for="editMeetLink" class="form-label">Link Google Meet</label>
                        <input type="url" class="form-control" id="editMeetLink" name="meet_link" placeholder="https://meet.google.com/...">
                    </div>

                    <div id="editScheduledDateField" class="mt-3" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="editScheduledDate" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="editScheduledDate" name="scheduled_date">
                            </div>
                            <div class="col-md-6">
                                <label for="editScheduledTime" class="form-label">Jam</label>
                                <input type="time" class="form-control" id="editScheduledTime" name="scheduled_time">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check me-2"></i>Update Pengumuman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Pengumuman -->
<div class="modal fade" id="viewAnnouncementModal" tabindex="-1" aria-labelledby="viewAnnouncementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewAnnouncementModalLabel">
                    <i class="fas fa-eye me-2"></i> Detail Pengumuman
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <!-- Loading State -->
                <div id="viewAnnouncementLoading" class="text-center py-4">
                    <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                    <p class="mt-2">Memuat data...</p>
                </div>

                <!-- Content Container -->
                <div id="viewAnnouncementContent" style="display: none;">
                    <!-- Header Info -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h4 id="viewTitle" class="mb-2">Judul Pengumuman</h4>
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span id="viewStatusBadge" class="badge">Status</span>
                                <span id="viewPriorityBadge" class="badge">Prioritas</span>
                                <span id="viewTypeBadge" class="badge bg-info">Jenis</span>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-file-text me-2"></i>Isi Pengumuman</h6>
                        </div>
                        <div class="card-body">
                            <div id="viewContent" class="mb-0">
                                Konten pengumuman akan tampil di sini...
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-users me-2"></i>Target Audiens</h6>
                                </div>
                                <div class="card-body">
                                    <span id="viewTargetAudience" class="badge bg-secondary">-</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-cog me-2"></i>Fitur Tambahan</h6>
                                </div>
                                <div class="card-body">
                                    <div id="viewAdditionalFeatures">
                                        <span class="text-muted">Tidak ada fitur tambahan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Scheduled Info -->
                    <div id="viewScheduledInfo" class="card mt-3" style="display: none;">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-clock me-2"></i>Jadwal Terbit</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">
                                <i class="fas fa-calendar me-2"></i><span id="viewScheduledDate">-</span>
                                <i class="fas fa-clock ms-3 me-2"></i><span id="viewScheduledTime">-</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Error State -->
                <div id="viewAnnouncementError" class="text-center py-4" style="display: none;">
                    <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                    <p class="mt-2">Gagal memuat data pengumuman</p>
                    <button class="btn btn-primary" onclick="retryLoadAnnouncement()">Coba Lagi</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
                <button type="button" class="btn btn-primary" onclick="editFromView()">
                    <i class="fas fa-edit me-2"></i>Edit
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Pastikan semua variabel global ada
    let currentEditId = null;
    let editAutoSaveInterval;

    // Document Ready
    document.addEventListener('DOMContentLoaded', function() {
        console.log('✅ DOM loaded, initializing JavaScript...');
        
        // Initialize event listeners
        initializeEventListeners();
        
        // Initialize modal handlers
        initializeModalHandlers();
        
        console.log('✅ JavaScript initialization complete');
    });

    // Initialize all event listeners
    function initializeEventListeners() {
        // Toggle auto fields for create form
        const typeField = document.getElementById('type');
        const statusField = document.getElementById('status');
        
        if (typeField) typeField.addEventListener('change', toggleAutoFields);
        if (statusField) statusField.addEventListener('change', toggleAutoFields);
        
        // Toggle auto fields for edit form
        const editTypeField = document.getElementById('editType');
        const editStatusField = document.getElementById('editStatus');
        
        if (editTypeField) editTypeField.addEventListener('change', toggleEditAutoFields);
        if (editStatusField) editStatusField.addEventListener('change', toggleEditAutoFields);
    }

    // Initialize modal handlers
    function initializeModalHandlers() {
        // Create modal
        const createModal = document.getElementById('announcementModal');
        if (createModal) {
            createModal.addEventListener('shown.bs.modal', function () {
                toggleAutoFields(); // Reset fields when modal opens
                document.getElementById('title').focus();
            });
            
            createModal.addEventListener('hidden.bs.modal', function () {
                // Reset form
                const form = document.getElementById('announcementForm');
                if (form) form.reset();
                document.getElementById('_method').value = 'POST';
            });
        }

        // Edit modal
        const editModal = document.getElementById('editAnnouncementModal');
        if (editModal) {
            editModal.addEventListener('shown.bs.modal', function () {
                document.getElementById('editTitle').focus();
            });
            
            editModal.addEventListener('hidden.bs.modal', function () {
                // Reset form
                const form = document.getElementById('editAnnouncementForm');
                if (form) form.reset();
                currentEditId = null;
            });
        }

        // View modal
        const viewModal = document.getElementById('viewAnnouncementModal');
        if (viewModal) {
            viewModal.addEventListener('hidden.bs.modal', function () {
                window.currentViewId = null;
                showLoadingStateView();
            });
        }
    }

    // Fungsi: Toggle field tambahan saat tipe/status berubah (CREATE)
    function toggleAutoFields() {
        const type = document.getElementById('type').value;
        const status = document.getElementById('status').value;

        const paymentField = document.getElementById('paymentButtonField');
        const meetLinkField = document.getElementById('meetLinkField');
        const scheduledField = document.getElementById('scheduledDateField');
        const paymentCheckbox = document.getElementById('has_payment_button');

        if (!type || !status) return;

        // Sembunyikan default
        if (paymentField) paymentField.style.display = 'none';
        if (meetLinkField) meetLinkField.style.display = 'none';
        if (scheduledField) scheduledField.style.display = 'none';

        // Munculkan payment button untuk type yang butuh pembayaran
        if (['auto welcome', 'auto dp request', 'auto booking success'].includes(type) && paymentField) {
            paymentField.style.display = 'block';
            if (paymentCheckbox) paymentCheckbox.checked = true;
        }

        // Munculkan meet link hanya untuk booking success
        if (type === 'auto booking success' && meetLinkField) {
            meetLinkField.style.display = 'block';
        }

        // Munculkan jadwal jika status scheduled
        if (status === 'scheduled' && scheduledField) {
            scheduledField.style.display = 'block';
        }
    }

    // Fungsi: Toggle field tambahan untuk edit
    function toggleEditAutoFields() {
        const type = document.getElementById('editType').value;
        const status = document.getElementById('editStatus').value;

        const paymentField = document.getElementById('editPaymentButtonField');
        const meetLinkField = document.getElementById('editMeetLinkField');
        const scheduledField = document.getElementById('editScheduledDateField');

        if (!type || !status) return;

        // Sembunyikan default
        if (paymentField) paymentField.style.display = 'none';
        if (meetLinkField) meetLinkField.style.display = 'none';
        if (scheduledField) scheduledField.style.display = 'none';

        // Munculkan payment button untuk type yang butuh pembayaran
        if (['auto welcome', 'auto dp request', 'auto booking success'].includes(type) && paymentField) {
            paymentField.style.display = 'block';
        }

        // Munculkan meet link hanya untuk booking success
        if (type === 'auto booking success' && meetLinkField) {
            meetLinkField.style.display = 'block';
        }

        // Munculkan jadwal jika status scheduled
        if (status === 'scheduled' && scheduledField) {
            scheduledField.style.display = 'block';
        }
    }

    // Fungsi: Filter 
    function filterAnnouncements() {
        const statusFilter = document.getElementById('filterStatus').value.toLowerCase();
        const typeFilter = document.getElementById('filterType').value.toLowerCase();
        const searchFilter = document.getElementById('searchAnnouncement').value.toLowerCase();

        const table = document.getElementById('announcementsTable');
        const rows = table.querySelectorAll('tbody tr');

        let visibleCount = 0;

        rows.forEach(row => {
            const status = row.querySelector('td:nth-child(4)').innerText.toLowerCase(); // kolom Status
            const type = row.querySelector('td:nth-child(3)').innerText.toLowerCase();   // kolom Jenis
            const title = row.querySelector('td:nth-child(2)').innerText.toLowerCase();  // kolom Judul dan isi kecilnya juga ikut dicek

            // Cek apakah row cocok filter
            const matchesStatus = !statusFilter || status.includes(statusFilter);
            const matchesType = !typeFilter || type.includes(typeFilter);
            const matchesSearch = !searchFilter || title.includes(searchFilter);

            if (matchesStatus && matchesType && matchesSearch) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Jika tidak ada hasil, tampilkan pesan "Tidak ada pengumuman"
        const tbody = table.querySelector('tbody');
        let noDataRow = tbody.querySelector('.no-data-row');

        if (visibleCount === 0) {
            if (!noDataRow) {
                const tr = document.createElement('tr');
                tr.classList.add('no-data-row');
                tr.innerHTML = `<td colspan="9" class="text-center py-4">Tidak ada pengumuman ditemukan.</td>`;
                tbody.appendChild(tr);
            }
        } else {
            if (noDataRow) noDataRow.remove();
        }
    }


    // Fungsi: Edit pengumuman
    function editAnnouncement(id) {
        console.log('📝 Edit announcement ID:', id);
        currentEditId = id;
        
        // Show modal first
        const modal = new bootstrap.Modal(document.getElementById('editAnnouncementModal'));
        modal.show();
        
        // Fetch data from server
        fetch(`/admin/pengumuman/${id}/edit`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                            document.querySelector('input[name="_token"]')?.value || ''
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('📋 Edit data received:', data);
            
            // Populate form fields
            const form = document.getElementById('editAnnouncementForm');
            form.action = `{{ url('admin/pengumuman') }}/${id}`;
            
            document.getElementById('editTitle').value = data.title || '';
            document.getElementById('editPriority').value = data.priority || 'medium';
            document.getElementById('editType').value = data.type || 'umum';
            document.getElementById('editTargetAudience').value = data.target_audience || 'all students';
            document.getElementById('editStatus').value = data.status || 'draft';
            document.getElementById('editContent').value = data.content || '';
            document.getElementById('editMeetLink').value = data.meet_link || '';
            document.getElementById('editScheduledDate').value = data.scheduled_date || '';
            document.getElementById('editScheduledTime').value = data.scheduled_time || '';
            document.getElementById('editHasPaymentButton').checked = data.has_payment_button === 1 || data.has_payment_button === true;
            
            // Toggle conditional fields
            toggleEditAutoFields();
        })
        .catch(error => {
            console.error('❌ Error loading edit data:', error);
            alert('Gagal memuat data pengumuman: ' + error.message);
            modal.hide();
        });
    }

    // Fungsi: View announcement
   function viewAnnouncement(id) {
    const url = `${window.location.origin}/admin/pengumuman/${id}/show`;

    // Tampilkan loading, sembunyikan konten & error
    document.getElementById('viewAnnouncementLoading').style.display = 'block';
    document.getElementById('viewAnnouncementContent').style.display = 'none';
    document.getElementById('viewAnnouncementError').style.display = 'none';

    fetch(url, {
        method: 'GET',
        headers: { 'Accept': 'application/json' }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        return response.json();
    })
    .then(data => {
        if (!data.success) {
            throw new Error(data.message || 'Gagal memuat data pengumuman');
        }

        // Isi data ke modal sesuai ID yang ada di Blade
        document.getElementById('viewTitle').textContent = data.title || '-';
        document.getElementById('viewContent').innerHTML = data.content || '-';
        document.getElementById('viewTypeBadge').textContent = data.type || '-';
        document.getElementById('viewStatusBadge').textContent = data.status || '-';
        document.getElementById('viewPriorityBadge').textContent = data.priority || '-';
        document.getElementById('viewTargetAudience').textContent = data.target_audience || '-';
        document.getElementById('viewAdditionalFeatures').innerHTML = data.additional_features || '<span class="text-muted">Tidak ada fitur tambahan</span>';

        // Tanggal & waktu terjadwal
        if (data.scheduled_date || data.scheduled_time) {
            document.getElementById('viewScheduledInfo').style.display = 'block';
            document.getElementById('viewScheduledDate').textContent = data.scheduled_date || '-';
            document.getElementById('viewScheduledTime').textContent = data.scheduled_time || '-';
        } else {
            document.getElementById('viewScheduledInfo').style.display = 'none';
        }

        // Tampilkan konten
        document.getElementById('viewAnnouncementLoading').style.display = 'none';
        document.getElementById('viewAnnouncementContent').style.display = 'block';

        // Tampilkan modal
        const modal = new bootstrap.Modal(document.getElementById('viewAnnouncementModal'));
        modal.show();
    })
    .catch(error => {
        console.error('❌ Error loading view data:', error);

        // Tampilkan error state
        document.getElementById('viewAnnouncementLoading').style.display = 'none';
        document.getElementById('viewAnnouncementContent').style.display = 'none';
        document.getElementById('viewAnnouncementError').style.display = 'block';
    });
}



    // Helper Functions untuk View
    function showLoadingStateView() {
        const loadingEl = document.getElementById('viewAnnouncementLoading');
        const contentEl = document.getElementById('viewAnnouncementContent');
        const errorEl = document.getElementById('viewAnnouncementError');
        
        if (loadingEl) loadingEl.style.display = 'block';
        if (contentEl) contentEl.style.display = 'none';
        if (errorEl) errorEl.style.display = 'none';
    }

    function showContentStateView() {
        const loadingEl = document.getElementById('viewAnnouncementLoading');
        const contentEl = document.getElementById('viewAnnouncementContent');
        const errorEl = document.getElementById('viewAnnouncementError');
        
        if (loadingEl) loadingEl.style.display = 'none';
        if (contentEl) contentEl.style.display = 'block';
        if (errorEl) errorEl.style.display = 'none';
    }

    function showErrorStateView() {
        const loadingEl = document.getElementById('viewAnnouncementLoading');
        const contentEl = document.getElementById('viewAnnouncementContent');
        const errorEl = document.getElementById('viewAnnouncementError');
        
        if (loadingEl) loadingEl.style.display = 'none';
        if (contentEl) contentEl.style.display = 'none';
        if (errorEl) errorEl.style.display = 'block';
    }

    function populateViewModal(data) {
        // Basic Info
        const titleEl = document.getElementById('viewTitle');
        const contentEl = document.getElementById('viewContent');
        const targetEl = document.getElementById('viewTargetAudience');
        
        if (titleEl) titleEl.textContent = data.title || 'Tidak ada judul';
        if (contentEl) contentEl.innerHTML = formatContentView(data.content || 'Tidak ada konten');
        if (targetEl) targetEl.textContent = formatTargetAudienceView(data.target_audience);
        
        // Status Badges
        updateStatusBadgeView(data.status);
        updatePriorityBadgeView(data.priority);
        updateTypeBadgeView(data.type);
        
        // Additional Features
        updateAdditionalFeaturesView(data);
        
        // Scheduled Info
        updateScheduledInfoView(data);
    }

    function updateStatusBadgeView(status) {
        const badge = document.getElementById('viewStatusBadge');
        if (!badge) return;
        
        const statusMap = {
            'published': { class: 'bg-success', text: 'Terbit' },
            'draft': { class: 'bg-warning text-dark', text: 'Draft' },
            'scheduled': { class: 'bg-info', text: 'Terjadwal' }
        };
        
        const statusInfo = statusMap[status] || { class: 'bg-secondary', text: status };
        badge.className = `badge ${statusInfo.class}`;
        badge.textContent = statusInfo.text;
    }

    function updatePriorityBadgeView(priority) {
        const badge = document.getElementById('viewPriorityBadge');
        if (!badge) return;
        
        const priorityMap = {
            'high': { class: 'bg-danger', text: 'Tinggi' },
            'medium': { class: 'bg-warning', text: 'Sedang' },
            'low': { class: 'bg-success', text: 'Rendah' }
        };
        
        const priorityInfo = priorityMap[priority] || { class: 'bg-secondary', text: priority };
        badge.className = `badge ${priorityInfo.class}`;
        badge.textContent = `Prioritas ${priorityInfo.text}`;
    }

    function updateTypeBadgeView(type) {
        const badge = document.getElementById('viewTypeBadge');
        if (!badge) return;
        
        const typeMap = {
            'umum': 'Umum',
            'auto welcome': 'Otomatis - Welcome',
            'auto booking success': 'Otomatis - Booking Berhasil'
        };
        
        badge.textContent = typeMap[type] || type;
    }

    function updateAdditionalFeaturesView(data) {
        const container = document.getElementById('viewAdditionalFeatures');
        if (!container) return;
        
        let features = [];
        
        // Payment Button
        if (data.has_payment_button === 1 || data.has_payment_button === true) {
            features.push('<span class="badge bg-primary me-2 mb-1"><i class="fas fa-credit-card me-1"></i> Ada Button Bayar</span>');
        }
        
        // Meet Link
        if (data.meet_link) {
            features.push(`<span class="badge bg-success me-2 mb-1"><i class="fas fa-video me-1"></i> Ada Link Meet</span>`);
            features.push(`<br><small class="text-muted">Link: <a href="${data.meet_link}" target="_blank" class="text-decoration-none">${data.meet_link}</a></small>`);
        }
        
        container.innerHTML = features.length > 0 ? features.join('') : '<span class="text-muted">Tidak ada fitur tambahan</span>';
    }

    function updateScheduledInfoView(data) {
        const container = document.getElementById('viewScheduledInfo');
        if (!container) return;
        
        if (data.status === 'scheduled' && (data.scheduled_date || data.scheduled_time)) {
            container.style.display = 'block';
            const dateEl = document.getElementById('viewScheduledDate');
            const timeEl = document.getElementById('viewScheduledTime');
            
            if (dateEl) dateEl.textContent = data.scheduled_date ? formatDateView(data.scheduled_date) : '-';
            if (timeEl) timeEl.textContent = data.scheduled_time || '-';
        } else {
            container.style.display = 'none';
        }
    }

    function formatContentView(content) {
        return content.replace(/\n/g, '<br>');
    }

    function formatTargetAudienceView(audience) {
        const audienceMap = {
            'all students': 'Semua Siswa',
            'new registrants': 'Pendaftar Baru',
            'paid students': 'Siswa yang Sudah Bayar',
            'active students': 'Siswa Aktif',
            'prospective students': 'Calon Siswa'
        };
        
        return audienceMap[audience] || audience;
    }

    function formatDateView(dateString) {
        if (!dateString) return '-';
        
        try {
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
        } catch (e) {
            return dateString;
        }
    }

    function retryLoadAnnouncement() {
        if (window.currentViewId) {
            viewAnnouncement(window.currentViewId);
        }
    }

    function editFromView() {
        if (window.currentViewId) {
            // Close view modal
            const viewModalEl = document.getElementById('viewAnnouncementModal');
            if (viewModalEl) {
                const viewModal = bootstrap.Modal.getInstance(viewModalEl);
                if (viewModal) viewModal.hide();
            }
            
            // Open edit modal
            setTimeout(() => {
                editAnnouncement(window.currentViewId);
            }, 300);
        }
    }

    // Fungsi konfirmasi hapus
    function confirmDelete(id, title) {
        if (typeof Swal !== 'undefined') {
            // Jika SweetAlert2 tersedia
            Swal.fire({
                title: 'Konfirmasi Hapus',
                html: `Apakah Anda yakin ingin menghapus pengumuman:<br><strong>"${title}"</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash me-2"></i>Ya, Hapus!',
                cancelButtonText: '<i class="fas fa-times me-2"></i>Batal',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const form = document.getElementById('deleteForm');
                    form.action = `{{ url('admin/pengumuman') }}/${id}`;
                    form.submit();
                }
            });
        } else {
            // Fallback ke confirm biasa
            if (confirm(`Apakah Anda yakin ingin menghapus pengumuman "${title}"?`)) {
                const form = document.getElementById('deleteForm');
                form.action = `{{ url('admin/pengumuman') }}/${id}`;
                form.submit();
            }
        }
    }

    // Show success alert jika ada session delete_success
    @if(session('delete_success'))
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session("delete_success") }}',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 5000,
                    timerProgressBar: true
                });
            } else {
                alert('{{ session("delete_success") }}');
            }
        });
    @endif

    // Initialize global variables
    if (typeof window.currentViewId === 'undefined') {
        window.currentViewId = null;
    }

    console.log('✅ All JavaScript functions loaded');
</script>
@endpush
