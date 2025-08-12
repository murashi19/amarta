@extends('layouts.dashboardAdmin')

@section('title', 'Detail Transaksi')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb & Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.transaksi') }}" class="text-decoration-none text-primary">
                            <i class="fas fa-credit-card me-1"></i> Manajemen Transaksi
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-dark fw-semibold">Detail Transaksi #{{ $transaction->id }}</li>
                </ol>
            </nav>
            <h2 class="mb-0 text-dark">
                <i class="fas fa-file-invoice-dollar me-2 text-primary"></i>
                Detail Transaksi
            </h2>
            <p class="text-muted mb-0">Informasi lengkap transaksi sistem LPK</p>
        </div>
        <div>
            <a href="{{ route('admin.transaksi') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Transaction Overview Cards -->
    <div class="row mb-4 g-3">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                        <i class="fas fa-hashtag"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark">ID Transaksi</div>
                        <div class="text-muted">#{{ $transaction->id }}</div>
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
                        <div class="fw-bold text-dark">Jumlah</div>
                        <div class="text-success fw-bold">
                            Rp {{ number_format($transaction->amount ?? 0, 0, ',', '.') }}
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
                            @if($transaction->status == 'completed')
                                <span class="badge bg-success">{{ $transaction->status_name ?? 'Selesai' }}</span>
                            @elseif($transaction->status == 'pending')
                                <span class="badge bg-warning text-dark">{{ $transaction->status_name ?? 'Pending' }}</span>
                            @else
                                <span class="badge bg-danger">{{ $transaction->status_name ?? 'Gagal' }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                        <i class="fas fa-tag"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark">Tipe</div>
                        <div class="text-muted">
                            {{ $transaction->type_name ?? ucfirst($transaction->type) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Transaction Information -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0 text-dark fw-semibold">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        Informasi Transaksi
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr class="border-bottom">
                                    <td class="py-3 px-4 fw-semibold text-muted" style="min-width: 140px;">Tipe Transaksi</td>
                                    <td class="py-3 px-4">
                                        @if($transaction->type == 'booking')
                                            <span class="badge bg-primary px-3 py-2">
                                                <i class="fas fa-tag me-1"></i>
                                                {{ $transaction->type_name ?? 'Booking' }}
                                            </span>
                                        @else
                                            <span class="badge bg-info px-3 py-2">
                                                <i class="fas fa-tag me-1"></i>
                                                {{ $transaction->type_name ?? 'DP' }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="py-3 px-4 fw-semibold text-muted">Jumlah Pembayaran</td>
                                    <td class="py-3 px-4">
                                        <span class="fs-4 fw-bold text-success">
                                            Rp {{ number_format($transaction->amount ?? 0, 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="py-3 px-4 fw-semibold text-muted">Tanggal Dibuat</td>
                                    <td class="py-3 px-4">
                                        <div>
                                            <i class="fas fa-calendar-plus me-2 text-primary"></i>
                                            <span class="fw-medium">{{ $transaction->created_at->format('d F Y, H:i:s') }}</span>
                                        </div>
                                        <small class="text-muted">{{ $transaction->created_at->diffForHumans() }}</small>
                                    </td>
                                </tr>
                                @if($transaction->paid_at)
                                <tr class="border-bottom">
                                    <td class="py-3 px-4 fw-semibold text-muted">Tanggal Dibayar</td>
                                    <td class="py-3 px-4">
                                        <div>
                                            <i class="fas fa-check-circle me-2 text-success"></i>
                                            <span class="fw-medium">{{ $transaction->paid_at->format('d F Y, H:i:s') }}</span>
                                        </div>
                                        <small class="text-muted">{{ $transaction->paid_at->diffForHumans() }}</small>
                                    </td>
                                </tr>
                                @endif
                                @if($transaction->updated_at && $transaction->updated_at != $transaction->created_at)
                                <tr>
                                    <td class="py-3 px-4 fw-semibold text-muted">Terakhir Diupdate</td>
                                    <td class="py-3 px-4">
                                        <div>
                                            <i class="fas fa-edit me-2 text-info"></i>
                                            <span class="fw-medium">{{ $transaction->updated_at->format('d F Y, H:i:s') }}</span>
                                        </div>
                                        <small class="text-muted">{{ $transaction->updated_at->diffForHumans() }}</small>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Payment Proof -->
            @php
            $proof = $transaction->feePayments->last()?->photo;
        @endphp

        @if($proof)
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
                            src="{{ asset('storage/' . $proof) }}" 
                            alt="Bukti Pembayaran" 
                            class="proof-image rounded shadow"
                            onclick="window.open('{{ asset('storage/' . $proof) }}', '_blank')"
                        >
                    </div>
                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <a href="{{ asset('storage/' . $proof) }}" target="_blank" class="btn btn-outline-primary">
                            <i class="fas fa-external-link-alt me-1"></i> Buka di Tab Baru
                        </a>
                        <a href="{{ asset('storage/' . $proof) }}" download class="btn btn-success">
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
                    <p class="text-muted mb-0">Belum ada bukti pembayaran yang diupload untuk transaksi ini.</p>
                </div>
            </div>
        @endif
        </div>

        <!-- User Information -->
        <div class="col-lg-4">
            <!-- User Profile Card -->
            <div class="card border-0 shadow-sm mb-4 bg-white">
                <div class="card-body text-center py-4 text-white">
                    @if($transaction->user->photo)
                        <img src="{{ asset('storage/' . $transaction->user->photo) }}" 
                             alt="Foto Pengguna" 
                             class="rounded-circle mb-3 border border-3 border-white shadow" 
                             style="width: 80px; height: 80px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-primary bg-opacity-75 d-flex align-items-center justify-content-center mx-auto mb-3 fw-bold text-white" 
                             style="width: 80px; height: 80px; font-size: 1.5rem;">
                            {{ strtoupper(substr($transaction->user->name ?? 'U', 0, 2)) }}
                        </div>
                    @endif
                    <h5 class="mb-1 text-black">{{ $transaction->user->name ?? 'N/A' }}</h5>
                    <p class="mb-3 text-black">{{ $transaction->user->email ?? 'N/A' }}</p>
                    @if($transaction->user->status)
                        <span class="badge bg-primary bg-opacity-75 text-white">
                            <i class="fas fa-user-tag me-1"></i>
                            {{ $transaction->user->status->name }}
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
                                    <td class="py-3 px-4 text-dark fw-medium">{{ $transaction->user->name ?? 'N/A' }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="py-3 px-4 fw-semibold text-muted">Email</td>
                                    <td class="py-3 px-4">
                                        @if($transaction->user->email)
                                            <a href="mailto:{{ $transaction->user->email }}" class="text-decoration-none text-primary">
                                                {{ $transaction->user->email }}
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="py-3 px-4 fw-semibold text-muted">No. Telepon</td>
                                    <td class="py-3 px-4">
                                        @if($transaction->user->phone_number)
                                            <a href="tel:{{ $transaction->user->phone_number }}" class="text-decoration-none text-primary">
                                                {{ $transaction->user->phone_number }}
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
                                            <span class="fw-medium">{{ $transaction->user->created_at->format('d F Y') }}</span>
                                        </div>
                                        <small class="text-muted">{{ $transaction->user->created_at->diffForHumans() }}</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Transaction Timeline -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3">
                    <h6 class="mb-0 text-dark fw-semibold">
                        <i class="fas fa-history me-2 text-primary"></i>
                        Timeline Transaksi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="position-relative ps-4 mb-3 timeline-item">
                        <div class="fw-bold text-dark">Transaksi Dibuat</div>
                        <small class="text-muted">{{ $transaction->created_at->format('d F Y, H:i') }}</small>
                    </div>
                    @if($transaction->paid_at)
                    <div class="position-relative ps-4 mb-3 timeline-item">
                        <div class="fw-bold text-success">Pembayaran Diterima</div>
                        <small class="text-muted">{{ $transaction->paid_at->format('d F Y, H:i') }}</small>
                    </div>
                    @endif
                    @if($transaction->status == 'completed')
                    <div class="position-relative ps-4 timeline-item">
                        <div class="fw-bold text-success">Transaksi Selesai</div>
                        <small class="text-muted">{{ $transaction->updated_at->format('d F Y, H:i') }}</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    @if($transaction->status == 'pending')
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body bg-light">
            <h6 class="mb-3 text-dark fw-semibold">
                <i class="fas fa-cogs me-2"></i>
                Aksi Transaksi
            </h6>
            <div class="d-flex flex-wrap gap-2">
                <form method="POST" action="{{ route('admin.transaksi.verify', $transaction->id) }}" class="d-inline"
                      onsubmit="return confirm('Apakah Anda yakin ingin menyetujui transaksi ini?')">
                    @csrf
                    <input type="hidden" name="action" value="approve">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-1"></i> Setujui Transaksi
                    </button>
                </form>
                
                <form method="POST" action="{{ route('admin.transaksi.verify', $transaction->id) }}" class="d-inline"
                      onsubmit="return confirm('Apakah Anda yakin ingin menolak transaksi ini?')">
                    @csrf
                    <input type="hidden" name="action" value="reject">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-1"></i> Tolak Transaksi
                    </button>
                </form>
            </div>
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
            max-height: 300px; /* batasi tinggi */
            max-width: 100%;   /* supaya tidak melebihi lebar container */
            width: auto;
            height: auto;
            object-fit: contain; /* jaga proporsi */
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
    </style>
@endpush
@push('scripts')
    <script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            console.log('Copied to clipboard');
        });
    }
    </script>
@endpush
@endsection
