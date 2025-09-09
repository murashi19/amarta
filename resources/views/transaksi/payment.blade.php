@extends('layouts.dashboard')

@section('title', 'Pembayaran ' . ucfirst($trx->type) . ' - Sistem Pembayaran Online')

@section('meta')
<meta name="description" content="Halaman pembayaran {{ ucfirst($trx->type) }} dengan metode transfer bank, e-wallet, dan tunai. Upload bukti pembayaran dengan mudah dan aman.">
<meta name="keywords" content="pembayaran online, transfer bank, e-wallet, bukti pembayaran, {{ $trx->type }}">
<meta name="robots" content="noindex, nofollow">
<meta property="og:title" content="Pembayaran {{ ucfirst($trx->type) }}">
<meta property="og:description" content="Lakukan pembayaran dengan mudah melalui berbagai metode yang tersedia">
<meta property="og:type" content="website">
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    :root {
        --primary-color: #0d6efd;
        --success-color: #198754;
        --warning-color: #ffc107;
        --danger-color: #dc3545;
        --info-color: #0dcaf0;
    }

    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .main-container {
        padding: 2rem 0;
    }

    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border-radius: 0.75rem;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary-color), #0a58ca);
        color: white;
        border-radius: 0.75rem 0.75rem 0 0 !important;
        border: none;
        padding: 1.5rem;
    }
     .btn-custom {
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .btn-pay {
            background: linear-gradient(135deg, #4a9eff, #667eea);
            color: white;
        }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pending {
        background-color: #fff3cd;
        color: #664d03;
        border: 1px solid #ffecb5;
    }

    .status-verification {
        background-color: #cff4fc;
        color: #055160;
        border: 1px solid #b6effb;
    }

    .status-completed {
        background-color: #d1e7dd;
        color: #0f5132;
        border: 1px solid #badbcc;
    }

    .status-failed {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c2c7;
    }

    .amount-display {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    .payment-method-card {
        border: 2px solid #dee2e6;
        border-radius: 0.75rem;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
        height: 100%;
    }

    .payment-method-card:hover {
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(13, 110, 253, 0.15);
    }

    .payment-method input[type="radio"] {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .payment-method input:checked + .payment-method-card {
        border-color: var(--primary-color);
        background: #f8f9ff;
        box-shadow: 0 0.5rem 1rem rgba(13, 110, 253, 0.25);
    }

    .payment-icon {
        font-size: 2.5rem;
        color: #6c757d;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .payment-method:hover .payment-icon,
    .payment-method input:checked + .payment-method-card .payment-icon {
        color: var(--primary-color);
        transform: scale(1.1);
    }

    .upload-zone {
        border: 2px dashed #dee2e6;
        border-radius: 0.75rem;
        padding: 3rem 2rem;
        text-align: center;
        background: #f8f9fa;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .upload-zone:hover,
    .upload-zone.dragover {
        border-color: var(--primary-color);
        background: #f8f9ff;
    }

    .upload-zone.has-file {
        border-color: var(--success-color);
        background: #f8fff9;
    }

    .upload-icon {
        font-size: 3rem;
        color: #6c757d;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .upload-zone:hover .upload-icon,
    .upload-zone.dragover .upload-icon {
        color: var(--primary-color);
        transform: scale(1.1);
    }

    .upload-zone.has-file .upload-icon {
        color: var(--success-color);
    }

    .file-preview {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-top: 1rem;
        display: none;
    }

    .bank-info {
        background: linear-gradient(135deg, var(--primary-color), #0a58ca);
        color: white;
        border-radius: 0.75rem;
        padding: 2rem;
        margin: 1.5rem 0;
        text-align: center;
    }

    .instructions-card {
        background: #f8f9fa;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-top: 1rem;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease;
    }

    .instructions-card.show {
        opacity: 1;
        transform: translateY(0);
    }

    .instruction-step {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 0.75rem 0;
    }

    .step-number {
        width: 32px;
        height: 32px;
        background: var(--primary-color);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        font-weight: 600;
        flex-shrink: 0;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #dee2e6;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .btn-primary {
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 0.5rem 1rem rgba(13, 110, 253, 0.25);
    }

    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s ease;
    }

    .fade-in.show {
        opacity: 1;
        transform: translateY(0);
    }

    @media (max-width: 768px) {
        .main-container {
            padding: 1rem 0;
        }
        
        .amount-display {
            font-size: 1.5rem;
        }
        
        .upload-zone {
            padding: 2rem 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container main-container">
    <!-- Page Header with Breadcrumb -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.users') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.keuangan') }}">Transaksi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pembayaran</li>
                    <div class="ms-auto">
                        <button type="button" class="btn btn-custom btn-pay btn-sm ">
                            <a href="{{ route('users.keuangan') }}" class="text-decoration-none text-white">Kembali</a>
                        </button>
                    </div>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Main Header Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card fade-in">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-start flex-wrap">
                        <div>
                            <h1 class="h3 mb-2 d-flex align-items-center gap-2">
                                <i class="fas fa-receipt"></i>
                                Pembayaran {{ ucfirst($trx->type) }}
                            </h1>
                            <p class="mb-0 opacity-75">{{ $trx->description }}</p>
                        </div>
                        <div class="status-badge mt-2 mt-md-0
                            @if($trx->status === 'Pending') status-pending
                            @elseif($trx->status === 'Verification') status-verification
                            @elseif($trx->status === 'Completed') status-completed
                            @else status-failed
                            @endif">
                            <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                            {{ $trx->status }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Transaction Details -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100 fade-in">
                <div class="card-body">
                    <h3 class="h5 card-title d-flex align-items-center gap-2 mb-4">
                        <i class="fas fa-info-circle text-primary"></i>
                        Detail Transaksi
                    </h3>
                    
                    <div class="transaction-details">
                        <div class="info-row">
                            <span class="fw-medium text-muted">ID Transaksi</span>
                            <code class="badge bg-light text-dark">#{{ $trx->id }}</code>
                        </div>
                        
                        <div class="info-row">
                            <span class="fw-medium text-muted">Tipe</span>
                            <span class="fw-semibold">{{ ucfirst($trx->type) }}</span>
                        </div>

                        <div class="info-row">
                            <span class="fw-medium text-muted">Jumlah</span>
                            <span class="amount-display">Rp {{ number_format($trx->amount, 0, ',', '.') }}</span>
                        </div>

                        <div class="info-row">
                            <span class="fw-medium text-muted">Status</span>
                            <span class="status-badge
                                @if($trx->status === 'Pending') status-pending
                                @elseif($trx->status === 'Verification') status-verification
                                @elseif($trx->status === 'Completed') status-completed
                                @else status-failed
                                @endif">
                                {{ $trx->status }}
                            </span>
                        </div>

                        <div class="info-row">
                            <span class="fw-medium text-muted">Dibuat</span>
                            <span class="fw-semibold">{{ $trx->created_at->format('d/m/Y H:i') }}</span>
                        </div>

                        @if($trx->expires_at)
                        <div class="info-row">
                            <span class="fw-medium text-danger">
                                <i class="fas fa-clock me-1"></i>
                                Batas Waktu
                            </span>
                            <span class="fw-bold text-danger">
                                {{ $trx->expires_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                        @endif
                    </div>

                    @if($trx->status === 'Completed')
                    <div class="alert alert-success mt-3" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-2"></i>
                            <div>
                                <div class="fw-semibold">Pembayaran Berhasil!</div>
                                <small>Transaksi Anda telah diverifikasi dan berhasil.</small>
                            </div>
                        </div>
                    </div>
                    @elseif($trx->status === 'Verification')
                    <div class="alert alert-info mt-3" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-hourglass-half me-2"></i>
                            <div>
                                <div class="fw-semibold">Menunggu Verifikasi</div>
                                <small>Bukti pembayaran sedang diverifikasi oleh admin.</small>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Payment Form -->
        <div class="col-lg-8">
            <div class="card fade-in">
                <div class="card-body">
                    <h3 class="h5 card-title d-flex align-items-center gap-2 mb-4">
                        <i class="fas fa-upload text-primary"></i>
                        Upload Bukti Pembayaran
                    </h3>

                    @if($isDisabled)
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="fas fa-check text-success" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                        <h4 class="h5 mb-2">Pembayaran Telah Selesai</h4>
                        <p class="text-muted">Tidak dapat melakukan perubahan lagi</p>
                    </div>
                    @else
                    <form action="{{ route('transaksi.uploadSinglePaymentProof', $trx->id) }}" 
                          method="POST" 
                          enctype="multipart/form-data" 
                          id="paymentForm"
                          novalidate>
                        @csrf
                        
                        <!-- Payment Method Selection -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold d-flex align-items-center gap-2 mb-3">
                                <i class="fas fa-credit-card text-primary"></i>
                                Pilih Metode Pembayaran <span class="text-danger">*</span>
                            </label>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="payment-method">
                                        <input type="radio" name="payment_method" id="bank_transfer" value="bank_transfer" required>
                                        <label class="payment-method-card" for="bank_transfer">
                                            <i class="fas fa-university payment-icon"></i>
                                            <div class="fw-bold mb-1">Transfer Bank</div>
                                            <small class="text-muted">BCA, BNI, BRI, Mandiri</small>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="payment-method">
                                        <input type="radio" name="payment_method" id="ewallet" value="ewallet" required>
                                        <label class="payment-method-card" for="ewallet">
                                            <i class="fas fa-mobile-alt payment-icon"></i>
                                            <div class="fw-bold mb-1">E-Wallet</div>
                                            <small class="text-muted">DANA, OVO, GoPay</small>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="payment-method">
                                        <input type="radio" name="payment_method" id="cash" value="cash" required>
                                        <label class="payment-method-card" for="cash">
                                            <i class="fas fa-money-bill-wave payment-icon"></i>
                                            <div class="fw-bold mb-1">Tunai</div>
                                            <small class="text-muted">Bayar di kantor</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Instructions (Dynamic) -->
                        <div id="instructionsContainer"></div>

                        <!-- Payment Notes -->
                        <div class="mb-4">
                            <label for="payment_notes" class="form-label fw-semibold d-flex align-items-center gap-2">
                                <i class="fas fa-comment-alt text-primary"></i>
                                Catatan Pembayaran
                            </label>
                            <textarea name="payment_notes" 
                                      id="payment_notes" 
                                      class="form-control @error('payment_notes') is-invalid @enderror" 
                                      rows="4" 
                                      placeholder="Contoh: Transfer dari rekening BCA a.n. John Doe pada tanggal 15/08/2024 pukul 14:30"
                                      maxlength="500">{{ old('payment_notes') }}</textarea>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Berikan detail lengkap untuk mempercepat verifikasi
                            </div>
                            @error('payment_notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- File Upload -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold d-flex align-items-center gap-2">
                                <i class="fas fa-file-upload text-primary"></i>
                                Bukti Pembayaran <span class="text-danger">*</span>
                            </label>
                            <div class="upload-zone" id="uploadArea">
                                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                <h6 class="fw-semibold mb-2">Drag & drop file di sini</h6>
                                <p class="text-muted mb-3">atau klik untuk memilih file</p>
                                <div class="btn btn-outline-primary">
                                    <i class="fas fa-plus me-1"></i>
                                    Pilih File
                                </div>
                                <input type="file" 
                                       name="proof" 
                                       id="proof" 
                                       class="d-none @error('proof') is-invalid @enderror" 
                                       accept=".jpg,.jpeg,.png,.pdf" 
                                       required>
                            </div>
                            <div class="form-text">
                                Format yang didukung: JPG, PNG, PDF • Maksimal 5MB
                            </div>
                            
                            <!-- File Preview -->
                            <div id="filePreview" class="file-preview">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                                        <i class="fas fa-file-alt text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold" id="fileName"></div>
                                        <small class="text-muted" id="fileSize"></small>
                                    </div>
                                    <button type="button" class="btn btn-outline-danger btn-sm" id="removeFile">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                <i class="fas fa-paper-plane me-2"></i>
                                Kirim Bukti Pembayaran
                            </button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>

            <!-- Bank Account Information -->
            @if(!$isDisabled)
            <div class="card mt-4 fade-in">
                <div class="bank-info">
                    <div class="mb-3">
                        <i class="fas fa-university" style="font-size: 3rem; opacity: 0.8;"></i>
                    </div>

                    <h4 class="h5 mb-2">{{ $bank->bank_name }}</h4>
                    <div class="h3 fw-bold mb-2" style="letter-spacing: 2px;">
                        {{ $bank->account_number }}
                    </div>
                    <p class="mb-0 opacity-90">
                        a.n. {{ $bank->account_name }}
                    </p>
                </div>


                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center gap-2 mb-4">
                        <i class="fas fa-lightbulb text-primary"></i>
                        Petunjuk Pembayaran
                    </h5>
                    
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fas fa-university text-primary mb-2" style="font-size: 2rem;"></i>
                                <h6 class="fw-semibold mb-2">Transfer Bank</h6>
                                <small class="text-muted">Transfer dari bank manapun ke rekening Mandiri di atas</small>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fas fa-mobile-alt text-primary mb-2" style="font-size: 2rem;"></i>
                                <h6 class="fw-semibold mb-2">E-Wallet</h6>
                                <small class="text-muted">Gunakan fitur "Transfer ke Bank" di aplikasi e-wallet Anda</small>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fas fa-money-bill-wave text-primary mb-2" style="font-size: 2rem;"></i>
                                <h6 class="fw-semibold mb-2">Tunai</h6>
                                <small class="text-muted">Setor tunai ke rekening atau bayar langsung di kantor</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
   // Ganti seluruh JavaScript di blade dengan kode ini:
    document.addEventListener('DOMContentLoaded', function() {
        const paymentForm = document.getElementById('paymentForm');
        const methodRadios = document.querySelectorAll('input[name="payment_method"]');
        const fileInput = document.getElementById('proof');
        const filePreview = document.getElementById('filePreview');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const removeFileBtn = document.getElementById('removeFile');
        const submitBtn = document.getElementById('submitBtn');
        const uploadArea = document.getElementById('uploadArea');
        const instructionsContainer = document.getElementById('instructionsContainer');

        // Initialize fade-in animations
        const fadeElements = document.querySelectorAll('.fade-in');
        fadeElements.forEach((el, index) => {
            setTimeout(() => {
                el.classList.add('show');
            }, index * 100);
        });

        // Payment method change handler
        methodRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    showPaymentInstructions(this.value);
                }
            });
        });

        // File upload handlers - PERBAIKAN UTAMA
        uploadArea.addEventListener('click', function() {
            fileInput.click();
        });

        // Drag and drop handlers
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, () => {
                uploadArea.classList.add('dragover');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, () => {
                uploadArea.classList.remove('dragover');
            });
        });

        uploadArea.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                // PENTING: Set file ke input file
                fileInput.files = files;
                handleFileSelect(files[0]);
            }
        });

        // File input change handler - DIPERBAIKI
        fileInput.addEventListener('change', function(e) {
            console.log('File input changed:', this.files); // DEBUG
            if (this.files && this.files.length > 0) {
                handleFileSelect(this.files[0]);
            }
        });

        function handleFileSelect(file) {
            console.log('Handling file:', file); // DEBUG
            
            // Validate file type
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
            if (!validTypes.includes(file.type)) {
                showAlert('Format file tidak didukung. Gunakan JPG, PNG, atau PDF.', 'danger');
                fileInput.value = '';
                return;
            }
            
            // Validate file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                showAlert('Ukuran file terlalu besar. Maksimal 5MB.', 'danger');
                fileInput.value = '';
                return;
            }
            
            // Update file info
            if (fileName) fileName.textContent = file.name;
            if (fileSize) fileSize.textContent = formatFileSize(file.size);
            
            // Show file preview
            if (filePreview) filePreview.style.display = 'block';
            
            // Update upload area
            uploadArea.classList.add('has-file');
            uploadArea.innerHTML = `
                <i class="fas fa-check-circle upload-icon text-success"></i>
                <h6 class="fw-semibold mb-2">File berhasil dipilih!</h6>
                <p class="text-muted mb-0">${file.name}</p>
                <small class="text-success">${formatFileSize(file.size)}</small>
            `;
        }

        // Remove file handler
        if (removeFileBtn) {
            removeFileBtn.addEventListener('click', function() {
                fileInput.value = '';
                if (filePreview) filePreview.style.display = 'none';
                
                // Restore upload area
                uploadArea.classList.remove('has-file');
                uploadArea.innerHTML = `
                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                    <h6 class="fw-semibold mb-2">Drag & drop file di sini</h6>
                    <p class="text-muted mb-3">atau klik untuk memilih file</p>
                    <button type="button" class="btn btn-outline-primary">
                        <i class="fas fa-plus me-1"></i>
                        Pilih File
                    </button>
                `;
            });
        }

        // Form submission handler - DIPERBAIKI
        if (paymentForm) {
            paymentForm.addEventListener('submit', function(e) {
                console.log('Form submission started'); // DEBUG
                console.log('File input files:', fileInput.files); // DEBUG
                console.log('File input value:', fileInput.value); // DEBUG
                
                // Validate payment method
                const paymentMethodSelected = document.querySelector('input[name="payment_method"]:checked');
                if (!paymentMethodSelected) {
                    e.preventDefault();
                    showAlert('Silakan pilih metode pembayaran terlebih dahulu.', 'warning');
                    return false;
                }
                
                // Validate file upload
                if (!fileInput.files || fileInput.files.length === 0) {
                    e.preventDefault();
                    showAlert('Silakan upload bukti pembayaran terlebih dahulu.', 'warning');
                    return false;
                }
                
                console.log('All validations passed'); // DEBUG
                
                // Show loading state
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
                submitBtn.disabled = true;
                
                // JANGAN preventDefault() - biarkan form submit normal
                return true;
            });
        }

        // Payment instructions function
        function showPaymentInstructions(method) {
            const instructions = {
                bank_transfer: {
                    title: 'Cara Transfer Bank',
                    icon: 'fas fa-university',
                    steps: [
                        'Buka aplikasi mobile banking atau internet banking Anda',
                        'Pilih menu transfer ke bank lain',
                        'Masukkan nomor rekening Mandiri: <strong>{{ $bank->account_number }}</strong>',
                        'Masukkan nominal: <strong>Rp {{ number_format($trx->amount, 0, ",", ".") }}</strong>',
                        'Konfirmasi dan lakukan transfer',
                        'Simpan bukti transfer dan upload di form ini'
                    ]
                },
                ewallet: {
                    title: 'Cara Bayar via E-Wallet',
                    icon: 'fas fa-mobile-alt',
                    steps: [
                        'Buka aplikasi e-wallet Anda (DANA, OVO, GoPay, ShopeePay)',
                        'Pilih menu "Transfer ke Bank" atau "Kirim Uang"',
                        'Pilih Bank Mandiri dan masukkan nomor: <strong>{{ $bank->account_number }}</strong>',
                        'Masukkan nominal: <strong>Rp {{ number_format($trx->amount, 0, ",", ".") }}</strong>',
                        'Konfirmasi dan lakukan transfer',
                        'Screenshot bukti transfer dan upload di form ini'
                    ]
                },
                cash: {
                    title: 'Cara Bayar Tunai',
                    icon: 'fas fa-money-bill-wave',
                    steps: [
                        'Datang langsung ke kantor kami, atau',
                        'Setor tunai ke rekening Bank Mandiri: <strong>{{ $bank->account_number }}</strong>',
                        'Nominal: <strong>Rp {{ number_format($trx->amount, 0, ",", ".") }}</strong>',
                        'Ambil bukti setor dari teller',
                        'Foto/scan bukti setor dan upload di form ini'
                    ]
                }
            };

            const instruction = instructions[method];
            if (!instruction) return;

            const instructionHTML = `
                <div class="instructions-card" id="paymentInstructions">
                    <h6 class="fw-semibold mb-3 d-flex align-items-center gap-2 text-primary">
                        <i class="${instruction.icon}"></i>
                        ${instruction.title}
                    </h6>
                    <div class="step-list">
                        ${instruction.steps.map((step, index) => `
                            <div class="instruction-step">
                                <div class="step-number">${index + 1}</div>
                                <div class="flex-grow-1">
                                    <small class="text-muted">${step}</small>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;

            if (instructionsContainer) {
                instructionsContainer.innerHTML = instructionHTML;
                
                setTimeout(() => {
                    const instructionsCard = document.getElementById('paymentInstructions');
                    if (instructionsCard) {
                        instructionsCard.classList.add('show');
                    }
                }, 100);
            }
        }

        // Utility functions
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function showAlert(message, type = 'info') {
            // Remove existing alerts
            const existingAlert = document.querySelector('.temp-alert');
            if (existingAlert) {
                existingAlert.remove();
            }
            
            // Create new alert
            const alertClass = `alert-${type}`;
            const iconClass = type === 'danger' || type === 'warning' ? 'exclamation-triangle' : 
                            type === 'success' ? 'check-circle' : 'info-circle';
            
            const alertHTML = `
                <div class="alert ${alertClass} alert-dismissible fade show temp-alert" role="alert">
                    <i class="fas fa-${iconClass} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            
            // Insert at top of form
            const form = document.getElementById('paymentForm');
            if (form) {
                form.insertAdjacentHTML('afterbegin', alertHTML);
                
                // Auto remove after 5 seconds
                setTimeout(() => {
                    const alert = document.querySelector('.temp-alert');
                    if (alert && typeof bootstrap !== 'undefined') {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                }, 5000);
            }
        }
    });
</script>
@endpush
@endsection