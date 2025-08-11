@extends('layouts.dashboard')

@section('title', 'Halaman Pembayaran')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Payment Header -->
            <div class="text-center mb-4">
                <h1 class="h2 mb-2 text-primary">
                    <i class="fas fa-credit-card me-2"></i>Halaman Pembayaran
                </h1>
                <p class="text-muted">Silakan lakukan pembayaran sesuai dengan detail di bawah ini</p>
            </div>

            <div class="row">
                <!-- Payment Details Card -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-file-invoice-dollar me-2"></i>Detail Pembayaran
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <!-- Payment Status -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="fas fa-barcode fa-2x text-muted me-3"></i>
                                        <div>
                                            <small class="text-muted">ID Pembayaran</small>
                                            <div class="fw-bold">{{ $payment->uuid }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="fas fa-info-circle fa-2x text-info me-3"></i>
                                        <div>
                                            <small class="text-muted">Status</small>
                                            <div>
                                                @switch($payment->status)
                                                    @case('pending')
                                                        <span class="badge bg-warning">
                                                            <i class="fas fa-clock me-1"></i>Menunggu Pembayaran
                                                        </span>
                                                        @break
                                                    @case('verification')
                                                        <span class="badge bg-info">
                                                            <i class="fas fa-search me-1"></i>Menunggu Verifikasi
                                                        </span>
                                                        @break
                                                    @case('paid')
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check me-1"></i>Lunas
                                                        </span>
                                                        @break
                                                    @case('failed')
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-times me-1"></i>Gagal
                                                        </span>
                                                        @break
                                                    @case('expired')
                                                        <span class="badge bg-secondary">
                                                            <i class="fas fa-ban me-1"></i>Kedaluwarsa
                                                        </span>
                                                        @break
                                                @endswitch
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Amount -->
                            <div class="bg-light p-4 rounded mb-4">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-tag fa-2x text-primary me-3"></i>
                                            <div>
                                                <small class="text-muted">Jenis Pembayaran</small>
                                                <div class="fw-bold text-capitalize">
                                                    {{ str_replace('_', ' ', $payment->type) }}
                                                </div>
                                                @if($payment->fee)
                                                    <small class="text-muted">{{ $payment->fee->name }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-md-end">
                                        <small class="text-muted">Total Pembayaran</small>
                                        <div class="h3 text-success mb-0 fw-bold">
                                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                        </div>
                                        @if($payment->is_installment)
                                            <small class="text-warning">
                                                <i class="fas fa-calendar-alt me-1"></i>Cicilan {{ $payment->installment_months }} bulan
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Method Info -->
                            @if($payment->paymentMethod)
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-university me-2"></i>Informasi Transfer
                                    </h6>
                                    <div class="card bg-light border-0">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="text-center mb-3 mb-md-0">
                                                        <i class="fas fa-university fa-3x text-primary mb-2"></i>
                                                        <div class="h5 mb-0">{{ $payment->paymentMethod->bank_name }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <small class="text-muted">Nomor Rekening</small>
                                                            <div class="fw-bold h5 text-primary" id="accountNumber">
                                                                {{ $payment->paymentMethod->account_number }}
                                                            </div>
                                                            <button class="btn btn-outline-primary btn-sm" onclick="copyToClipboard('accountNumber')">
                                                                <i class="fas fa-copy me-1"></i>Salin
                                                            </button>
                                                        </div>
                                                        <div class="col-6">
                                                            <small class="text-muted">Atas Nama</small>
                                                            <div class="fw-bold">
                                                                {{ $payment->paymentMethod->account_name }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Timer Countdown (if not expired) -->
                            @if($payment->expires_at && now()->lessThan($payment->expires_at))
                            <div class="alert alert-warning mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-hourglass-half fa-2x me-3"></i>
                                    <div>
                                        <h6 class="alert-heading mb-1">Waktu Pembayaran Terbatas</h6>
                                        <div>Selesaikan pembayaran dalam: 
                                            <span class="fw-bold text-danger" id="countdown">
                                                {{ $payment->expires_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Payment Instructions -->
                            <div class="mb-4">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-list-ol me-2"></i>Cara Pembayaran
                                </h6>
                                <ol class="list-group list-group-numbered">
                                    <li class="list-group-item border-0 ps-0">
                                        Transfer sesuai nominal yang tertera ke rekening di atas
                                    </li>
                                    <li class="list-group-item border-0 ps-0">
                                        Simpan bukti transfer dari bank atau mobile banking
                                    </li>
                                    <li class="list-group-item border-0 ps-0">
                                        Upload bukti pembayaran menggunakan form di samping
                                    </li>
                                    <li class="list-group-item border-0 ps-0">
                                        Tunggu konfirmasi dari admin maksimal 1x24 jam
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload Proof Card -->
                <div class="col-lg-4">
                    @if($payment->status === 'pending')
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-upload me-2"></i>Upload Bukti
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form action="{{ route('payments.pay.uploadProof', $payment->uuid) }}" method="POST" 
                                  enctype="multipart/form-data" id="uploadForm">
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="proof_photo" class="form-label">
                                        <i class="fas fa-camera me-1"></i>Bukti Pembayaran
                                    </label>
                                    <input type="file" 
                                           class="form-control @error('proof_photo') is-invalid @enderror" 
                                           id="proof_photo" 
                                           name="proof_photo" 
                                           accept="image/*" 
                                           required>
                                    @error('proof_photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Format: JPG, PNG, JPEG. Maksimal 2MB
                                    </div>
                                </div>

                                <!-- Image Preview -->
                                <div id="imagePreview" class="mb-3 d-none">
                                    <label class="form-label">Preview</label>
                                    <div class="border rounded p-2">
                                        <img id="previewImg" src="" alt="Preview" class="img-fluid rounded">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success w-100" id="uploadBtn">
                                    <i class="fas fa-paper-plane me-2"></i>Upload Bukti
                                </button>
                            </form>
                        </div>
                    </div>

                    @elseif($payment->status === 'verification')
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-clock me-2"></i>Menunggu Verifikasi
                            </h5>
                        </div>
                        <div class="card-body text-center p-4">
                            <i class="fas fa-search fa-4x text-info mb-3"></i>
                            <h6>Bukti pembayaran sedang diverifikasi</h6>
                            <p class="text-muted mb-0">
                                Proses verifikasi memakan waktu maksimal 1x24 jam. 
                                Anda akan mendapat notifikasi setelah pembayaran dikonfirmasi.
                            </p>
                            
                            @if($payment->proof_photo)
                            <div class="mt-3">
                                <button class="btn btn-outline-info btn-sm" type="button" 
                                        data-bs-toggle="modal" data-bs-target="#proofModal">
                                    <i class="fas fa-eye me-1"></i>Lihat Bukti yang Diupload
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>

                    @elseif($payment->status === 'paid')
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-check-circle me-2"></i>Pembayaran Berhasil
                            </h5>
                        </div>
                        <div class="card-body text-center p-4">
                            <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                            <h6>Pembayaran telah dikonfirmasi</h6>
                            <p class="text-muted mb-3">
                                Terima kasih! Pembayaran Anda telah berhasil diverifikasi.
                            </p>
                            @if($payment->paid_at)
                            <small class="text-muted">
                                Dikonfirmasi pada: {{ $payment->paid_at->format('d/m/Y H:i') }}
                            </small>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Contact Support -->
                    <div class="card shadow-sm border-0 mt-4">
                        <div class="card-body text-center p-4">
                            <h6 class="text-primary">
                                <i class="fas fa-question-circle me-2"></i>Butuh Bantuan?
                            </h6>
                            <p class="text-muted mb-3">
                                Jika mengalami kendala dalam pembayaran, silakan hubungi customer service kami
                            </p>
                            <div class="row">
                                <div class="col-6">
                                    <a href="https://wa.me/6281234567890" class="btn btn-outline-success btn-sm w-100" target="_blank">
                                        <i class="fab fa-whatsapp me-1"></i>WhatsApp
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="mailto:support@lpkamarta.com" class="btn btn-outline-primary btn-sm w-100">
                                        <i class="fas fa-envelope me-1"></i>Email
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Proof Modal -->
@if($payment->proof_photo)
<div class="modal fade" id="proofModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-image me-2"></i>Bukti Pembayaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ Storage::url($payment->proof_photo) }}" 
                     alt="Bukti Pembayaran" 
                     class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>
@endif

<style>
.card {
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.card-header {
    border-bottom: none;
    background: linear-gradient(45deg, var(--bs-primary), #0056b3) !important;
}

.bg-success .card-header {
    background: linear-gradient(45deg, var(--bs-success), #146c43) !important;
}

.bg-info .card-header {
    background: linear-gradient(45deg, var(--bs-info), #087990) !important;
}

.btn-outline-primary:hover,
.btn-outline-success:hover,
.btn-outline-info:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.list-group-numbered {
    counter-reset: section;
}

.list-group-numbered .list-group-item {
    position: relative;
    padding-left: 2.5rem;
}

.list-group-numbered .list-group-item::before {
    content: counter(section);
    counter-increment: section;
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 1.5rem;
    height: 1.5rem;
    background: #0d6efd;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 0.8rem;
}

.alert {
    border-radius: 10px;
    border: none;
}

#countdown {
    font-family: 'Courier New', monospace;
}

.badge {
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
}

@media (max-width: 768px) {
    .container-fluid {
        padding: 15px;
    }
    
    .h3 {
        font-size: 1.5rem;
    }
}

/* Loading animation */
.btn-loading {
    position: relative;
}

.btn-loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 1rem;
    height: 1rem;
    margin-top: -0.5rem;
    margin-left: -0.5rem;
    border: 2px solid transparent;
    border-top-color: currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const proofInput = document.getElementById('proof_photo');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const uploadForm = document.getElementById('uploadForm');
    const uploadBtn = document.getElementById('uploadBtn');

    // Image preview functionality
    if (proofInput) {
        proofInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    imagePreview.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.classList.add('d-none');
            }
        });
    }

    // Form submission with loading state
    if (uploadForm) {
        uploadForm.addEventListener('submit', function() {
            uploadBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengupload...';
            uploadBtn.disabled = true;
            uploadBtn.classList.add('btn-loading');
        });
    }

    // Copy to clipboard functionality
    window.copyToClipboard = function(elementId) {
        const element = document.getElementById(elementId);
        const text = element.textContent.trim();
        
        navigator.clipboard.writeText(text).then(function() {
            // Show success feedback
            const originalText = element.parentElement.querySelector('button').innerHTML;
            const button = element.parentElement.querySelector('button');
            button.innerHTML = '<i class="fas fa-check me-1"></i>Tersalin!';
            button.classList.remove('btn-outline-primary');
            button.classList.add('btn-success');
            
            setTimeout(function() {
                button.innerHTML = originalText;
                button.classList.remove('btn-success');
                button.classList.add('btn-outline-primary');
            }, 2000);
        }).catch(function() {
            alert('Gagal menyalin. Silakan salin manual: ' + text);
        });
    };

    // Countdown timer
    const countdownElement = document.getElementById('countdown');
    if (countdownElement) {
        const expiresAt = new Date('{{ $payment->expires_at ?? now() }}').getTime();
        
        const updateCountdown = function() {
            const now = new Date().getTime();
            const timeLeft = expiresAt - now;
            
            if (timeLeft > 0) {
                const hours = Math.floor(timeLeft / (1000 * 60 * 60));
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
                
                countdownElement.textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            } else {
                countdownElement.textContent = 'KEDALUWARSA';
                countdownElement.classList.add('text-danger');
                // Optionally redirect or show expired message
                setTimeout(function() {
                    location.reload();
                }, 2000);
            }
        };
        
        updateCountdown();
        setInterval(updateCountdown, 1000);
    }

    // Auto refresh page every 5 minutes to check payment status
    if ({{ $payment->status === 'verification' ? 'true' : 'false' }}) {
        setInterval(function() {
            location.reload();
        }, 300000); // 5 minutes
    }
});

// Prevent back button after payment success
if ({{ $payment->status === 'paid' ? 'true' : 'false' }}) {
    history.pushState(null, null, location.href);
    window.onpopstate = function() {
        history.go(1);
    };
}
</script>
@endsection