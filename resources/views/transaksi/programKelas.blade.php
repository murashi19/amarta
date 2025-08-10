@extends('layouts.dashboard')

@section('title', 'Pembayaran Program Kelas')

@section('content')
@push('styles')
<style>
    .info-item {
        padding: 0.5rem 0;
    }

    .progress-bar {
        background: linear-gradient(90deg, #28a745, #20c997);
    }

    .card {
        border: none;
        border-radius: 12px;
    }

    .card-header {
        border-radius: 12px 12px 0 0 !important;
        font-weight: 600;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
    }

    .form-control, .form-select {
        border-radius: 8px;
    }

    .table th {
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
    }

    .quick-amount:hover {
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }

    @media (max-width: 768px) {
        .container {
            padding: 1rem;
        }
        
        .h4 {
            font-size: 1.1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('users.keuangan') }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <div>
                    <h2 class="mb-1">Program Kelas</h2>
                    <small class="text-muted">ID Transaksi: #{{ $trx->id }}</small>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <!-- Info Pembayaran -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Informasi Pembayaran</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="form-label text-muted">Total Biaya Program</label>
                                        <div class="h4 text-primary">Rp {{ number_format($trx->amount, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="form-label text-muted">Total Dibayar</label>
                                        <div class="h4 text-success">Rp {{ number_format($totalPaid, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="form-label text-muted">Sisa Pembayaran</label>
                                        <div class="h4 text-warning">Rp {{ number_format($trx->amount - $totalPaid, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="form-label text-muted">Status</label>
                                        <div>
                                            @if($trx->status === 'Completed')
                                                <span class="badge bg-success fs-6">
                                                    <i class="fas fa-check-circle me-1"></i>Lunas
                                                </span>
                                            @elseif($trx->status === 'Pending')
                                                <span class="badge bg-warning fs-6">
                                                    <i class="fas fa-clock me-1"></i>Belum Lunas
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mt-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Progres Pembayaran</span>
                                    <span class="fw-bold">{{ round(($totalPaid / $trx->amount) * 100, 1) }}%</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-gradient" 
                                         role="progressbar" 
                                         style="width: {{ ($totalPaid / $trx->amount) * 100 }}%"
                                         aria-valuenow="{{ ($totalPaid / $trx->amount) * 100 }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                    </div>
                                </div>
                            </div>

                            @if($trx->expires_at && $trx->status !== 'Completed')
                                <div class="alert alert-info mt-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Batas Waktu:</strong> {{ \Carbon\Carbon::parse($trx->expires_at)->format('d M Y H:i') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Form Pembayaran Cicilan -->
                <div class="col-lg-4 mb-4">
                    @if($trx->status !== 'Completed')
                        <div class="card shadow-sm">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Bayar Cicilan</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('transaksi.programKelas.storeInstallment', $trx->id) }}" method="POST" id="cicilanForm">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="amount" class="form-label">Jumlah Pembayaran <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" 
                                                   class="form-control @error('amount') is-invalid @enderror" 
                                                   id="amount" 
                                                   name="amount" 
                                                   min="100000"
                                                   max="{{ $trx->amount - $totalPaid }}"
                                                   value="{{ old('amount') }}"
                                                   placeholder="Minimal 100.000">
                                            @error('amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <small class="text-muted">Minimal pembayaran Rp 100.000</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="payment_method" class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                                        <select class="form-select @error('payment_method') is-invalid @enderror" 
                                                id="payment_method" 
                                                name="payment_method">
                                            <option value="">Pilih metode pembayaran</option>
                                            <option value="transfer_bank" {{ old('payment_method') === 'transfer_bank' ? 'selected' : '' }}>Transfer Bank</option>
                                            <option value="ewallet" {{ old('payment_method') === 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                                            <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>Tunai</option>
                                        </select>
                                        @error('payment_method')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Quick Amount Buttons -->
                                    <div class="mb-3">
                                        <small class="text-muted d-block mb-2">Pilih Cepat:</small>
                                        <div class="d-grid gap-2">
                                            @php
                                                $remaining = $trx->amount - $totalPaid;
                                                $quickAmounts = [500000, 1000000, 2000000];
                                            @endphp
                                            @foreach($quickAmounts as $amount)
                                                @if($amount <= $remaining)
                                                    <button type="button" 
                                                            class="btn btn-outline-primary btn-sm quick-amount" 
                                                            data-amount="{{ $amount }}">
                                                        Rp {{ number_format($amount, 0, ',', '.') }}
                                                    </button>
                                                @endif
                                            @endforeach
                                            @if($remaining > 0)
                                                <button type="button" 
                                                        class="btn btn-outline-success btn-sm quick-amount" 
                                                        data-amount="{{ $remaining }}">
                                                    Lunas (Rp {{ number_format($remaining, 0, ',', '.') }})
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-paper-plane me-2"></i>Bayar Sekarang
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="card shadow-sm border-success">
                            <div class="card-body text-center">
                                <div class="text-success mb-3">
                                    <i class="fas fa-check-circle fa-4x"></i>
                                </div>
                                <h4 class="text-success">Pembayaran Lunas!</h4>
                                <p class="text-muted">Program kelas Anda sudah aktif dan siap digunakan.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Riwayat Pembayaran -->
            @if($installments->count() > 0)
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jumlah</th>
                                        <th>Metode</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($installments as $installment)
                                        <tr>
                                            <td>
                                                <div>{{ \Carbon\Carbon::parse($installment->paid_at)->format('d M Y') }}</div>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($installment->paid_at)->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-primary">
                                                    Rp {{ number_format($installment->amount, 0, ',', '.') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ ucfirst(str_replace('_', ' ', $installment->payment_method)) }}</span>
                                            </td>
                                            <td>
                                                @if($installment->status === 'Completed')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check me-1"></i>Berhasil
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-clock me-1"></i>Pending
                                                    </span>
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
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quick amount buttons
        const quickAmountButtons = document.querySelectorAll('.quick-amount');
        const amountInput = document.getElementById('amount');
        
        quickAmountButtons.forEach(button => {
            button.addEventListener('click', function() {
                const amount = this.dataset.amount;
                amountInput.value = amount;
                
                // Remove active class from all buttons
                quickAmountButtons.forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');
            });
        });
        
        // Format number input
        if (amountInput) {
            amountInput.addEventListener('input', function() {
                // Remove active class from quick buttons when user types
                quickAmountButtons.forEach(btn => btn.classList.remove('active'));
            });
        }
        
        // Form validation
        const form = document.getElementById('cicilanForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                const amount = document.getElementById('amount').value;
                const paymentMethod = document.getElementById('payment_method').value;
                
                if (!amount || !paymentMethod) {
                    e.preventDefault();
                    alert('Harap lengkapi semua field yang diperlukan!');
                    return false;
                }
                
                if (parseInt(amount) < 100000) {
                    e.preventDefault();
                    alert('Jumlah pembayaran minimal Rp 100.000!');
                    return false;
                }
                
                // Confirmation
                const confirmed = confirm(`Apakah Anda yakin ingin melakukan pembayaran sebesar Rp ${parseInt(amount).toLocaleString('id-ID')}?`);
                if (!confirmed) {
                    e.preventDefault();
                    return false;
                }
            });
        }
    });

    document.addEventListener("DOMContentLoaded", function () {
        let targetValue = {{ ($totalPaid / $trx->amount) * 100 }};
        let progressBar = document.getElementById("progress-bar");
        let progressText = document.getElementById("progress-text");
        let currentValue = 0;

        let animation = setInterval(function () {
            if (currentValue >= targetValue) {
                clearInterval(animation);
            } else {
                currentValue += 1;
                progressBar.style.width = currentValue + "%";
                progressBar.setAttribute("aria-valuenow", currentValue);
                progressText.textContent = currentValue.toFixed(1) + "%";
            }
        }, 20); // kecepatan animasi
    });
</script>
@endpush