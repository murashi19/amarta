@extends('layouts.dashboard')

@section('title', 'Pembayaran Program Kelas')



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
                                        style="width: 0%" 
                                        aria-valuenow="0" 
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
                                <form id="cicilanForm">
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
                                                placeholder="Minimal 400.000">
                                            @error('amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <small class="text-muted">Minimal pembayaran Rp 400.000</small>
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

                                    <!-- Quick Payment -->
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
                                        <button type="button" class="btn btn-success" id="processPaymentBtn">
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
                                        <th>Referensi</th>
                                        <th>Jumlah</th>
                                        <th>Metode</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($installments as $installment)
                                        <tr>
                                            <td>
                                                <div>{{ $installment->paid_at->format('d M Y') }}</div>
                                                <small class="text-muted">{{ $installment->paid_at->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <small class="text-primary fw-bold">{{ $installment->reference_number }}</small>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-primary">
                                                    {{ $installment->formatted_amount }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $installment->payment_method_name }}</span>
                                                @if($installment->selected_method_name)
                                                    <br><small class="text-muted">{{ $installment->selected_method_name }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $installment->status_badge_color }}">
                                                    <i class="{{ $installment->status_icon }} me-1"></i>
                                                    @if($installment->status === 'Completed')
                                                        Berhasil
                                                    @elseif($installment->status === 'Verification')
                                                        Verifikasi
                                                    @elseif($installment->status === 'Failed')
                                                        Ditolak
                                                    @else
                                                        {{ $installment->status }}
                                                    @endif
                                                </span>
                                                @if($installment->is_expired && $installment->status === 'Verification')
                                                    <br><small class="text-danger">Expired</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($installment->proof_url)
                                                    <a href="{{ $installment->proof_url }}" 
                                                    target="_blank" 
                                                    class="btn btn-sm btn-outline-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
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

<!-- Payment Processing Modal -->
<div class="modal fade" id="paymentProcessModal" tabindex="-1" aria-labelledby="paymentProcessModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <div class="w-100">
                    <h4 class="modal-title text-center mb-3" id="paymentProcessModalLabel">
                        <i class="fas fa-credit-card me-2 text-primary"></i>Proses Pembayaran
                    </h4>
                    <!-- Step Indicator -->
                    <div class="step-indicator">
                        <div class="step-circle active" id="step1">1</div>
                        <div class="step-circle" id="step2">2</div>
                        <div class="step-circle" id="step3">3</div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <!-- Step 1: Konfirmasi -->
                <div class="payment-step active" id="confirmationStep">
                    <h5 class="mb-4 text-center">Konfirmasi Pembayaran</h5>
                    
                    <div class="payment-summary mb-4">
                        <div class="row">
                            <div class="col-6">
                                <strong>Jumlah Pembayaran:</strong>
                            </div>
                            <div class="col-6 text-end">
                                <span class="text-primary fw-bold" id="confirmAmount">-</span>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <strong>Metode Pembayaran:</strong>
                            </div>
                            <div class="col-6 text-end">
                                <span class="badge bg-primary" id="confirmMethod">-</span>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <strong>Biaya Admin:</strong>
                            </div>
                            <div class="col-6 text-end">
                                <span class="text-success">Gratis</span>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="row">
                            <div class="col-6">
                                <h6><strong>Total Bayar:</strong></h6>
                            </div>
                            <div class="col-6 text-end">
                                <h5 class="text-primary fw-bold mb-0" id="confirmTotal">-</h5>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Pastikan data pembayaran sudah benar sebelum melanjutkan.
                    </div>
                </div>

                <!-- Step 2: Pilih Detail Metode -->
                <div class="payment-step" id="methodStep">
                    <h5 class="mb-4 text-center">Pilih Detail Pembayaran</h5>
                    
                    <!-- Transfer Bank Options -->
                    <div id="bankOptions" style="display: none;">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="payment-method-card card h-100" data-method="bca">
                                    <div class="card-body text-center">
                                        <div class="text-primary mb-2">
                                            <i class="fas fa-university fa-2x"></i>
                                        </div>
                                        <h6 class="card-title">Bank BCA</h6>
                                        <small class="text-muted">Transfer via ATM/Mobile Banking</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="payment-method-card card h-100" data-method="mandiri">
                                    <div class="card-body text-center">
                                        <div class="text-primary mb-2">
                                            <i class="fas fa-university fa-2x"></i>
                                        </div>
                                        <h6 class="card-title">Bank Mandiri</h6>
                                        <small class="text-muted">Transfer via ATM/Mobile Banking</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="payment-method-card card h-100" data-method="bri">
                                    <div class="card-body text-center">
                                        <div class="text-primary mb-2">
                                            <i class="fas fa-university fa-2x"></i>
                                        </div>
                                        <h6 class="card-title">Bank BRI</h6>
                                        <small class="text-muted">Transfer via ATM/Mobile Banking</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="payment-method-card card h-100" data-method="bni">
                                    <div class="card-body text-center">
                                        <div class="text-primary mb-2">
                                            <i class="fas fa-university fa-2x"></i>
                                        </div>
                                        <h6 class="card-title">Bank BNI</h6>
                                        <small class="text-muted">Transfer via ATM/Mobile Banking</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- E-Wallet Options -->
                    <div id="ewalletOptions" style="display: none;">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="payment-method-card card h-100" data-method="gopay">
                                    <div class="card-body text-center">
                                        <div class="text-success mb-2">
                                            <i class="fas fa-mobile-alt fa-2x"></i>
                                        </div>
                                        <h6 class="card-title">GoPay</h6>
                                        <small class="text-muted">Bayar dengan GoPay</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="payment-method-card card h-100" data-method="ovo">
                                    <div class="card-body text-center">
                                        <div class="text-warning mb-2">
                                            <i class="fas fa-mobile-alt fa-2x"></i>
                                        </div>
                                        <h6 class="card-title">OVO</h6>
                                        <small class="text-muted">Bayar dengan OVO</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="payment-method-card card h-100" data-method="dana">
                                    <div class="card-body text-center">
                                        <div class="text-info mb-2">
                                            <i class="fas fa-mobile-alt fa-2x"></i>
                                        </div>
                                        <h6 class="card-title">DANA</h6>
                                        <small class="text-muted">Bayar dengan DANA</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="payment-method-card card h-100" data-method="shopeepay">
                                    <div class="card-body text-center">
                                        <div class="text-danger mb-2">
                                            <i class="fas fa-mobile-alt fa-2x"></i>
                                        </div>
                                        <h6 class="card-title">ShopeePay</h6>
                                        <small class="text-muted">Bayar dengan ShopeePay</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cash Options -->
                    <div id="cashOptions" style="display: none;">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Pembayaran Tunai</strong><br>
                            Silakan datang ke kantor kami untuk melakukan pembayaran tunai. 
                            Alamat: Jl. Contoh No. 123, Bandung, Jawa Barat.
                        </div>
                        <div class="text-center">
                            <i class="fas fa-money-bill-wave fa-4x text-success mb-3"></i>
                            <h5>Pembayaran Tunai</h5>
                            <p class="text-muted">Bayar langsung di kantor kami</p>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Processing -->
                <div class="payment-step" id="processingStep">
                    <div class="text-center">
                        <div class="mb-4">
                            <div class="loading-spinner mb-3"></div>
                            <h5>Memproses Pembayaran...</h5>
                            <p class="text-muted">Mohon tunggu, jangan tutup halaman ini.</p>
                        </div>

                        <div id="countdownSection" style="display: none;">
                            <div class="countdown-timer mb-3">
                                <div>Waktu Tersisa:</div>
                                <div id="countdown">15:00</div>
                            </div>
                            
                            <div id="paymentInstructions" class="mt-4">
                                <!-- Instructions will be loaded here -->
                            </div>

                            <!-- Upload Bukti Pembayaran Section -->
                            <div id="uploadSection" class="mt-4" style="display: none;">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">
                                            <i class="fas fa-upload me-2"></i>Upload Bukti Pembayaran
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="paymentProof" class="form-label">
                                                Pilih File Bukti Pembayaran <span class="text-danger">*</span>
                                            </label>
                                            <div class="upload-area" id="uploadArea">
                                                <input type="file" 
                                                       class="form-control" 
                                                       id="paymentProof" 
                                                       name="payment_proof" 
                                                       accept=".jpg,.jpeg,.png,.pdf"
                                                       style="display: none;">
                                                <div class="upload-placeholder text-center p-4" id="uploadPlaceholder">
                                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                                    <h6>Klik atau drag file ke sini</h6>
                                                    <p class="text-muted mb-2">Format: JPG, JPEG, PNG</p>
                                                    <p class="text-muted small">Maksimal ukuran 5MB</p>
                                                    <button type="button" class="btn btn-outline-primary btn-sm" id="selectFileBtn">
                                                        <i class="fas fa-folder-open me-2"></i>Pilih File
                                                    </button>
                                                </div>
                                                <div class="upload-preview" id="uploadPreview" style="display: none;">
                                                    <div class="d-flex align-items-center p-3 bg-light rounded">
                                                        <div class="me-3">
                                                            <i class="fas fa-file-alt fa-2x text-primary"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-1" id="fileName">file.jpg</h6>
                                                            <small class="text-muted" id="fileSize">1.2 MB</small>
                                                        </div>
                                                        <button type="button" class="btn btn-outline-danger btn-sm" id="removeFileBtn">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback" id="uploadError" style="display: none;">
                                                Harap upload bukti pembayaran yang valid.
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="paymentNotes" class="form-label">
                                                Catatan Tambahan (Opsional)
                                            </label>
                                            <textarea class="form-control" 
                                                      id="paymentNotes" 
                                                      name="payment_notes" 
                                                      rows="3" 
                                                      placeholder="Tambahkan catatan jika diperlukan, misalnya: Transfer dari rekening atas nama John Doe"></textarea>
                                        </div>

                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <small>
                                                <strong>Tips:</strong> Pastikan bukti pembayaran terlihat jelas, 
                                                termasuk nominal, tanggal, dan tujuan transfer untuk mempercepat verifikasi.
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="backBtn" style="display: none;">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </button>
                <button type="button" class="btn btn-outline-secondary" id="cancelBtn" data-bs-dismiss="modal">
                    Batal
                </button>
                <button type="button" class="btn btn-primary" id="nextBtn">
                    Lanjutkan <i class="fas fa-arrow-right ms-2"></i>
                </button>
                <button type="button" class="btn btn-success" id="processBtn" style="display: none;">
                    <i class="fas fa-check me-2"></i>Proses Pembayaran
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
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

    /* Payment Processing Modal Styles */
    .payment-step {
        display: none;
    }

    .payment-step.active {
        display: block;
    }

    .step-indicator {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 2rem;
    }

    .step-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin: 0 1rem;
        position: relative;
    }

    .step-circle.active {
        background: #007bff;
        color: white;
    }

    .step-circle.completed {
        background: #28a745;
        color: white;
    }

    .step-circle::after {
        content: '';
        position: absolute;
        right: -2rem;
        top: 50%;
        transform: translateY(-50%);
        width: 2rem;
        height: 2px;
        background: #e9ecef;
    }

    .step-circle:last-child::after {
        display: none;
    }

    .step-circle.completed::after {
        background: #28a745;
    }

    .payment-method-card {
        border: 2px solid #e9ecef;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .payment-method-card:hover {
        border-color: #007bff;
        transform: translateY(-2px);
    }

    .payment-method-card.selected {
        border-color: #007bff;
        background: #f8f9ff;
    }

    .payment-summary {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1.5rem;
    }

    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid #007bff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .countdown-timer {
        font-family: 'Courier New', monospace;
        font-size: 1.5rem;
        color: #dc3545;
        text-align: center;
        padding: 1rem;
        background: #f8d7da;
        border-radius: 8px;
        border: 1px solid #f5c6cb;
    }

    /* Upload Area Styles */
    .upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        transition: all 0.3s ease;
        position: relative;
    }

    .upload-area:hover {
        border-color: #007bff;
        background-color: #f8f9ff;
    }

    .upload-area.dragover {
        border-color: #007bff;
        background-color: #e3f2fd;
        transform: scale(1.02);
    }

    .upload-placeholder {
        cursor: pointer;
    }

    .upload-preview {
        border: 2px solid #28a745;
        background-color: #d4edda;
    }

    .file-error {
        border-color: #dc3545 !important;
        background-color: #f8d7da !important;
    }

    /* Image Preview Styles */
    .image-preview {
        max-width: 100%;
        max-height: 200px;
        border-radius: 8px;
        margin-top: 1rem;
    }

    @media (max-width: 768px) {
        .container {
            padding: 1rem;
        }
        
        .h4 {
            font-size: 1.1rem;
        }

        .step-circle {
            width: 35px;
            height: 35px;
            margin: 0 0.5rem;
            font-size: 0.9rem;
        }

        .step-circle::after {
            width: 1rem;
            right: -1rem;
        }
    }
</style>
@endpush
@push('scripts')
<script>
    // Updated JavaScript for the frontend
    document.addEventListener('DOMContentLoaded', function() {
        let currentStep = 1;
        let paymentData = {};

        // Quick amount buttons
        const quickAmountButtons = document.querySelectorAll('.quick-amount');
        const amountInput = document.getElementById('amount');
        
        quickAmountButtons.forEach(button => {
            button.addEventListener('click', function() {
                const amount = this.dataset.amount;
                amountInput.value = amount;
                
                quickAmountButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
            });
        });
        
        if (amountInput) {
            amountInput.addEventListener('input', function() {
                quickAmountButtons.forEach(btn => btn.classList.remove('active'));
            });
        }

        // Payment Process Button
        document.getElementById('processPaymentBtn').addEventListener('click', function() {
            const amount = document.getElementById('amount').value;
            const paymentMethod = document.getElementById('payment_method').value;
            
            if (!amount || !paymentMethod) {
                showAlert('Harap lengkapi semua field yang diperlukan!', 'warning');
                return;
            }
            
            if (parseInt(amount) < 400000) {
                showAlert('Jumlah pembayaran minimal Rp 400.000!', 'warning');
                return;
            }

            const maxAmount = {{ $trx->amount - $totalPaid }};
            if (parseInt(amount) > maxAmount) {
                showAlert('Jumlah pembayaran melebihi sisa tagihan!', 'warning');
                return;
            }

            // Store payment data
            paymentData = {
                amount: parseInt(amount),
                paymentMethod: paymentMethod
            };

            // Show confirmation data
            document.getElementById('confirmAmount').textContent = 'Rp ' + parseInt(amount).toLocaleString('id-ID');
            document.getElementById('confirmMethod').textContent = getPaymentMethodName(paymentMethod);
            document.getElementById('confirmTotal').textContent = 'Rp ' + parseInt(amount).toLocaleString('id-ID');

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('paymentProcessModal'));
            modal.show();
        });

        // Modal Navigation
        document.getElementById('nextBtn').addEventListener('click', function() {
            if (currentStep === 1) {
                // Move to step 2
                showStep(2);
                showPaymentOptions(paymentData.paymentMethod);
            } else if (currentStep === 2) {
            // Validate selection for step 2
                const selectedMethod = document.querySelector('.payment-method-card.selected');
                if (!selectedMethod && paymentData.paymentMethod !== 'cash') {
                    showAlert('Silakan pilih metode pembayaran yang diinginkan!', 'warning');
                    return;
                }
                
                if (selectedMethod) {
                    paymentData.selectedMethod = selectedMethod.dataset.method;
                }
                
                // Move to step 3
                showStep(3);
                processPayment();
            }
        });

        document.getElementById('backBtn').addEventListener('click', function() {
            if (currentStep === 2) {
                showStep(1);
            } else if (currentStep === 3) {
                showStep(2);
            }
        });

        document.getElementById('processBtn').addEventListener('click', function() {
            // Validate file upload
            const fileInput = document.getElementById('paymentProof');
            if (!fileInput.files || fileInput.files.length === 0) {
                showUploadError('Harap upload bukti pembayaran terlebih dahulu.');
                return;
            }

            // Validate file size (5MB)
            if (fileInput.files[0].size > 5 * 1024 * 1024) {
                showUploadError('Ukuran file maksimal 5MB.');
                return;
            }

            // Submit the form with file
            submitPaymentWithFile();
        });

        // File upload handlers
        const fileInput = document.getElementById('paymentProof');
        const uploadArea = document.getElementById('uploadArea');
        const selectFileBtn = document.getElementById('selectFileBtn');
        const removeFileBtn = document.getElementById('removeFileBtn');
        const uploadPlaceholder = document.getElementById('uploadPlaceholder');
        const uploadPreview = document.getElementById('uploadPreview');

        // Click to select file
        selectFileBtn.addEventListener('click', function() {
            fileInput.click();
        });

        uploadPlaceholder.addEventListener('click', function() {
            fileInput.click();
        });

        // File selection handler
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (validateFile(file)) {
                    showFilePreview(file);
                } else {
                    clearFileSelection();
                }
            }
        });

        // Remove file handler
        removeFileBtn.addEventListener('click', function() {
            clearFileSelection();
        });

        // Drag and drop handlers
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                if (validateFile(file)) {
                    fileInput.files = files;
                    showFilePreview(file);
                } else {
                    clearFileSelection();
                }
            }
        });

        // Payment method cards selection
        document.addEventListener('click', function(e) {
            if (e.target.closest('.payment-method-card')) {
                // Remove selection from all cards
                document.querySelectorAll('.payment-method-card').forEach(card => {
                    card.classList.remove('selected');
                });
                
                // Add selection to clicked card
                e.target.closest('.payment-method-card').classList.add('selected');
            }
        });

        // Utility Functions
        function validateFile(file) {
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
            const maxSize = 5 * 1024 * 1024; // 5MB

            if (!allowedTypes.includes(file.type)) {
                showUploadError('Format file tidak didukung. Gunakan JPG, PNG, atau PDF.');
                return false;
            }

            if (file.size > maxSize) {
                showUploadError('Ukuran file maksimal 5MB.');
                return false;
            }

            hideUploadError();
            return true;
        }

        function showFilePreview(file) {
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            
            uploadPlaceholder.style.display = 'none';
            uploadPreview.style.display = 'block';
            uploadArea.classList.remove('file-error');

            // Show image preview for image files
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const existingPreview = uploadPreview.querySelector('.image-preview');
                    if (existingPreview) {
                        existingPreview.remove();
                    }
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'image-preview';
                    img.alt = 'Preview bukti pembayaran';
                    uploadPreview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        }

        function clearFileSelection() {
            fileInput.value = '';
            uploadPlaceholder.style.display = 'block';
            uploadPreview.style.display = 'none';
            uploadArea.classList.remove('file-error');
            hideUploadError();
            
            // Remove image preview
            const existingPreview = uploadPreview.querySelector('.image-preview');
            if (existingPreview) {
                existingPreview.remove();
            }
        }

        function showUploadError(message) {
            const errorDiv = document.getElementById('uploadError');
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
            uploadArea.classList.add('file-error');
        }

        function hideUploadError() {
            const errorDiv = document.getElementById('uploadError');
            errorDiv.style.display = 'none';
            uploadArea.classList.remove('file-error');
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function showStep(step) {
            currentStep = step;
            
            // Hide all steps
            document.querySelectorAll('.payment-step').forEach(stepEl => {
                stepEl.classList.remove('active');
            });
            
            // Show current step
            if (step === 1) {
                document.getElementById('confirmationStep').classList.add('active');
                document.getElementById('backBtn').style.display = 'none';
                document.getElementById('nextBtn').style.display = 'inline-block';
                document.getElementById('processBtn').style.display = 'none';
                document.getElementById('nextBtn').innerHTML = 'Lanjutkan <i class="fas fa-arrow-right ms-2"></i>';
            } else if (step === 2) {
                document.getElementById('methodStep').classList.add('active');
                document.getElementById('backBtn').style.display = 'inline-block';
                document.getElementById('nextBtn').style.display = 'inline-block';
                document.getElementById('processBtn').style.display = 'none';
                document.getElementById('nextBtn').innerHTML = 'Proses <i class="fas fa-arrow-right ms-2"></i>';
            } else if (step === 3) {
                document.getElementById('processingStep').classList.add('active');
                document.getElementById('backBtn').style.display = 'none';
                document.getElementById('nextBtn').style.display = 'none';
                document.getElementById('processBtn').style.display = 'none';
                document.getElementById('cancelBtn').style.display = 'none';
            }
            
            // Update step indicator
            updateStepIndicator(step);
        }

        function updateStepIndicator(step) {
            for (let i = 1; i <= 3; i++) {
                const stepEl = document.getElementById('step' + i);
                stepEl.classList.remove('active', 'completed');
                
                if (i < step) {
                    stepEl.classList.add('completed');
                    stepEl.innerHTML = '<i class="fas fa-check"></i>';
                } else if (i === step) {
                    stepEl.classList.add('active');
                    stepEl.innerHTML = i;
                } else {
                    stepEl.innerHTML = i;
                }
            }
        }

        function showPaymentOptions(paymentMethod) {
            // Hide all options
            document.getElementById('bankOptions').style.display = 'none';
            document.getElementById('ewalletOptions').style.display = 'none';
            document.getElementById('cashOptions').style.display = 'none';
            
            // Show relevant options
            if (paymentMethod === 'transfer_bank') {
                document.getElementById('bankOptions').style.display = 'block';
            } else if (paymentMethod === 'ewallet') {
                document.getElementById('ewalletOptions').style.display = 'block';
            } else if (paymentMethod === 'cash') {
                document.getElementById('cashOptions').style.display = 'block';
            }
        }

        function processPayment() {
            // Simulate payment processing
            setTimeout(function() {
                // Hide loading spinner and show countdown
                document.querySelector('.loading-spinner').style.display = 'none';
                document.querySelector('#processingStep h5').textContent = 'Menunggu Pembayaran';
                document.querySelector('#processingStep .text-muted').textContent = 'Silakan lakukan pembayaran sesuai instruksi di bawah ini.';
                
                document.getElementById('countdownSection').style.display = 'block';
                
                // Show payment instructions based on selected method
                showPaymentInstructions();
                
                // Start countdown timer
                startCountdown(15 * 60); // 15 minutes
                
                // Show upload section after instructions
                setTimeout(function() {
                    document.getElementById('uploadSection').style.display = 'block';
                }, 1000);
                
                // Show process button
                document.getElementById('processBtn').style.display = 'inline-block';
                document.getElementById('processBtn').innerHTML = '<i class="fas fa-paper-plane me-2"></i>Kirim Bukti Pembayaran';
            }, 2000);
        }

        function showPaymentInstructions() {
            const instructionsDiv = document.getElementById('paymentInstructions');
            let instructions = '';
            
            if (paymentData.paymentMethod === 'transfer_bank') {
                // Fetch bank details from backend
                fetchBankDetails(paymentData.selectedMethod || 'bca').then(bankDetails => {
                    instructions = `
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fas fa-university me-2"></i>Transfer ke Bank ${bankDetails.bank_name}</h6>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-4"><strong>Bank:</strong></div>
                                    <div class="col-8">${bankDetails.bank_name}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-4"><strong>No. Rekening:</strong></div>
                                    <div class="col-8">
                                        <span class="fw-bold text-primary">${bankDetails.account_number}</span>
                                        <button class="btn btn-sm btn-outline-secondary ms-2" onclick="copyToClipboard('${bankDetails.account_number}')">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-4"><strong>Atas Nama:</strong></div>
                                    <div class="col-8">${bankDetails.account_name}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-4"><strong>Jumlah:</strong></div>
                                    <div class="col-8">
                                        <span class="fw-bold text-success">Rp ${paymentData.amount.toLocaleString('id-ID')}</span>
                                        <button class="btn btn-sm btn-outline-secondary ms-2" onclick="copyToClipboard('${paymentData.amount}')">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <small>Transfer dengan jumlah yang tepat untuk mempercepat proses verifikasi.</small>
                                </div>
                            </div>
                        </div>
                    `;
                    instructionsDiv.innerHTML = instructions;
                });
            } else if (paymentData.paymentMethod === 'ewallet') {
                const walletName = paymentData.selectedMethod ? paymentData.selectedMethod.toUpperCase() : 'GOPAY';
                instructions = `
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-mobile-alt me-2"></i>Pembayaran ${walletName}</h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <div style="width: 200px; height: 200px; background: #f8f9fa; border: 2px dashed #dee2e6; margin: 0 auto; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                                    <div class="text-muted">
                                        <i class="fas fa-qrcode fa-4x"></i>
                                        <div class="mt-2">QR Code</div>
                                    </div>
                                </div>
                            </div>
                            <p>Scan QR Code di atas dengan aplikasi ${walletName}</p>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <small>Pastikan jumlah pembayaran sesuai: <strong>Rp ${paymentData.amount.toLocaleString('id-ID')}</strong></small>
                            </div>
                        </div>
                    </div>
                `;
                instructionsDiv.innerHTML = instructions;
            } else if (paymentData.paymentMethod === 'cash') {
                instructions = `
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-store me-2"></i>Pembayaran Tunai</h6>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                <strong>Alamat Kantor:</strong><br>
                                Jl. Contoh No. 123, Bandung, Jawa Barat 40123
                            </div>
                            <div class="alert alert-success">
                                <i class="fas fa-clock me-2"></i>
                                <strong>Jam Operasional:</strong><br>
                                Senin - Jumat: 08.00 - 17.00 WIB<br>
                                Sabtu: 08.00 - 12.00 WIB
                            </div>
                            <p class="text-center fw-bold text-primary fs-5">
                                Jumlah Bayar: Rp ${paymentData.amount.toLocaleString('id-ID')}
                            </p>
                        </div>
                    </div>
                `;
                instructionsDiv.innerHTML = instructions;
            }
        }

        function fetchBankDetails(bankCode) {
            // Default bank details if API call fails
            const defaultBanks = {
                'bca': {
                    bank_name: 'BCA',
                    account_number: '1234567890',
                    account_name: 'LPK Amarta Bangun Indonesia'
                },
                'mandiri': {
                    bank_name: 'MANDIRI',
                    account_number: '1380012345678',
                    account_name: 'LPK Amarta Bangun Indonesia'
                },
                'bri': {
                    bank_name: 'BRI',
                    account_number: '123456789012345',
                    account_name: 'LPK Amarta Bangun Indonesia'
                },
                'bni': {
                    bank_name: 'BNI',
                    account_number: '1234567890',
                    account_name: 'LPK Amarta Bangun Indonesia'
                }
            };

            return fetch('/api/payment-method-details?type=transfer_bank&method=' + bankCode)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        return data.data;
                    }
                    throw new Error('API Error');
                })
                .catch(() => {
                    return defaultBanks[bankCode] || defaultBanks['bca'];
                });
        }

        function startCountdown(seconds) {
            const countdownEl = document.getElementById('countdown');
            
            const timer = setInterval(function() {
                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = seconds % 60;
                
                countdownEl.textContent = `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
                
                if (seconds <= 0) {
                    clearInterval(timer);
                    countdownEl.textContent = '00:00';
                    // Handle timeout
                    showAlert('Waktu pembayaran habis. Silakan coba lagi.', 'warning');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('paymentProcessModal'));
                    modal.hide();
                }
                
                seconds--;
            }, 1000);
        }

        function getPaymentMethodName(method) {
            const methods = {
                'transfer_bank': 'Transfer Bank',
                'ewallet': 'E-Wallet',
                'cash': 'Tunai'
            };
            return methods[method] || method;
        }

        function submitPaymentWithFile() {
            // Create FormData for file upload
            const formData = new FormData();
            
            // Add CSRF token
            formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}');
            
            // Add payment data
            formData.append('amount', paymentData.amount);
            formData.append('payment_method', paymentData.paymentMethod);
            
            // Add selected method if exists
            if (paymentData.selectedMethod) {
                formData.append('selected_method', paymentData.selectedMethod);
            }
            
            // Add file
            const fileInput = document.getElementById('paymentProof');
            if (fileInput.files[0]) {
                formData.append('payment_proof', fileInput.files[0]);
            }
            
            // Add notes
            const notes = document.getElementById('paymentNotes').value;
            if (notes) {
                formData.append('payment_notes', notes);
            }
            
            // Show loading state
            const processBtn = document.getElementById('processBtn');
            const transactionId = {{ $trx->id }};
            const originalText = processBtn.innerHTML;
            processBtn.innerHTML = '<span class="loading-spinner me-2"></span>Mengirim...';
            processBtn.disabled = true;
            
            // Submit using fetch
            fetch(`/transaksi/program-kelas/${transactionId}/cicilan`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showSuccessMessage(data.data);
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Terjadi kesalahan');
                }
            })
            .catch(error => {
                // Restore button state
                processBtn.innerHTML = originalText;
                processBtn.disabled = false;
                
                showAlert('Terjadi kesalahan: ' + error.message, 'error');
            });
        }

        function showSuccessMessage(data) {
            const processingStep = document.getElementById('processingStep');
            processingStep.innerHTML = `
                <div class="text-center">
                    <div class="text-success mb-4">
                        <i class="fas fa-check-circle fa-5x"></i>
                    </div>
                    <h4 class="text-success mb-3">Bukti Pembayaran Berhasil Dikirim!</h4>
                    <div class="alert alert-info mb-4">
                        <div class="row">
                            <div class="col-6"><strong>Nomor Referensi:</strong></div>
                            <div class="col-6 text-end"><strong>${data.reference_number}</strong></div>
                        </div>
                        <div class="row">
                            <div class="col-6"><strong>Jumlah:</strong></div>
                            <div class="col-6 text-end"><strong>Rp ${data.amount.toLocaleString('id-ID')}</strong></div>
                        </div>
                    </div>
                    <p class="text-muted mb-4">
                        Terima kasih! Bukti pembayaran Anda sedang diverifikasi oleh tim kami. 
                        Anda akan mendapatkan notifikasi setelah pembayaran dikonfirmasi.
                    </p>
                    <div class="alert alert-success">
                        <i class="fas fa-clock me-2"></i>
                        <strong>Estimasi verifikasi:</strong> 1-3 jam kerja
                    </div>
                </div>
            `;
            
            // Hide process button
            document.getElementById('processBtn').style.display = 'none';
        }

        function showAlert(message, type = 'info') {
            // Create alert element
            const alertTypes = {
                'success': 'alert-success',
                'error': 'alert-danger',
                'warning': 'alert-warning',
                'info': 'alert-info'
            };

            const alertClass = alertTypes[type] || 'alert-info';
            const iconTypes = {
                'success': 'fa-check-circle',
                'error': 'fa-exclamation-circle',
                'warning': 'fa-exclamation-triangle',
                'info': 'fa-info-circle'
            };
            const iconClass = iconTypes[type] || 'fa-info-circle';

            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                    <i class="fas ${iconClass} me-2"></i>${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;

            // Insert alert at the top of the content
            const container = document.querySelector('.container.py-4');
            container.insertAdjacentHTML('afterbegin', alertHtml);

            // Auto dismiss after 5 seconds
            setTimeout(function() {
                const alert = container.querySelector('.alert');
                if (alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 5000);
        }

        // Reset modal when closed
        document.getElementById('paymentProcessModal').addEventListener('hidden.bs.modal', function() {
            currentStep = 1;
            showStep(1);
            document.getElementById('cancelBtn').style.display = 'inline-block';
            
            // Reset selections
            document.querySelectorAll('.payment-method-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            // Reset file upload
            clearFileSelection();
            document.getElementById('paymentNotes').value = '';
            document.getElementById('uploadSection').style.display = 'none';
        });

        // Copy to clipboard function
        window.copyToClipboard = function(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show success toast
                showToast('Teks berhasil disalin ke clipboard!', 'success');
            }).catch(function() {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showToast('Teks berhasil disalin ke clipboard!', 'success');
            });
        };

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = 'position-fixed top-0 end-0 p-3';
            toast.style.zIndex = '9999';
            
            const toastTypes = {
                'success': { bg: 'bg-success', icon: 'fa-check-circle' },
                'error': { bg: 'bg-danger', icon: 'fa-exclamation-circle' },
                'warning': { bg: 'bg-warning', icon: 'fa-exclamation-triangle' },
                'info': { bg: 'bg-info', icon: 'fa-info-circle' }
            };
            
            const toastConfig = toastTypes[type] || toastTypes['info'];
            
            toast.innerHTML = `
                <div class="toast show" role="alert">
                    <div class="toast-header ${toastConfig.bg} text-white">
                        <i class="fas ${toastConfig.icon} me-2"></i>
                        <strong class="me-auto">Notifikasi</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(function() {
                if (document.body.contains(toast)) {
                    document.body.removeChild(toast);
                }
            }, 3000);
        }

        // Progress bar animation
        let targetValue = {{ ($totalPaid / $trx->amount) * 100 }};
        let progressBar = document.querySelector(".progress-bar");
        let currentValue = 0;

        if (progressBar) {
            let animation = setInterval(function () {
                if (currentValue >= targetValue) {
                    clearInterval(animation);
                } else {
                    currentValue += 0.5; // lebih smooth
                    progressBar.style.width = currentValue + "%";
                    progressBar.setAttribute("aria-valuenow", currentValue.toFixed(1));
                }
            }, 10);
        }
    });

</script>
@endpush