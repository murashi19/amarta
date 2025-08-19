@extends('layouts.dashboardAdmin')

@section('title', 'Detail Transaksi Cicilan')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb & Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.installments.detail', $installment->id) }}" class="text-decoration-none text-primary">
                            <i class="fas fa-credit-card me-1"></i> Manajemen Cicilan
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-dark fw-semibold">Detail Cicilan #{{ $installment->id }}</li>
                </ol>
            </nav>
            <h2 class="mb-0 text-dark">
                <i class="fas fa-file-invoice-dollar me-2 text-primary"></i>
                Detail Transaksi Cicilan
            </h2>
            <p class="text-muted mb-0">Informasi lengkap pembayaran cicilan sistem LPK</p>
        </div>
        <div>
            <a href="{{ route('admin.transaksi') }}?tab=installments" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Installment Overview Cards -->
    <div class="row mb-4 g-3">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                        <i class="fas fa-hashtag"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark">ID Pembayaran</div>
                        <div class="text-muted">#{{ $installment->id }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark">Jumlah Cicilan</div>
                        <div class="text-success fw-bold">
                            Rp {{ number_format($installment->amount, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark">Status</div>
                        <div>
                            @switch($installment->status)
                                @case('Completed')
                                    <span class="badge bg-success">Selesai</span>
                                    @break
                                @case('Pending')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                    @break
                                @case('Verification')
                                    <span class="badge bg-info">Verifikasi</span>
                                    @break
                                @case('Failed')
                                    <span class="badge bg-danger">Gagal</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">{{ $installment->status }}</span>
                            @endswitch
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark">ID Transaksi</div>
                        <div class="text-muted">
                            #{{ $installment->transaction->id }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Payment Information -->
        <div class="col-lg-8">
            <!-- Main Payment Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0 text-dark fw-semibold">
                        <i class="fas fa-credit-card me-2 text-primary"></i>
                        Informasi Pembayaran Cicilan
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr class="border-bottom">
                                    <td class="py-3 px-4 fw-semibold text-muted" style="min-width: 140px;">Jumlah Pembayaran</td>
                                    <td class="py-3 px-4">
                                        <span class="fs-4 fw-bold text-success">
                                            Rp {{ number_format($installment->amount, 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="py-3 px-4 fw-semibold text-muted">Metode Pembayaran</td>
                                    <td class="py-3 px-4">
                                        @if($installment->payment_method == 'transfer_bank')
                                            <span class="badge bg-primary px-3 py-2">
                                                <i class="fas fa-university me-1"></i>
                                                Transfer Bank
                                                @if($installment->selected_method)
                                                    ({{ strtoupper($installment->selected_method) }})
                                                @endif
                                            </span>
                                        @elseif($installment->payment_method == 'ewallet')
                                            <span class="badge bg-info px-3 py-2">
                                                <i class="fas fa-mobile-alt me-1"></i>
                                                E-Wallet
                                            </span>
                                        @else
                                            <span class="badge bg-secondary px-3 py-2">
                                                {{ ucfirst($installment->payment_method) }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @if($installment->installment_number)
                                <tr class="border-bottom">
                                    <td class="py-3 px-4 fw-semibold text-muted">Cicilan Ke</td>
                                    <td class="py-3 px-4">
                                        <span class="badge bg-warning text-dark px-3 py-2">
                                            <i class="fas fa-list-ol me-1"></i>
                                            {{ $installment->installment_number }}
                                        </span>
                                    </td>
                                </tr>
                                @endif
                                @if($installment->reference_number)
                                <tr class="border-bottom">
                                    <td class="py-3 px-4 fw-semibold text-muted">No. Referensi</td>
                                    <td class="py-3 px-4">
                                        <code class="bg-light p-2 rounded">{{ $installment->reference_number }}</code>
                                    </td>
                                </tr>
                                @endif
                                <tr class="border-bottom">
                                    <td class="py-3 px-4 fw-semibold text-muted">Tanggal Dibuat</td>
                                    <td class="py-3 px-4">
                                        <div>
                                            <i class="fas fa-calendar-plus me-2 text-primary"></i>
                                            <span class="fw-medium">{{ \Carbon\Carbon::parse($installment->created_at)->format('d F Y, H:i:s') }}</span>
                                        </div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($installment->created_at)->diffForHumans() }}</small>
                                    </td>
                                </tr>
                                @if($installment->paid_at)
                                <tr class="border-bottom">
                                    <td class="py-3 px-4 fw-semibold text-muted">Tanggal Dibayar</td>
                                    <td class="py-3 px-4">
                                        <div>
                                            <i class="fas fa-check-circle me-2 text-success"></i>
                                            <span class="fw-medium">{{ \Carbon\Carbon::parse($installment->paid_at)->format('d F Y, H:i:s') }}</span>
                                        </div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($installment->paid_at)->diffForHumans() }}</small>
                                    </td>
                                </tr>
                                @endif
                                @if($installment->expires_at)
                                <tr>
                                    <td class="py-3 px-4 fw-semibold text-muted">Kadaluwarsa</td>
                                    <td class="py-3 px-4">
                                        <div>
                                            <i class="fas fa-hourglass-end me-2 text-warning"></i>
                                            <span class="fw-medium">{{ \Carbon\Carbon::parse($installment->expires_at)->format('d F Y, H:i:s') }}</span>
                                        </div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($installment->expires_at)->diffForHumans() }}</small>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Transaction Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0 text-dark fw-semibold">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        Informasi Transaksi Utama
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr class="border-bottom">
                                    <td class="py-3 px-4 fw-semibold text-muted" style="min-width: 140px;">ID Transaksi</td>
                                    <td class="py-3 px-4">
                                        <span class="fw-bold text-dark">#{{ $installment->transaction->id }}</span>
                                    </td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="py-3 px-4 fw-semibold text-muted">Tipe Transaksi</td>
                                    <td class="py-3 px-4">
                                        <span class="badge bg-info px-3 py-2">
                                            <i class="fas fa-tag me-1"></i>
                                            {{ ucfirst($installment->transaction->type) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="py-3 px-4 fw-semibold text-muted">Total Transaksi</td>
                                    <td class="py-3 px-4">
                                        <span class="fs-5 fw-bold text-primary">
                                            Rp {{ number_format($installment->transaction->amount, 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-4 fw-semibold text-muted">Status Transaksi</td>
                                    <td class="py-3 px-4">
                                        @switch($installment->transaction->status)
                                            @case('Completed')
                                                <span class="badge bg-success px-3 py-2">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    Selesai
                                                </span>
                                                @break
                                            @case('Pending')
                                                <span class="badge bg-warning text-dark px-3 py-2">
                                                    <i class="fas fa-clock me-1"></i>
                                                    Menunggu
                                                </span>
                                                @break
                                            @case('Verification')
                                                <span class="badge bg-info px-3 py-2">
                                                    <i class="fas fa-search me-1"></i>
                                                    Verifikasi
                                                </span>
                                                @break
                                            @case('Failed')
                                                <span class="badge bg-danger px-3 py-2">
                                                    <i class="fas fa-times-circle me-1"></i>
                                                    Gagal
                                                </span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary px-3 py-2">{{ $installment->transaction->status }}</span>
                                        @endswitch
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Payment Proof -->
            @if($installment->photo)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0 text-dark fw-semibold">
                        <i class="fas fa-receipt me-2 text-success"></i>
                        Bukti Pembayaran
                    </h5>
                </div>
                <div class="card-body text-center py-4">
                    <div class="mb-4">
                        <img 
                            src="{{ asset('storage/' . $installment->photo) }}" 
                            alt="Bukti Pembayaran" 
                            class="proof-image rounded shadow"
                            onclick="window.open('{{ asset('storage/' . $installment->photo) }}', '_blank')"
                        >
                    </div>
                    <div class="d-flex justify-content-center flex-wrap">
                        <a href="{{ asset('storage/' . $installment->photo) }}" target="_blank" class="btn btn-outline-primary me-2 mb-2">
                            <i class="fas fa-external-link-alt me-1"></i> Buka di Tab Baru
                        </a>
                        <a href="{{ asset('storage/' . $installment->photo) }}" download class="btn btn-success mb-2">
                            <i class="fas fa-download me-1"></i> Download
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-image fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Bukti Pembayaran Tidak Tersedia</h5>
                    <p class="text-muted mb-0">Belum ada bukti pembayaran yang diupload untuk cicilan ini.</p>
                </div>
            </div>
            @endif

            <!-- Notes Section -->
            @if($installment->notes || $installment->admin_notes)
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0 text-dark fw-semibold">
                        <i class="fas fa-sticky-note me-2 text-warning"></i>
                        Catatan
                    </h5>
                </div>
                <div class="card-body">
                    @if($installment->notes)
                    <div class="mb-3">
                        <h6 class="fw-bold text-dark mb-2">
                            <i class="fas fa-user me-1 text-primary"></i>
                            Catatan Pengguna:
                        </h6>
                        <div class="bg-light p-3 rounded">
                            {{ $installment->notes }}
                        </div>
                    </div>
                    @endif
                    
                    @if($installment->admin_notes)
                    <div class="mb-0">
                        <h6 class="fw-bold text-dark mb-2">
                            <i class="fas fa-user-shield me-1 text-warning"></i>
                            Catatan Admin:
                        </h6>
                        <div class="bg-warning bg-opacity-25 p-3 rounded">
                            {{ $installment->admin_notes }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- User Information -->
        <div class="col-lg-4">
            <!-- User Profile Card -->
            <div class="card border-0 shadow-sm mb-4 bg-white">
                <div class="card-body text-center py-4">
                    @if($installment->transaction->user->photo)
                        <img src="{{ asset('storage/' . $installment->transaction->user->photo) }}" 
                             alt="Foto Pengguna" 
                             class="rounded-circle mb-3 border border-3 border-white shadow" 
                             style="width: 80px; height: 80px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-primary bg-opacity-75 d-flex align-items-center justify-content-center mx-auto mb-3 fw-bold text-white" 
                             style="width: 80px; height: 80px; font-size: 1.5rem;">
                            {{ strtoupper(substr($installment->transaction->user->name ?? 'U', 0, 2)) }}
                        </div>
                    @endif
                    <h5 class="mb-1 text-dark">{{ $installment->transaction->user->name ?? 'N/A' }}</h5>
                    <p class="mb-3 text-muted">{{ $installment->transaction->user->email ?? 'N/A' }}</p>
                    @if($installment->transaction->user->status)
                        <span class="badge bg-primary">
                            <i class="fas fa-user-tag me-1"></i>
                            {{ $installment->transaction->user->status->name }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- User Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-0 py-3">
                    <h6 class="mb-0 text-dark fw-semibold">
                        <i class="fas fa-user-circle me-2 text-primary"></i>
                        Detail Pengguna
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr class="border-bottom">
                                    <td class="py-3 px-4 fw-semibold text-muted">Nama Lengkap</td>
                                    <td class="py-3 px-4 text-dark fw-medium">{{ $installment->transaction->user->name ?? 'N/A' }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="py-3 px-4 fw-semibold text-muted">Email</td>
                                    <td class="py-3 px-4">
                                        @if($installment->transaction->user->email)
                                            <a href="mailto:{{ $installment->transaction->user->email }}" class="text-decoration-none text-primary">
                                                {{ $installment->transaction->user->email }}
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="py-3 px-4 fw-semibold text-muted">No. Telepon</td>
                                    <td class="py-3 px-4">
                                        @if($installment->transaction->user->phone_number)
                                            <a href="tel:{{ $installment->transaction->user->phone_number }}" class="text-decoration-none text-primary">
                                                {{ $installment->transaction->user->phone_number }}
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-4 fw-semibold text-muted">Tanggal Daftar</td>
                                    <td class="py-3 px-4">
                                        <div>
                                            <i class="fas fa-calendar me-2 text-muted"></i>
                                            <span class="fw-medium">{{ \Carbon\Carbon::parse($installment->transaction->user->created_at)->format('d F Y') }}</span>
                                        </div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($installment->transaction->user->created_at)->diffForHumans() }}</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Payment Timeline -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-0 py-3">
                    <h6 class="mb-0 text-dark fw-semibold">
                        <i class="fas fa-history me-2 text-primary"></i>
                        Timeline Pembayaran
                    </h6>
                </div>
                <div class="card-body">
                    <div class="position-relative ps-4 mb-3 timeline-item">
                        <div class="fw-bold text-dark">Pembayaran Dibuat</div>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($installment->created_at)->format('d F Y, H:i') }}</small>
                    </div>
                    @if($installment->paid_at)
                    <div class="position-relative ps-4 mb-3 timeline-item">
                        <div class="fw-bold text-success">Pembayaran Diterima</div>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($installment->paid_at)->format('d F Y, H:i') }}</small>
                    </div>
                    @endif
                    @if($installment->verified_at)
                    <div class="position-relative ps-4 mb-3 timeline-item">
                        <div class="fw-bold text-info">Diverifikasi</div>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($installment->verified_at)->format('d F Y, H:i') }}</small>
                    </div>
                    @endif
                    @if($installment->status == 'Completed')
                    <div class="position-relative ps-4 timeline-item">
                        <div class="fw-bold text-success">Pembayaran Selesai</div>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($installment->updated_at)->format('d F Y, H:i') }}</small>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Verification Info -->
            @if($installment->verified_by || $installment->verified_at)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3">
                    <h6 class="mb-0 text-dark fw-semibold">
                        <i class="fas fa-check-double me-2 text-success"></i>
                        Informasi Verifikasi
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            @if($installment->verified_by)
                            <tr class="border-bottom">
                                <td class="py-3 px-4 fw-semibold text-muted">Diverifikasi oleh</td>
                                <td class="py-3 px-4 text-dark fw-medium">Admin ID #{{ $installment->verified_by }}</td>
                            </tr>
                            @endif
                            @if($installment->verified_at)
                            <tr>
                                <td class="py-3 px-4 fw-semibold text-muted">Tanggal Verifikasi</td>
                                <td class="py-3 px-4">
                                    <div>
                                        <i class="fas fa-calendar-check me-2 text-success"></i>
                                        <span class="fw-medium">{{ \Carbon\Carbon::parse($installment->verified_at)->format('d F Y, H:i:s') }}</span>
                                    </div>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($installment->verified_at)->diffForHumans() }}</small>
                                </td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    @if($installment->status == 'Verification')
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body bg-light">
            <h6 class="mb-3 text-dark fw-semibold">
                <i class="fas fa-cogs me-2"></i>
                Aksi Verifikasi
            </h6>
            <form id="verificationForm" method="POST" action="{{ route('admin.verify-payment', $installment->id) }}">
                @csrf
                <div class="mb-3">
                    <label for="admin_notes" class="form-label fw-semibold">Catatan Admin (Opsional)</label>
                    <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3" placeholder="Tambahkan catatan verifikasi...">{{ $installment->admin_notes }}</textarea>
                </div>
                <div class="d-flex flex-wrap">
                    <button type="button" class="btn btn-success me-3 mb-2" onclick="verifyPayment('approve')">
                        <i class="fas fa-check me-1"></i> Setujui Pembayaran
                    </button>
                    <button type="button" class="btn btn-danger mb-2" onclick="verifyPayment('reject')">
                        <i class="fas fa-times me-1"></i> Tolak Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
    .section-title::before {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 50px;
        height: 2px;
        background: #3b82f6;
    }
    
    .proof-image {
        cursor: pointer;
        transition: transform 0.3s ease;
        max-height: 300px;
        max-width: 100%;
        width: auto;
        height: auto;
        object-fit: contain;
    }

    .proof-image:hover {
        transform: scale(1.02);
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: 0.5rem;
        top: 0.5rem;
        width: 0.75rem;
        height: 0.75rem;
        background: #3b82f6;
        border-radius: 50%;
        border: 2px solid #ffffff;
        box-shadow: 0 0 0 2px #3b82f6;
    }

    .timeline-item::after {
        content: '';
        position: absolute;
        left: 0.8125rem;
        top: 1.25rem;
        width: 2px;
        height: calc(100% + 0.5rem);
        background: #e2e8f0;
    }

    .timeline-item:last-child::after {
        display: none;
    }

    code {
        background-color: #f8f9fa;
        padding: 0.4rem 0.6rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
    }
</style>
@endpush

@push('scripts')
<script>
function verifyPayment(action) {
    const form = document.getElementById('verificationForm');
    
    if (action === 'approve') {
        if (confirm('Apakah Anda yakin ingin menyetujui pembayaran ini?')) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'action';
            input.value = 'approve';
            form.appendChild(input);
            form.submit();
        }
    } else if (action === 'reject') {
        if (confirm('Apakah Anda yakin ingin menolak pembayaran ini?')) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'action';
            input.value = 'reject';
            form.appendChild(input);
            form.submit();
        }
    }
}

// Toast notification jika ada session message
@if(session('success'))
    toastr.success('{{ session('success') }}');
@endif

@if(session('error'))
    toastr.error('{{ session('error') }}');
@endif
</script>
@endpush
@endsection