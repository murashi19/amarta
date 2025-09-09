@extends('layouts.dashboardAdmin')

@section('title', 'Manajemen Transaksi')

@push('styles')
<style>
    .badge {
        padding: 0.375rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .card-stats {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-primary-dark, #0056b3) 100%);
    }
    
    .card-stats.bg-success {
        background: linear-gradient(135deg, var(--bs-success) 0%, #157347 100%) !important;
    }
    
    .card-stats.bg-warning {
        background: linear-gradient(135deg, var(--bs-warning) 0%, #e0a800 100%) !important;
    }
    
    .card-stats.bg-info {
        background: linear-gradient(135deg, var(--bs-info) 0%, #087990 100%) !important;
    }
    
    .card-stats.bg-danger {
        background: linear-gradient(135deg, var(--bs-danger) 0%, #dc3545 100%) !important;
    }
    
    .card-stats:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
    }

    .filter-card {
        margin-left: 20px;
        width: 100%;
    }
    
    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: white;
        border: 2px solid #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .transaction-amount {
        font-weight: 700;
        font-size: 1.125rem;
        color: #059669;
    }
    
    .installment-amount {
        font-weight: 700;
        font-size: 1rem;
        color: #0d6efd;
    }
    
    .proof-preview {
        max-width: 80px;
        max-height: 80px;
        border-radius: 8px;
        transition: transform 0.2s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .proof-preview:hover {
        transform: scale(1.1);
    }

    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
    }
    
    /* Ensure action column is always visible */
    .table-responsive .table {
        min-width: 100%;
    }
    
    .action-column {
        min-width: 120px;
        width: 120px;
        position: sticky;
        right: 0;
        background-color: white;
        z-index: 10;
        border-left: 1px solid #dee2e6;
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
    }
    
    .action-column th,
    .action-column td {
        background-color: white;
        position: sticky;
        right: 0;
        z-index: 10;
    }
    
    .action-column th {
        background-color: var(--bs-primary);
        color: white;
        border-left: 1px solid rgba(255,255,255,0.2);
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
    }
    
    .table thead th {
        background: var(--bs-primary);
        color: white;
        border: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
        padding: 1rem 0.75rem;
    }
    
    .table tbody tr {
        transition: background-color 0.2s ease;
    }
    
    .table tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }
    
    .btn-group-vertical .btn {
        margin-bottom: 0.25rem;
    }
    
    .btn-group-vertical .btn:last-child {
        margin-bottom: 0;
    }
    
    .status-dropdown {
        min-width: 140px;
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
        border-radius: 0.375rem;
        transition: all 0.2s ease;
    }

    .status-dropdown:focus {
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25);
        border-color: #86b7fe;
    }

    .status-message {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1055;
        min-width: 350px;
        max-width: 500px;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        border: none;
        border-radius: 8px;
    }
    
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgba(0,0,0,0.1), 0 1px 2px 0 rgba(0,0,0,0.06);
    }
    
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #d1d5db;
        transition: all 0.2s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25);
    }
    
    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .btn:hover {
        transform: translateY(-1px);
    }

    /* Tab Styling */
    .nav-tabs {
        border-bottom: 2px solid #dee2e6;
        margin-bottom: 2rem;
    }

    .nav-tabs .nav-link {
        border: none;
        border-radius: 8px 8px 0 0;
        color: #6c757d;
        font-weight: 600;
        padding: 1rem 1.5rem;
        margin-right: 0.5rem;
        transition: all 0.3s ease;
        position: relative;
    }

    .nav-tabs .nav-link:hover {
        border-color: transparent;
        color: var(--bs-primary);
        background-color: rgba(13, 110, 253, 0.1);
    }

    .nav-tabs .nav-link.active {
        color: var(--bs-primary);
        background-color: white;
        border: none;
        border-bottom: 3px solid var(--bs-primary);
    }

    .nav-tabs .nav-link i {
        margin-right: 0.5rem;
    }

    .installment-progress {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
    }

    .progress {
        height: 8px;
        border-radius: 4px;
        background-color: #e9ecef;
    }

    .progress-bar {
        border-radius: 4px;
        transition: width 0.6s ease;
    }
    
    /* ========== RESPONSIVE IMPROVEMENTS ========== */
    
    /* Large Tablets and Small Desktops */
    @media (max-width: 992px) {
        .container, .container-fluid {
            padding-left: 15px;
            padding-right: 15px;
        }
        
        .filter-card {
            margin-left: 10px;
        }
        
        .card-stats h3 {
            font-size: 1.75rem;
        }
        
        .nav-tabs .nav-link {
            padding: 0.875rem 1.25rem;
            margin-right: 0.25rem;
        }
    }
    
    /* Tablets */
    @media (max-width: 768px) {
        /* Container and spacing */
        .container, .container-fluid {
            padding-left: 10px;
            padding-right: 10px;
        }
        
        /* Card stats improvements */
        .card-stats {
            margin-bottom: 1rem;
        }
        
        .card-stats h3 {
            font-size: 1.5rem;
        }
        
        .card-stats .card-body {
            padding: 1rem;
        }
        
        /* Filter card mobile adjustments */
        .filter-card {
            margin-left: 0;
            margin-top: 1rem;
        }
        
        /* Table responsive improvements */
        .table-responsive {
            font-size: 0.875rem;
            margin-bottom: 1rem;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .table-responsive .table {
            min-width: 600px; /* Ensure minimum width for horizontal scroll */
        }
        
        /* Action column mobile adjustments */
        .action-column {
            min-width: 100px;
            width: 100px;
        }
        
        .action-column .btn-group-vertical .btn {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        
        .table thead th {
            padding: 0.75rem 0.5rem;
            font-size: 0.75rem;
        }
        
        .table tbody td {
            padding: 0.75rem 0.5rem;
            vertical-align: middle;
        }
        
        /* Button groups */
        .btn-group-vertical {
            width: 100%;
        }
        
        .btn-group {
            flex-direction: column;
            width: 100%;
        }
        
        .btn-group .btn {
            margin-bottom: 0.25rem;
            border-radius: 8px !important;
        }
        
        /* Status message */
        .status-message {
            right: 10px;
            left: 10px;
            min-width: auto;
            max-width: none;
        }
        
        /* Avatar adjustments */
        .avatar {
            width: 35px;
            height: 35px;
            font-size: 0.75rem;
        }

        /* Tab improvements */
        .nav-tabs {
            flex-wrap: nowrap;
            overflow-x: auto;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 1.5rem;
            -webkit-overflow-scrolling: touch;
        }

        .nav-tabs .nav-link {
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            white-space: nowrap;
            min-width: max-content;
        }
        
        .nav-tabs .nav-link i {
            margin-right: 0.25rem;
        }
        
        /* Form elements */
        .form-control, .form-select {
            font-size: 1rem; /* Prevent zoom on iOS */
        }
        
        /* Status dropdown */
        .status-dropdown {
            min-width: 120px;
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }
        
        /* Progress bars */
        .installment-progress {
            padding: 0.5rem;
        }
        
        /* Proof preview */
        .proof-preview {
            max-width: 60px;
            max-height: 60px;
        }
        
        /* Amount displays */
        .transaction-amount {
            font-size: 1rem;
        }
        
        .installment-amount {
            font-size: 0.875rem;
        }
    }
    
    /* Mobile Phones */
    @media (max-width: 576px) {
        /* Container */
        .container, .container-fluid {
            padding-left: 8px;
            padding-right: 8px;
        }
        
        /* Flexbox improvements for mobile */
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 1rem;
        }
        
        .d-flex.align-items-center {
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        
        /* Card stats mobile */
        .card-stats {
            margin-bottom: 0.75rem;
        }
        
        .card-stats h3 {
            font-size: 1.25rem;
        }
        
        .card-stats .card-body {
            padding: 0.875rem;
            text-align: center;
        }
        
        .card-stats p {
            font-size: 0.8rem;
            margin-bottom: 0;
        }
        
        /* Table mobile specific */
        .table {
            font-size: 0.8rem;
        }
        
        .table-responsive .table {
            min-width: 500px; /* Smaller minimum width for mobile */
        }
        
        /* Action column mobile specific */
        .action-column {
            min-width: 80px;
            width: 80px;
        }
        
        .action-column .btn {
            font-size: 0.7rem;
            padding: 0.2rem 0.4rem;
        }
        
        .table thead th {
            padding: 0.5rem 0.25rem;
            font-size: 0.7rem;
        }
        
        .table tbody td {
            padding: 0.5rem 0.25rem;
        }
        
        /* Hide less important columns on very small screens */
        .table .d-none-xs {
            display: none !important;
        }
        
        /* Button improvements */
        .btn {
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
        }
        
        .btn-group .btn {
            padding: 0.375rem 0.5rem;
            font-size: 0.75rem;
            margin-bottom: 0.25rem;
            width: 100%;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.7rem;
        }
        
        /* Avatar mobile */
        .avatar {
            width: 30px;
            height: 30px;
            font-size: 0.65rem;
        }
        
        /* Tab mobile specific */
        .nav-tabs {
            margin-bottom: 1rem;
            padding-bottom: 0;
        }
        
        .nav-tabs .nav-link {
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
            margin-right: 0.125rem;
        }
        
        .nav-tabs .nav-link i {
            display: none; /* Hide icons on very small screens */
        }
        
        /* Form elements mobile */
        .form-control, .form-select {
            padding: 0.5rem;
            font-size: 1rem;
        }
        
        .form-label {
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }
        
        /* Status message mobile */
        .status-message {
            top: 10px;
            right: 5px;
            left: 5px;
            font-size: 0.875rem;
        }
        
        /* Badge mobile */
        .badge {
            padding: 0.25rem 0.5rem;
            font-size: 0.7rem;
        }
        
        /* Amount displays mobile */
        .transaction-amount {
            font-size: 0.95rem;
        }
        
        .installment-amount {
            font-size: 0.8rem;
        }
        
        /* Progress mobile */
        .progress {
            height: 6px;
        }
        
        .installment-progress {
            padding: 0.375rem;
            font-size: 0.8rem;
        }
        
        /* Proof preview mobile */
        .proof-preview {
            max-width: 50px;
            max-height: 50px;
        }
        
        /* Card mobile spacing */
        .card {
            margin-bottom: 1rem;
        }
        
        .card .card-body {
            padding: 0.75rem;
        }
        
        .card .card-header {
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
        }
        
        /* Utility classes for mobile */
        .text-mobile-center {
            text-align: center !important;
        }
        
        .w-mobile-100 {
            width: 100% !important;
        }
        
        .mb-mobile-2 {
            margin-bottom: 0.5rem !important;
        }
        
        .p-mobile-2 {
            padding: 0.5rem !important;
        }
    }
    
    /* Extra Small Phones */
    @media (max-width: 375px) {
        .container, .container-fluid {
            padding-left: 5px;
            padding-right: 5px;
        }
        
        .card-stats h3 {
            font-size: 1.1rem;
        }
        
        .table {
            font-size: 0.75rem;
        }
        
        .btn {
            font-size: 0.8rem;
            padding: 0.375rem 0.5rem;
        }
        
        .nav-tabs .nav-link {
            padding: 0.375rem 0.5rem;
            font-size: 0.75rem;
        }
        
        .avatar {
            width: 25px;
            height: 25px;
            font-size: 0.6rem;
        }
    }
    
    /* Touch device improvements */
    @media (hover: none) and (pointer: coarse) {
        .card-stats:hover {
            transform: none;
        }
        
        .btn:hover {
            transform: none;
        }
        
        .proof-preview:hover {
            transform: none;
        }
        
        /* Increase touch targets */
        .btn {
            min-height: 44px;
            min-width: 44px;
        }
        
        .nav-tabs .nav-link {
            min-height: 44px;
        }
        
        .form-control, .form-select {
            min-height: 44px;
        }
    }
    
    /* High DPI displays */
    @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
        .avatar {
            border-width: 1px;
        }
        
        .card-stats {
            box-shadow: 0 2px 4px -1px rgba(0,0,0,0.1), 0 1px 2px -1px rgba(0,0,0,0.06);
        }
    }
    
    /* Landscape mobile orientation */
    @media (max-width: 768px) and (orientation: landscape) {
        .nav-tabs {
            margin-bottom: 1rem;
        }
        
        .card-stats {
            margin-bottom: 0.75rem;
        }
        
        .status-message {
            top: 5px;
        }
    }
    

    
    /* Reduced motion for accessibility */
    @media (prefers-reduced-motion: reduce) {
        .card-stats, .btn, .proof-preview {
            transition: none;
        }
        
        .progress-bar {
            transition: none;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-3 px-lg-4">
    <!-- Header -->
    <div class="row mb-4 mt-4">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <div>
                    <h2 class="mb-1">
                        <i class="fas fa-credit-card me-2 text-primary"></i> 
                        Manajemen Transaksi
                    </h2>
                    <p class="text-muted mb-0">Kelola data transaksi dan cicilan sistem LPK dengan mudah</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs" id="transactionTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="transactions-tab" data-bs-toggle="tab" data-bs-target="#transactions" type="button" role="tab" aria-controls="transactions" aria-selected="true">
                <i class="fas fa-credit-card"></i>Transaksi Utama
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="installments-tab" data-bs-toggle="tab" data-bs-target="#installments" type="button" role="tab" aria-controls="installments" aria-selected="false">
                <i class="fas fa-coins"></i>Cicilan Program Kelas
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="transactionTabsContent">
        
        <!-- Transaksi Utama Tab -->
        <div class="tab-pane fade show active" id="transactions" role="tabpanel" aria-labelledby="transactions-tab">
            <!-- Stats Cards -->
            <div class="row g-3 g-lg-4 mb-4">
                <!-- Total Transaksi -->
                <div class="col-6 col-lg-3">
                    <div class="card card-stats bg-primary text-white h-100">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="mb-1">{{ $transactions->total() ?? 0 }}</h3>
                                    <p class="mb-0 small opacity-90">Total Transaksi</p>
                                </div>
                                <i class="fas fa-credit-card fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaksi Selesai -->
                <div class="col-6 col-lg-3">
                    <div class="card card-stats bg-success text-white h-100">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="mb-1">
                                        {{ $transactions->where('status', 'Completed')->count() ?? 0 }}
                                    </h3>
                                    <p class="mb-0 small opacity-90">Transaksi Selesai</p>
                                </div>
                                <i class="fas fa-check-circle fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menunggu Verifikasi -->
                <div class="col-6 col-lg-3">
                    <div class="card card-stats bg-warning text-white h-100">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @php
                                        $pendingCount = $transactions->whereIn('status', ['Pending', 'Verification'])->count();
                                    @endphp
                                    <h3 class="mb-1">{{ $pendingCount }}</h3>
                                    <p class="mb-0 small opacity-90">Menunggu Verifikasi</p>
                                </div>
                                <i class="fas fa-clock fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Pendapatan -->
                <div class="col-6 col-lg-3">
                    <div class="card card-stats bg-info text-white h-100">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="mb-1">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h3>
                                    <p class="mb-0 small opacity-90">Total Pendapatan</p>
                                </div>
                                <i class="fas fa-money-bill-wave fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter & Search for Transactions -->
            <div class="card mb-4">
                <div class="card-header bg-light border-0">
                    <h6 class="mb-0">
                        <i class="fas fa-filter me-2"></i>Filter & Pencarian Transaksi
                    </h6>
                </div>
                <div class="card-body filter-card">
                    <div class="row g-3">
                        <!-- Search Input -->
                        <div class="col-12 col-md-6 col-lg-4">
                            <label for="searchTransaction" class="form-label fw-semibold">Pencarian</label>
                            <div class="input-group">
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    placeholder="Nama, email, ID transaksi..." 
                                    id="searchTransaction"
                                >
                                <button type="button" class="btn btn-primary" onclick="filterTransactions()">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Filter Type -->
                        <div class="col-12 col-md-3 col-lg-3">
                            <label for="filterType" class="form-label fw-semibold">Tipe Transaksi</label>
                            <select class="form-select" id="filterType" onchange="filterTransactions()">
                                <option value="">Semua Tipe</option>
                                <option value="booking">Booking</option>
                                <option value="dp">DP</option>
                                <option value="pemantapan">Pemantapan</option>
                                <option value="pemberangkatan">Pemberangkatan</option>
                            </select>
                        </div>

                        <!-- Filter Status -->
                        <div class="col-6 col-md-3 col-lg-2">
                            <label for="filterStatus" class="form-label fw-semibold">Status</label>
                            <select class="form-select" id="filterStatus" onchange="filterTransactions()">
                                <option value="">Semua Status</option>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                                <option value="failed">Failed</option>
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-12 col-md-3 col-lg-3">
                            <label class="form-label fw-semibold">&nbsp;</label>
                            <div class="d-flex gap-2 flex-wrap">
                                <a 
                                    href="{{ route('admin.transaksi') }}" 
                                    class="btn btn-outline-secondary flex-fill flex-lg-grow-0"
                                    title="Reset Filter"
                                >
                                    <i class="fas fa-undo me-1"></i> Reset
                                </a>
                                <a href="{{ route('admin.transaksi.export', request()->query()) }}"
                                    class="btn btn-success flex-fill flex-lg-grow-0"
                                    title="Export Excel Transaksi"
                                    target="_blank">
                                    <i class="fas fa-download me-1"></i> Export
                                </a>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="card">
                <div class="card-header bg-light border-0 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">
                        <i class="fas fa-table me-2"></i>Data Transaksi
                    </h6>
                    @if(isset($transactions))
                        <span class="badge bg-primary">{{ $transactions->total() }} Total</span>
                    @endif
                </div>
                
                <div class="card-body p-0">
                    <!-- Alert Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show m-3 mb-0 rounded">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show m-3 mb-0 rounded">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="transactionsTable">
                            <thead class="table-dark">
                                <tr>
                                    <th width="5%" class="text-center">#</th>
                                    <th width="22%">Pengguna</th>
                                    <th width="10%" class="text-center">Tipe</th>
                                    <th width="13%" class="text-end">Jumlah</th>
                                    <th width="18%">Status</th>
                                    <th width="12%" class="text-center">Bukti</th>
                                    <th width="20%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($transactions) && $transactions->count() > 0)
                                    @foreach($transactions as $index => $transaction)
                                    <tr>
                                        <td class="text-center align-middle">
                                            <span class="fw-bold">{{ $loop->iteration }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                @if(optional($transaction->user)->photo)
                                                    <img src="{{ asset('storage/' . $transaction->user->photo) }}" 
                                                        alt="Foto Pengguna" 
                                                        class="avatar bg-primary me-3" 
                                                        style="width: 35px; height: 35px; object-fit: cover;">
                                                @else
                                                    <div class="avatar bg-primary me-3" style="width: 35px; height: 35px; font-size: 0.8rem;">
                                                        {{ strtoupper(substr($transaction->user->name ?? 'U', 0, 2)) }}
                                                    </div>
                                                @endif

                                                <div class="flex-grow-1">
                                                    <div class="fw-semibold mb-1" style="font-size: 0.9rem;">
                                                        {{ $transaction->user->name ?? '0' }}
                                                    </div>
                                                    <small class="text-muted d-block">{{ $transaction->user->email ?? 'N/A' }}</small>
                                                    <small class="text-info">
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y H:i') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            @if($transaction->type == 'booking')
                                                <span class="badge bg-primary">
                                                    <i class="fas fa-calendar me-1"></i>Booking
                                                </span>
                                            @elseif($transaction->type == 'dp')
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-money-check me-1"></i>DP
                                                </span>
                                            @elseif($transaction->type == 'pemantapan')
                                                <span class="badge bg-info text-dark">
                                                    <i class="fas fa-chalkboard-teacher me-1"></i>Pemantapan
                                                </span>
                                            @elseif($transaction->type == 'pemberangkatan')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-plane-departure me-1"></i>Pemberangkatan
                                                </span>
                                            @elseif($transaction->type == 'lunas')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i>Lunas
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-question-circle me-1"></i>Unknown
                                                </span>
                                            @endif
                                        </td>

                                        <td class="text-end align-middle">
                                            <div class="transaction-amount">
                                                Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="mb-1">
                                                <span class="badge fs-6
                                                    {{ $transaction->status == 'Pending' ? 'bg-warning text-dark' : '' }}
                                                    {{ $transaction->status == 'Completed' ? 'bg-success' : '' }}
                                                    {{ $transaction->status == 'Failed' ? 'bg-danger' : '' }}
                                                    {{ $transaction->status == 'Verification' ? 'bg-info' : '' }}">
                                                    <i class="fas fa-{{ $transaction->status == 'Pending' ? 'clock' : ($transaction->status == 'Completed' ? 'check' : ($transaction->status == 'Failed' ? 'times' : 'eye')) }} me-1"></i>
                                                    {{ $transaction->status }}
                                                </span>
                                            </div>

                                            @if($transaction->paid_at)
                                                <small class="text-success d-block">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    Dibayar: {{ \Carbon\Carbon::parse($transaction->paid_at)->format('d/m/Y H:i') }}
                                                </small>
                                            @endif
                                        </td>
                                            <td class="text-center align-middle">
                                                @if($transaction->feePayments->isNotEmpty() && $transaction->feePayments->first()->photo_url)
                                                    <a href="{{ $transaction->feePayments->first()->photo_url }}" 
                                                    target="_blank"
                                                    class="btn btn-sm btn-outline-info">
                                                        <i class="fas fa-image me-1"></i> Lihat
                                                    </a>
                                                @else
                                                    <span class="text-muted">
                                                        <i class="fas fa-minus"></i>
                                                    </span>
                                                @endif
                                            </td>

                                        <td class="align-middle">
                                            <div class="d-flex flex-column gap-1" role="group">
                                                <!-- View Detail Button -->
                                                <a href="{{ route('admin.detailTransaksi', $transaction->id) }}" 
                                                   class="btn btn-outline-info btn-sm">
                                                    <i class="fas fa-eye me-1"></i> Detail
                                                </a>

                                                <!-- Verification Actions -->
                                                @php
                                                    $totalPaid = $transaction->feePayments->sum('amount');
                                                    $isAmountMismatched = $totalPaid < $transaction->amount;
                                                @endphp
                                                @if($transaction->status === 'Verification' && !$isAmountMismatched)
                                                <div class="d-flex gap-1">
                                                    <button class="btn btn-outline-success btn-sm flex-fill" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#approveModal" 
                                                            data-id="{{ $transaction->id }}">
                                                        <i class="fas fa-check me-1"></i> Terima
                                                    </button>
                                                    <form method="POST" action="{{ route('admin.transaksi.verifyWithMeeting') }}" class="flex-fill">
                                                        @csrf
                                                        <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                                                        <input type="hidden" name="reject" value="1">
                                                        <button type="submit" class="btn btn-outline-danger btn-sm w-100"
                                                                onclick="return confirm('Yakin ingin menolak transaksi ini?')">
                                                            <i class="fas fa-times me-1"></i> Tolak
                                                        </button>
                                                    </form>
                                                </div>
                                                @endif

                                                <!-- Delete Button -->
                                                <button type="button" class="btn btn-outline-danger btn-sm w-100" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $transaction->id }}">
                                                    <i class="fas fa-trash me-1"></i> Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-credit-card fa-3x mb-3 opacity-50"></i>
                                            <h6>Tidak ada data transaksi</h6>
                                            <p class="small mb-0">Data transaksi akan muncul di sini setelah ada transaksi</p>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Pagination -->
                @if(isset($transactions) && $transactions->hasPages())
                <div class="card-footer bg-light border-0 d-flex flex-column flex-lg-row justify-content-between align-items-center gap-3">
                    <div class="text-muted small">
                        Menampilkan {{ $transactions->firstItem() ?? 0 }} - {{ $transactions->lastItem() ?? 0 }} 
                        dari {{ $transactions->total() }} data
                    </div>
                    <div>
                        {{ $transactions->appends(request()->query())->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Cicilan Tab -->
        <div class="tab-pane fade" id="installments" role="tabpanel" aria-labelledby="installments-tab">
            <!-- Installment Stats Cards -->
            <div class="row g-3 g-lg-4 mb-4">
                <!-- Total Cicilan -->
                <div class="col-6 col-lg-3">
                    <div class="card card-stats bg-primary text-white h-100">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="mb-1">{{ $installments->total() ?? 0 }}</h3>
                                    <p class="mb-0 small opacity-90">Total Cicilan</p>
                                </div>
                                <i class="fas fa-coins fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cicilan Selesai -->
                <div class="col-6 col-lg-3">
                    <div class="card card-stats bg-success text-white h-100">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="mb-1">
                                        {{ $installments->where('status', 'Completed')->count() ?? 0 }}
                                    </h3>
                                    <p class="mb-0 small opacity-90">Cicilan Selesai</p>
                                </div>
                                <i class="fas fa-check-double fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>

               <!-- Menunggu Verifikasi Cicilan -->
                <div class="col-6 col-lg-3">
                    <div class="card card-stats bg-warning text-white h-100">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @php
                                        $pendingInstallments = $installments->whereIn('status', ['Pending', 'Verification'])->count();
                                    @endphp
                                    <h3 class="mb-1">{{ $pendingInstallments }}</h3>
                                    <p class="mb-0 small opacity-90">Menunggu Verifikasi</p>
                                </div>
                                <i class="fas fa-hourglass-half fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Nilai Cicilan -->
                <div class="col-6 col-lg-3">
                    <div class="card card-stats bg-info text-white h-100">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @php
                                        $totalInstallmentValue = $installments->where('status', 'Completed')->sum('amount');
                                    @endphp
                                    <h3 class="mb-1">Rp {{ number_format($totalInstallmentValue, 0, ',', '.') }}</h3>
                                    <p class="mb-0 small opacity-90">Total Nilai Cicilan</p>
                                </div>
                                <i class="fas fa-chart-line fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter & Search for Installments -->
            <div class="card mb-4">
                <div class="card-header bg-light border-0">
                    <h6 class="mb-0">
                        <i class="fas fa-filter me-2"></i>Filter & Pencarian Cicilan
                    </h6>
                </div>
                <div class="card-body filter-card">
                    <form method="GET" action="{{ route('admin.transaksi') }}" id="installmentFilterForm" class="auto-submit">
                        <input type="hidden" name="tab" value="installments">
                        <div class="row g-3">
                            <!-- Search Input -->
                            <div class="col-12 col-md-6 col-lg-4">
                                <label for="searchInstallment" class="form-label fw-semibold">Pencarian</label>
                                <div class="input-group">
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        name="search_installment"
                                        value="{{ request('search_installment') }}"
                                        placeholder="Nama, email pengguna..." 
                                        id="searchInstallment"
                                    >
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Filter Status Cicilan -->
                            <div class="col-6 col-md-3 col-lg-3">
                                <label for="filterInstallmentStatus" class="form-label fw-semibold">Status Cicilan</label>
                                <select class="form-select" name="status_installment" id="filterInstallmentStatus" onchange="document.getElementById('installmentFilterForm').submit()">
                                    <option value="">Semua Status</option>
                                    <option value="Pending" {{ request('status_installment') == 'Pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="Verification" {{ request('status_installment') == 'Verification' ? 'selected' : '' }}>
                                        Verification
                                    </option>
                                    <option value="Completed" {{ request('status_installment') == 'Completed' ? 'selected' : '' }}>
                                        Completed
                                    </option>
                                    <option value="Failed" {{ request('status_installment') == 'Failed' ? 'selected' : '' }}>
                                        Failed
                                    </option>
                                </select>
                            </div>

                            <!-- Action Buttons -->
                            <div class="col-12 col-md-6 col-lg-5">
                                <label class="form-label fw-semibold">&nbsp;</label>
                                <div class="d-flex gap-2 flex-wrap">
                                    <a 
                                        href="{{ route('admin.transaksi') }}?tab=installments" 
                                        class="btn btn-outline-secondary flex-fill flex-lg-grow-0"
                                        title="Reset Filter"
                                    >
                                        <i class="fas fa-undo me-1"></i> Reset
                                    </a>
                                    <a href="{{ route('admin.installments.export', request()->query()) }}"
                                        class="btn btn-success flex-fill flex-lg-grow-0"
                                        title="Export Excel Cicilan"
                                        target="_blank">
                                        <i class="fas fa-download me-1"></i> Export
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Installments Table -->
            <div class="card">
                <div class="card-header bg-light border-0 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">
                        <i class="fas fa-table me-2"></i>Data Cicilan Program Kelas
                    </h6>
                    @if(isset($installments))
                        <span class="badge bg-primary">{{ $installments->total() }} Total</span>
                    @endif
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="installmentsTable">
                            <thead class="table-dark">
                                <tr>
                                    <th width="5%" class="text-center">#</th>
                                    <th width="20%">Pengguna</th>
                                    <th width="15%">Transaksi Utama</th>
                                    <th width="12%" class="text-end">Cicilan</th>
                                    <th width="12%" class="text-end">Progress</th>
                                    <th width="15%">Status</th>
                                    <th width="10%" class="text-center">Bukti</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($installments) && $installments->count() > 0)
                                    @foreach($installments as $installment)
                                    <tr>
                                        <td class="text-center align-middle">
                                            <span class="fw-bold">{{ $loop->iteration }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                @if($installment->transaction?->user?->photo)
                                                    <img src="{{ asset('storage/' . $installment->transaction?->user?->photo) }}" 
                                                        alt="Foto Pengguna" 
                                                        class="avatar bg-primary me-3" 
                                                        style="width: 35px; height: 35px; object-fit: cover;">
                                                @else
                                                    <div class="avatar bg-primary me-3" style="width: 35px; height: 35px; font-size: 0.8rem;">
                                                        {{ strtoupper(substr($installment->transaction?->user?->name ?? 'U', 0, 2)) }}
                                                    </div>
                                                @endif
                                                <div class="flex-grow-1">
                                                    <div class="fw-semibold mb-1" style="font-size: 0.9rem;">
                                                        {{ $installment->transaction->user->name ?? 'N/A' }}
                                                    </div>
                                                    <small class="text-muted d-block">{{ $installment->transaction->user->email ?? 'N/A' }}</small>
                                                    <small class="text-info">
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ \Carbon\Carbon::parse($installment->created_at)->format('d/m/Y H:i') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="small">
                                                <div class="fw-semibold text-primary">
                                                    ID: #{{ $installment->transaction->id }}
                                                </div>
                                                <div class="text-muted">
                                                    Total: Rp {{ number_format($installment->transaction->amount, 0, ',', '.') }}
                                                </div>
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-money-check me-1"></i>{{ ucfirst($installment->transaction->type) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-end align-middle">
                                            <div class="installment-amount">
                                                Rp {{ number_format($installment->amount, 0, ',', '.') }}
                                            </div>
                                            <small class="text-muted">Cicilan ke-{{ $installment->installment_number ?? 'N/A' }}</small>
                                        </td>
                                        <td class="text-end align-middle">
                                            @php
                                                $totalPaid = App\Models\FeePayment::where('transaction_id', $installment->transaction_id)
                                                    ->where('status', 'Completed')
                                                    ->sum('amount');
                                                $percentage = $installment->transaction->amount > 0 ? 
                                                    ($totalPaid / $installment->transaction->amount) * 100 : 0;
                                            @endphp
                                            <div class="installment-progress">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <small class="text-muted">{{ number_format($percentage, 1) }}%</small>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar 
                                                        {{ $percentage >= 100 ? 'bg-success' : ($percentage >= 50 ? 'bg-info' : 'bg-warning') }}" 
                                                        role="progressbar" 
                                                        style="width: {{ min($percentage, 100) }}%"
                                                        aria-valuenow="{{ $percentage }}" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <small class="text-muted">
                                                    Rp {{ number_format($totalPaid, 0, ',', '.') }} / 
                                                    Rp {{ number_format($installment->transaction->amount, 0, ',', '.') }}
                                                </small>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="mb-1">
                                                <span class="badge fs-6
                                                    {{ $installment->status == 'Pending' ? 'bg-warning text-dark' : '' }}
                                                    {{ $installment->status == 'Verification' ? 'bg-info' : '' }}
                                                    {{ $installment->status == 'Completed' ? 'bg-success' : '' }}
                                                    {{ $installment->status == 'Failed' ? 'bg-danger' : '' }}">
                                                    <i class="fas fa-{{ $installment->status == 'Pending' ? 'clock' : ($installment->status == 'Verification' ? 'checklist' : ($installment->status == 'Completed' ? 'check' : 'times')) }} me-1"></i>
                                                    {{ $installment->status }}
                                                </span>
                                            </div>

                                            @if($installment->paid_at)
                                                <small class="text-success d-block">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    Dibayar: {{ \Carbon\Carbon::parse($installment->paid_at)->format('d/m/Y H:i') }}
                                                </small>
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            @if($installment->photo_url)
                                                <a href="{{ $installment->photo_url }}"  
                                                target="_blank" 
                                                class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-image me-1"></i> Lihat
                                                </a>
                                            @else
                                                <span class="text-muted">
                                                    <i class="fas fa-minus"></i>
                                                </span>
                                            @endif
                                        </td>

                                        <td class="align-middle">
                                            <div class="d-flex flex-column gap-1" role="group">
                                                <!-- Verification Actions -->
                                                @if(in_array($installment->status, ['Verification', 'Pending']))
                                                    <div class="d-flex gap-1">
                                                        <button type="button" class="btn btn-outline-success btn-sm w-100" 
                                                                onclick="confirmApprove('{{ $installment->id }}')">
                                                            <i class="fas fa-check me-1"></i> Terima
                                                        </button>

                                                        <button type="button" class="btn btn-outline-danger btn-sm w-100" 
                                                                onclick="confirmReject('{{ $installment->id }}')">
                                                            <i class="fas fa-times me-1"></i> Tolak
                                                        </button>
                                                    </div>
                                                @endif

                                                <!-- Detail Button -->
                                                <a href="{{ route('admin.installments.detail', $installment->id) }}" 
                                                   class="btn btn-outline-info btn-sm">
                                                    <i class="fas fa-eye me-1"></i> Detail
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-coins fa-3x mb-3 opacity-50"></i>
                                            <h6>Tidak ada data cicilan</h6>
                                            <p class="small mb-0">Data cicilan akan muncul di sini setelah ada pembayaran cicilan</p>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Pagination for Installments -->
                @if(isset($installments) && $installments->hasPages())
                <div class="card-footer bg-light border-0 d-flex flex-column flex-lg-row justify-content-between align-items-center gap-3">
                    <div class="text-muted small">
                        Menampilkan {{ $installments->firstItem() ?? 0 }} - {{ $installments->lastItem() ?? 0 }} 
                        dari {{ $installments->total() }} data cicilan
                    </div>
                    <div>
                        {{ $installments->appends(request()->query())->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Status Messages Container -->
<div id="statusMessages"></div>

<!-- Modal Terima Transaksi -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form method="POST" action="{{ route('admin.transaksi.verifyWithMeeting') }}">
            @csrf
            <input type="hidden" name="transaction_id" id="approveTransactionId">

            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title" id="approveModalLabel">
                        <i class="fas fa-video me-2"></i>Persetujuan Transaksi & Jadwal Meeting
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                        <i class="fas fa-info-circle me-3 fa-lg"></i>
                        <div>
                            <h6 class="alert-heading mb-1">Informasi Penting</h6>
                            <p class="mb-0">Dengan menyetujui transaksi ini, sistem akan otomatis mengirimkan email berisi detail meeting kepada pengguna.</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="meeting_date" class="form-label fw-semibold">
                                <i class="fas fa-calendar me-2 text-primary"></i>Tanggal Meeting
                            </label>
                            <input type="date" 
                                   name="meeting_date" 
                                   id="meeting_date"
                                   class="form-control form-control-lg" 
                                   required
                                   min="{{ date('Y-m-d') }}">
                            <div class="form-text">Pilih tanggal untuk sesi meeting online</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="meeting_time" class="form-label fw-semibold">
                                <i class="fas fa-clock me-2 text-primary"></i>Waktu Meeting
                            </label>
                            <input type="time" 
                                   name="meeting_time" 
                                   id="meeting_time"
                                   class="form-control form-control-lg" 
                                   required>
                            <div class="form-text">Tentukan jam mulai meeting</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-video me-2 text-primary"></i>Pilih Platform Meeting
                        </label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="meeting_platform" id="platform_gmeet" value="google_meet" checked>
                            <label class="form-check-label" for="platform_gmeet">
                                <i class="fab fa-google text-danger me-1"></i> Google Meet
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="meeting_platform" id="platform_zoom" value="zoom">
                            <label class="form-check-label" for="platform_zoom">
                                <i class="fas fa-video text-primary me-1"></i> Zoom Meeting
                            </label>
                        </div>
                    </div>

                    <!-- Google Meet Input -->
                    <div class="mb-4" id="google-meet-fields">
                        <label for="google_meet_link" class="form-label fw-semibold">
                            <i class="fab fa-google text-danger me-2"></i>Link Google Meet
                        </label>
                        <input type="url" 
                            name="meet_link" 
                            id="google_meet_link"
                            class="form-control form-control-lg" 
                            placeholder="https://meet.google.com/abc-defg-hij"
                            required>
                    </div>

                    <!-- Zoom Input -->
                    <div class="mb-4 d-none" id="zoom-fields">
                        <!-- Zoom Link -->
                        <div class="mb-3">
                            <label for="zoom_meet_link" class="form-label fw-semibold">
                                <i class="fas fa-link text-primary me-2"></i>Zoom Link
                            </label>
                            <input type="url" 
                                name="zoom_meet_link" 
                                id="zoom_meet_link" 
                                class="form-control form-control-lg" 
                                placeholder="https://zoom.us/j/1234567890">
                        </div>

                        <!-- Zoom Meeting ID -->
                        <div class="mb-3">
                            <label for="zoom_meeting_id" class="form-label fw-semibold">
                                <i class="fas fa-video text-primary me-2"></i>Zoom Meeting ID
                            </label>
                            <input type="text" 
                                name="zoom_meeting_id" 
                                id="zoom_meeting_id"
                                class="form-control form-control-lg" 
                                placeholder="123 4567 8901">
                        </div>

                        <!-- Zoom Passcode -->
                        <div class="mb-3">
                            <label for="zoom_passcode" class="form-label fw-semibold">
                                <i class="fas fa-lock text-primary me-2"></i>Zoom Passcode
                            </label>
                            <input type="text" 
                                name="zoom_passcode" 
                                id="zoom_passcode"
                                class="form-control form-control-lg" 
                                placeholder="abcd1234">
                        </div>
                    </div>

                    <!-- Hidden field untuk menyimpan link yang aktif -->
                    <input type="hidden" name="meet_link" id="active_meet_link">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body p-3">
                                    <h6 class="card-title">
                                        <i class="fas fa-user-check me-1"></i>Setelah Disetujui
                                    </h6>
                                    <ul class="list-unstyled mb-0 small">
                                        <li><i class="fas fa-check text-success me-1"></i> Status transaksi berubah menjadi "Completed"</li>
                                        <li><i class="fas fa-check text-success me-1"></i> Email notifikasi dikirim ke pengguna</li>
                                        <li><i class="fas fa-check text-success me-1"></i> Detail meeting disertakan dalam email</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body p-3">
                                    <h6 class="card-title">
                                        <i class="fas fa-calendar-alt me-1"></i>Jadwal Meeting
                                    </h6>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-calendar text-primary me-2"></i>
                                        <span id="preview-date" class="text-muted">Belum dipilih</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-clock text-primary me-2"></i>
                                        <span id="preview-time" class="text-muted">Belum dipilih</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-link text-primary me-2"></i>
                                        <span id="preview-link" class="text-muted">Belum diisi</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light p-3">
                    <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-success btn-lg px-4">
                        <i class="fas fa-check-circle me-2"></i>Setujui & Jadwalkan Meeting
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@foreach ($transactions as $transaction)
<!-- Modal Hapus Transaksi -->
    <div class="modal fade" id="deleteModal{{ $transaction->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $transaction->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel{{ $transaction->id }}">
                        <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus transaksi milik 
                    <strong>{{ optional($transaction->user)->name ?? 'User Tidak Ditemukan' }}</strong>? 
                    Tindakan ini tidak dapat dibatalkan.
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ route('admin.transaksi.destroy', $transaction->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt me-1"></i> Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tab functionality
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('tab');
            
            if (activeTab === 'installments') {
                // Switch to installments tab
                const installmentsTab = document.getElementById('installments-tab');
                const installmentsPane = document.getElementById('installments');
                const transactionsTab = document.getElementById('transactions-tab');
                const transactionsPane = document.getElementById('transactions');
                
                if (installmentsTab && installmentsPane) {
                    transactionsTab.classList.remove('active');
                    transactionsPane.classList.remove('show', 'active');
                    
                    installmentsTab.classList.add('active');
                    installmentsPane.classList.add('show', 'active');
                }
            }

            // Modal setup
            const modal = document.getElementById('approveModal');
            if (modal) {
                modal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const transactionId = button.getAttribute('data-id');
                    document.getElementById('approveTransactionId').value = transactionId;
                });
            }

            // CSRF Token for AJAX requests
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (csrfToken) {
                window.csrfToken = csrfToken.getAttribute('content');
            }

            // Form elements
            const meetingDate       = document.getElementById('meeting_date');
            const meetingTime       = document.getElementById('meeting_time');
            const googleMeetLink    = document.getElementById('google_meet_link');
            const zoomMeetLink      = document.getElementById('zoom_meet_link');
            const zoomMeetingId     = document.getElementById('zoom_meeting_id');
            const zoomPasscode      = document.getElementById('zoom_passcode');
            const activeMeetLink    = document.getElementById('active_meet_link');

            // Preview elements
            const previewDate       = document.getElementById('preview-date');
            const previewTime       = document.getElementById('preview-time');
            const previewLink       = document.getElementById('preview-link');

            // Field containers
            const googleFields      = document.getElementById('google-meet-fields');
            const zoomFields        = document.getElementById('zoom-fields');
            const platformRadios    = document.querySelectorAll('input[name="meeting_platform"]');

            // Update field sesuai platform
            function updateMeetingFields() {
                const selected = document.querySelector('input[name="meeting_platform"]:checked')?.value;
                if (!selected) return;

                if (selected === "google_meet") {
                    // Show Google Meet fields, hide Zoom fields
                    googleFields.classList.remove("d-none");
                    zoomFields.classList.add("d-none");

                    // Update required attributes
                    googleMeetLink.required = true;
                    zoomMeetLink.required = false;
                    zoomMeetingId.required = false;
                    zoomPasscode.required = false;

                    // Update hidden field with Google Meet link
                    activeMeetLink.value = googleMeetLink.value;

                    // Update preview
                    previewLink.textContent = googleMeetLink.value || "Belum diisi";
                } else if (selected === "zoom") {
                    // Show Zoom fields, hide Google Meet fields
                    googleFields.classList.add("d-none");
                    zoomFields.classList.remove("d-none");

                    // Update required attributes
                    googleMeetLink.required = false;
                    zoomMeetLink.required = true;
                    zoomMeetingId.required = true;
                    zoomPasscode.required = true;

                    // Update hidden field with Zoom link
                    activeMeetLink.value = zoomMeetLink.value;

                    // Update preview with Zoom info
                    let previewText = "";
                    if (zoomMeetingId.value) previewText += "ID: " + zoomMeetingId.value;
                    if (zoomPasscode.value) previewText += (previewText ? " | " : "") + "Passcode: " + zoomPasscode.value;
                    previewLink.textContent = previewText || "Belum diisi";
                }
            }

            // Event listeners for platform change
            platformRadios.forEach(radio => {
                radio.addEventListener("change", updateMeetingFields);
            });

            // Event listener for date change
            if (meetingDate) {
                meetingDate.addEventListener("change", function () {
                    previewDate.textContent = this.value 
                        ? new Date(this.value).toLocaleDateString('id-ID') 
                        : "Belum dipilih";
                });
            }

            // Event listener for time change
            if (meetingTime) {
                meetingTime.addEventListener("change", function () {
                    previewTime.textContent = this.value || "Belum dipilih";
                });
            }

            // Event listener for Google Meet link
            if (googleMeetLink) {
                googleMeetLink.addEventListener("input", function () {
                    if (document.querySelector('input[name="meeting_platform"]:checked')?.value === 'google_meet') {
                        activeMeetLink.value = this.value;
                        previewLink.textContent = this.value || "Belum diisi";
                    }
                });
            }

            // Event listeners for Zoom fields
            if (zoomMeetLink) {
                zoomMeetLink.addEventListener("input", function () {
                    if (document.querySelector('input[name="meeting_platform"]:checked')?.value === 'zoom') {
                        activeMeetLink.value = this.value;
                        updateMeetingFields();
                    }
                });
            }

            if (zoomMeetingId) {
                zoomMeetingId.addEventListener("input", updateMeetingFields);
            }

            if (zoomPasscode) {
                zoomPasscode.addEventListener("input", updateMeetingFields);
            }

            // Initialize default state
            updateMeetingFields();
        });

        function updateTransactionStatus(selectElement) {
            const transactionId = selectElement.getAttribute('data-transaction-id');
            const currentStatus = selectElement.getAttribute('data-current-status');
            const newStatus = selectElement.value;
            const spinner = document.getElementById('spinner-' + transactionId);
            
            // If status hasn't changed, do nothing
            if (currentStatus === newStatus) {
                return;
            }
            
            // Show confirmation dialog
            let actionText = '';
            switch(newStatus) {
                case 'Completed':
                    actionText = 'menyetujui';
                    break;
                case 'Failed':
                    actionText = 'menolak';
                    break;
                case 'Pending':
                    actionText = 'mengubah ke Pending';
                    break;
                case 'Verification':
                    actionText = 'mengubah ke Verifikasi';
                    break;
            }
            
            if (!confirm(`Apakah Anda yakin ingin ${actionText} transaksi ini?`)) {
                // Reset to original value
                selectElement.value = currentStatus;
                return;
            }
            
            // Show loading spinner
            if (spinner) {
                spinner.classList.remove('d-none');
            }
            selectElement.disabled = true;
            
            // Prepare form data
            const formData = new FormData();
            formData.append('_token', window.csrfToken);
            formData.append('status', newStatus);
            
            // Send AJAX request
            fetch(`/admin/transaksi/${transactionId}/updateStatus`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update current status attribute
                    selectElement.setAttribute('data-current-status', newStatus);
                    
                    // Show success message
                    showStatusMessage('success', data.message);
                    
                    // Update paid_at display if status is Completed
                    if (newStatus === 'Completed' && data.paid_at) {
                        updatePaidAtDisplay(transactionId, data.paid_at);
                    }
                    
                    // Update stats if needed
                    updateStatsCards();
                } else {
                    // Reset to original value
                    selectElement.value = currentStatus;
                    showStatusMessage('error', data.message || 'Gagal mengubah status transaksi');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Reset to original value
                selectElement.value = currentStatus;
                showStatusMessage('error', 'Terjadi kesalahan saat mengubah status transaksi');
            })
            .finally(() => {
                // Hide loading spinner
                if (spinner) {
                    spinner.classList.add('d-none');
                }
                selectElement.disabled = false;
            });
        }

        function showStatusMessage(type, message) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
            
            const alertHTML = `
                <div class="alert ${alertClass} alert-dismissible fade show status-message" role="alert">
                    <i class="fas ${iconClass} me-2"></i>
                    <strong>${type === 'success' ? 'Berhasil!' : 'Error!'}</strong> ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            
            const container = document.getElementById('statusMessages');
            if (container) {
                container.innerHTML = alertHTML;
                
                // Auto remove after 5 seconds
                setTimeout(() => {
                    const alert = container.querySelector('.alert');
                    if (alert) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                }, 5000);
            }
        }

        function updatePaidAtDisplay(transactionId, paidAt) {
            // Find the status cell for this transaction
            const statusCell = document.querySelector(`select[data-transaction-id="${transactionId}"]`)?.closest('td');
            
            if (!statusCell) return;
            
            // Check if paid_at display already exists
            let paidDisplay = statusCell.querySelector('.text-success.d-block');
            
            if (!paidDisplay) {
                // Create new paid_at display
                paidDisplay = document.createElement('small');
                paidDisplay.className = 'text-success d-block mt-1';
                statusCell.appendChild(paidDisplay);
            }
            
            // Format the date
            const date = new Date(paidAt);
            const formattedDate = date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: '2-digit', 
                year: 'numeric'
            }) + ' ' + date.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });
            
            paidDisplay.innerHTML = `<i class="fas fa-check-circle me-1"></i>Dibayar: ${formattedDate}`;
        }

        function updateStatsCards() {
            // This function could be enhanced to update the stats cards via AJAX
            // For now, we'll just reload the page after a short delay to show updated stats
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }

        // Auto-submit form functionality
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('#filterForm, #installmentFilterForm');
            
            forms.forEach(form => {
                const selects = form.querySelectorAll('select');
                
                selects.forEach(select => {
                    select.addEventListener('change', function() {
                        // Add loading state
                        this.style.opacity = '0.6';
                        this.disabled = true;
                        
                        // Submit form
                        form.submit();
                    });
                });
            });
        });

        // Enhanced search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInputs = document.querySelectorAll('#searchTransaction, #searchInstallment');
            
            searchInputs.forEach(searchInput => {
                let searchTimeout;
                
                if (searchInput) {
                    searchInput.addEventListener('input', function() {
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(() => {
                            if (this.value.length >= 3 || this.value.length === 0) {
                                const form = this.closest('form');
                                if (form) {
                                    form.submit();
                                }
                            }
                        }, 500); // 500ms delay
                    });
                }
            });
        });

        // Improved table responsiveness
        document.addEventListener('DOMContentLoaded', function() {
            const tables = document.querySelectorAll('#transactionsTable, #installmentsTable');
            
            tables.forEach(table => {
                if (table && window.innerWidth < 768) {
                    // Add mobile-specific classes or modifications
                    table.classList.add('table-sm');
                }
            });
        });

        // Loading state for buttons
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn && !submitBtn.disabled) {
                        submitBtn.disabled = true;
                        const originalText = submitBtn.innerHTML;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Memproses...';
                        
                        // Reset button after 5 seconds if form hasn't submitted
                        setTimeout(() => {
                            if (submitBtn.disabled) {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalText;
                            }
                        }, 5000);
                    }
                });
            });
        });

        // Tab switching with URL update
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('#transactionTabs button[data-bs-toggle="tab"]');
            
            tabButtons.forEach(button => {
                button.addEventListener('shown.bs.tab', function(event) {
                    const targetTab = event.target.getAttribute('data-bs-target');
                    const url = new URL(window.location);
                    
                    if (targetTab === '#installments') {
                        url.searchParams.set('tab', 'installments');
                    } else {
                        url.searchParams.delete('tab');
                    }
                    
                    // Update URL without page reload
                    window.history.pushState({}, '', url);
                });
            });
        });

        // SweetAlert Verifikasi Cicilan
        function confirmApprove(installmentId) {
            Swal.fire({
                title: 'Konfirmasi Terima Cicilan',
                text: "Apakah Anda yakin ingin menyetujui cicilan ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Setujui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Buat form dinamis untuk mengirim permintaan
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/installments/' + installmentId + '/verify';
                    form.style.display = 'none';
                    
                    // Tambahkan token CSRF
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    // Tambahkan input action
                    const actionInput = document.createElement('input');
                    actionInput.type = 'hidden';
                    actionInput.name = 'action';
                    actionInput.value = 'approve';
                    form.appendChild(actionInput);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function confirmReject(installmentId) {
            Swal.fire({
                title: 'Konfirmasi Tolak Cicilan',
                text: "Apakah Anda yakin ingin menolak cicilan ini? Status akan berubah menjadi Failed.",
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Tolak!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Buat form dinamis untuk mengirim permintaan
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/installments/' + installmentId + '/verify';
                    form.style.display = 'none';
                    
                    // Tambahkan token CSRF
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    // Tambahkan input action
                    const actionInput = document.createElement('input');
                    actionInput.type = 'hidden';
                    actionInput.name = 'action';
                    actionInput.value = 'reject';
                    form.appendChild(actionInput);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Fungsi pencarian
        function filterTransactions() {
            const searchValue = document.getElementById('searchTransaction').value.toLowerCase();
            const typeValue = document.getElementById('filterType').value.toLowerCase();
            const statusValue = document.getElementById('filterStatus').value.toLowerCase();

            const table = document.getElementById('transactionsTable'); // pastikan id tabel benar
            const rows = table.querySelectorAll('tbody tr');

            let visibleCount = 0;

            rows.forEach(row => {
                const nameCol   = row.querySelector('td:nth-child(2)')?.innerText.toLowerCase()
                const typeCol   = row.querySelector('td:nth-child(3)')?.innerText.toLowerCase() 
                const statusCol = row.querySelector('td:nth-child(5)')?.innerText.toLowerCase() 

                const matchesSearch = !searchValue || nameCol.includes(searchValue)
                const matchesType   = !typeValue || typeCol.includes(typeValue);
                const matchesStatus = !statusValue || statusCol.includes(statusValue);

                if (matchesSearch && matchesType && matchesStatus) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Tampilkan pesan jika tidak ada data
            const tbody = table.querySelector('tbody');
            let noDataRow = tbody.querySelector('.no-data-row');

            if (visibleCount === 0) {
                if (!noDataRow) {
                    const tr = document.createElement('tr');
                    tr.classList.add('no-data-row');
                    tr.innerHTML = `<td colspan="8" class="text-center py-4">Tidak ada transaksi ditemukan.</td>`;
                    tbody.appendChild(tr);
                }
            } else {
                if (noDataRow) noDataRow.remove();
            }
        }
    </script>
@endpush
