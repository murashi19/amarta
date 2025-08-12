@extends('layouts.dashboard')

@section('title', 'Pembayaran Booking - LPK Amarta Bangun Indonesia')

@section('meta')
<meta name="description" content="Halaman pembayaran booking kelas LPK Amarta Bangun Indonesia. Upload bukti pembayaran dan konfirmasi booking Anda dengan mudah.">
<meta name="keywords" content="pembayaran, booking, kelas, LPK Amarta, transfer bank, bukti pembayaran">
<meta name="robots" content="noindex, nofollow">
<meta property="og:title" content="Pembayaran Booking - LPK Amarta Bangun Indonesia">
<meta property="og:description" content="Selesaikan pembayaran booking kelas Anda dengan mudah dan aman">
<meta property="og:type" content="website">
@endsection

@section('content')
@push('styles')
    <style>
        .payment-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .payment-card {
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            border-radius: 20px;
            overflow: hidden;
        }
        
        .payment-header {
            background: linear-gradient(90deg, #0d5ea6, #0d5ea6, #1e88e5);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .payment-step {
            background: rgba(255,255,255,0.2);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            display: inline-block;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }
        
        .amount-display {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 15px;
            text-align: center;
            margin: 1.5rem 0;
        }
        
        .bank-info {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1.5rem;
            border-left: 5px solid #007bff;
        }
        
        .upload-zone {
            border: 2px dashed #dee2e6;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            background: #fdfdfe;
        }
        
        .upload-zone:hover {
            border-color: #007bff;
            background: #f8f9ff;
        }
        
        .upload-zone.dragover {
            border-color: #28a745;
            background: #f8fff9;
        }
        
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-paid {
            background: #d4edda;
            color: #155724;
        }
        
        .proof-preview {
            max-width: 200px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .btn-modern {
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-upload {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-upload:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
            color: white;
        }
        
        .info-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #eee;
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .info-icon {
            width: 40px;
            height: 40px;
            background: #e3f2fd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: #1976d2;
        }
        
        .progress-indicator {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            margin: 2rem 0;
        }
        
        .step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            position: relative;
        }
        
        .step.active {
            background: #007bff;
            color: white;
        }
        
        .step.completed {
            background: #28a745;
            color: white;
        }
        
        .step.pending {
            background: #e9ecef;
            color: #6c757d;
        }
        
        .step-connector {
            width: 60px;
            height: 2px;
            background: #e9ecef;
        }
        
        .step-connector.completed {
            background: #28a745;
        }
        
        @media (max-width: 768px) {
        /* Container dan Layout Utama */
        .container-fluid {
            padding: 1rem 0.5rem;
        }
        
        .payment-container {
            margin: 0 0.5rem;
        }
        
        /* Header Pembayaran */
        .payment-header {
            padding: 1.5rem 1rem;
            text-align: center;
        }
        
        .payment-header h3 {
            font-size: 1.25rem;
            line-height: 1.4;
        }
        
        .payment-header p {
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
        
        .payment-step {
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
        }
        
        /* Progress Indicator - Vertikal untuk mobile */
        .progress-indicator {
            flex-direction: column;
            gap: 0.5rem;
            margin: 1.5rem 0;
        }
        
        .step {
            width: 35px;
            height: 35px;
            font-size: 0.875rem;
        }
        
        .step-connector {
            width: 2px;
            height: 25px;
            margin: 0;
        }
        
        /* Card Body */
        .card-body {
            padding: 1.5rem 1rem;
        }
        
        /* Info Items */
        .info-item {
            padding: 0.5rem 0;
            flex-direction: column;
            text-align: center;
            margin-bottom: 1rem;
        }
        
        .info-icon {
            width: 35px;
            height: 35px;
            margin: 0 0 0.5rem 0;
        }
        
        /* Amount Display */
        .amount-display {
            padding: 1.25rem 1rem;
            margin: 1rem 0;
        }
        
        .amount-display h6 {
            font-size: 0.9rem;
        }
        
        .amount-display h2 {
            font-size: 1.5rem;
            word-break: break-word;
        }
        
        /* Status Badge */
        .status-badge {
            font-size: 0.875rem;
            padding: 0.4rem 0.8rem;
            display: block;
            text-align: center;
            margin: 1rem 0;
        }
        
        /* Bank Information */
        .bank-info {
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .bank-info h6 {
            font-size: 1rem;
            margin-bottom: 1rem;
        }
        
        .bank-info .row .col-md-4 {
            margin-bottom: 1rem;
            text-align: center;
            padding: 0.5rem;
            background: white;
            border-radius: 8px;
            margin-bottom: 0.5rem;
        }
        
        .bank-info .h6 {
            font-size: 0.95rem;
            word-break: break-all;
        }
        
        /* Alert dalam Bank Info */
        .bank-info .alert {
            margin-top: 1rem;
            padding: 0.75rem;
            font-size: 0.8rem;
        }
        
        /* Upload Section */
        .upload-zone {
            padding: 1.5rem 1rem;
            margin-bottom: 1rem;
        }
        
        .upload-zone .fa-3x {
            font-size: 2rem;
        }
        
        .upload-zone h6 {
            font-size: 1rem;
            margin-bottom: 1rem;
        }
        
        .upload-zone p {
            font-size: 0.8rem;
            margin-bottom: 1rem;
        }
        
        /* Selected File Preview */
        .selected-file {
            padding: 0.75rem;
            font-size: 0.875rem;
            word-break: break-word;
        }
        
        /* Proof Preview */
        .proof-preview {
            max-width: 150px;
            margin-bottom: 1rem;
        }
        
        /* Buttons */
        .btn-modern {
            padding: 0.65rem 1.25rem;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            width: 100%;
            max-width: 280px;
        }
        
        .btn-upload {
            font-size: 0.9rem;
            padding: 0.75rem 1.5rem;
        }
        
        /* Action Buttons Container */
        .text-center .btn-modern {
            display: block;
            margin: 0.5rem auto;
            width: 100%;
            max-width: 250px;
        }
        
        /* Alert Boxes */
        .alert {
            padding: 0.75rem;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }
        
        .alert strong {
            display: block;
            margin-bottom: 0.25rem;
        }
        
        /* Countdown Alert */
        .alert-warning {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        #countdown {
            font-size: 1.1rem;
            font-weight: bold;
            color: #dc3545;
            display: block;
            margin-top: 0.5rem;
        }
        
        /* Modal Responsiveness */
        .modal-dialog {
            margin: 0.5rem;
            max-width: calc(100% - 1rem);
        }
        
        .modal-body {
            padding: 1rem;
        }
        
        .modal-body h6 {
            font-size: 0.95rem;
            margin-bottom: 0.75rem;
        }
        
        .modal-body ol {
            font-size: 0.8rem;
            padding-left: 1.25rem;
        }
        
        .modal-body ol li {
            margin-bottom: 0.25rem;
            line-height: 1.4;
        }
        
        .modal-body .col-md-6 {
            margin-bottom: 1.5rem;
        }
        
        /* Copy Button */
        .btn-link {
            font-size: 0.8rem;
            padding: 0.25rem;
        }
        
        /* Spacing Adjustments */
        hr {
            margin: 1.5rem 0;
        }
        
        .mb-4 {
            margin-bottom: 1.5rem !important;
        }
        
        .mb-3 {
            margin-bottom: 1rem !important;
        }
        
        /* Text Adjustments */
        .text-muted {
            font-size: 0.8rem;
        }
        
        strong, .fw-bold {
            font-size: 0.9rem;
        }
        
        /* Fix untuk row dalam bank info */
        .bank-info .row {
            margin: 0 -0.25rem;
        }
        
        .bank-info .row [class*="col-"] {
            padding: 0 0.25rem;
        }
        
        /* Toast notification position */
        .alert.position-fixed {
            top: 10px !important;
            right: 10px !important;
            left: 10px !important;
            right: auto;
            font-size: 0.875rem;
            z-index: 9999;
        }
        
        /* Perbaikan untuk file preview */
        #filePreview {
            margin-top: 1rem;
        }
        
        /* Perbaikan untuk border dan spacing */
        .border-top {
            padding-top: 1rem !important;
            margin-top: 1rem;
        }
        
        /* Success alert untuk bukti upload */
        .alert-success {
            text-align: center;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        /* Button grup dalam preview */
        .proof-preview + div {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            align-items: center;
        }
        
        .proof-preview + div .btn {
            width: 100%;
            max-width: 200px;
        }
    }
    </style>
@endpush
<div class="container-fluid py-4">
    <div class="payment-container">
        <!-- Progress Indicator -->
        <div class="progress-indicator">
            <div class="step completed">
                <i class="fas fa-check"></i>
            </div>
            <div class="step-connector completed"></div>
            <div class="step active">2</div>
            <div class="step-connector"></div>
            <div class="step pending">3</div>
        </div>
        
        <div class="row g-0">
            <div class="col-12">
                <div class="payment-card card">
                    <!-- Header -->
                    <div class="payment-header">
                        <div class="payment-step">
                            <i class="fas fa-credit-card me-2"></i>
                            Langkah 2 dari 3
                        </div>
                        <h3 class="mb-0">
                            <i class="fas fa-receipt me-2"></i>
                            Pembayaran Booking Kelas
                        </h3>
                        <p class="mb-0 mt-2 opacity-90">Selesaikan pembayaran untuk mengkonfirmasi booking Anda</p>
                    </div>

                    <div class="card-body p-4">
                        @php
                            use App\Models\FeePayment;

                            $latestProof = FeePayment::where('transaction_id', $transaction->id)
                                ->whereNotNull('photo')
                                ->latest()
                                ->first();
                        @endphp

                        @if ($transaction->expires_at)
                            @php
                                $expiresAt = \Carbon\Carbon::parse($transaction->expires_at);
                                $now = \Carbon\Carbon::now();
                                $remainingSeconds = $expiresAt->gt($now) ? $expiresAt->diffInSeconds($now) : 0;
                            @endphp

                            <div class="alert alert-warning">
                                <strong>Batas Waktu Pembayaran:</strong> {{ $transaction->expires_at->format('d-m-Y H:i') }}<br>
                                <strong>Sisa Waktu:</strong>
                                <span id="countdown"></span>
                            </div>
                        @endif
                        <!-- User Info & Amount -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Nama Peserta</small>
                                        <strong>{{ Auth::user()->name }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Tanggal Transaksi</small>
                                        <strong>{{ $transaction->created_at->format('d M Y, H:i') }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Amount Display -->
                        <div class="amount-display">
                            <h6 class="mb-2 opacity-90">Total Pembayaran</h6>
                            <h2 class="mb-0 fw-bold">Rp{{ number_format($transaction->amount, 0, ',', '.') }}</h2>
                        </div>

                        <!-- Status -->
                        <div class="text-center mb-4">
                            @if($transaction->status === 'Completed')
                                <span class="status-badge status-paid">
                                    <i class="fas fa-check-circle"></i> Pembayaran Berhasil
                                </span>
                            @elseif($transaction->status === 'Verification')
                                <span class="status-badge status-pending">
                                    <i class="fas fa-clock"></i> Menunggu Verifikasi
                                </span>
                            @else
                                <span class="status-badge status-pending">
                                    <i class="fas fa-exclamation-circle"></i> Menunggu Pembayaran
                                </span>
                            @endif

                        </div>

                        <hr class="my-4">

                        <!-- Bank Information -->
                        <div class="bank-info mb-4">
                            <h6 class="mb-3">
                                <i class="fas fa-university text-primary me-2"></i>
                                Informasi Transfer
                            </h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <small class="text-muted d-block">Bank</small>
                                    <strong class="h6 mb-0">BCA</strong>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <small class="text-muted d-block">No. Rekening</small>
                                    <strong class="h6 mb-0">1234567890</strong>
                                    <button class="btn btn-link btn-sm p-0 ms-2" onclick="copyToClipboard('1234567890')" title="Salin nomor rekening">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <small class="text-muted d-block">Atas Nama</small>
                                    <strong class="h6 mb-0">LPK Amarta Bangun Indonesia</strong>
                                </div>
                            </div>
                            
                            <div class="alert alert-info mt-3" role="alert">
                                <i class="fas fa-info-circle me-2"></i>
                                <small>
                                    <strong>Penting:</strong> Pastikan nominal transfer sesuai dengan jumlah yang tertera dan simpan bukti transfer untuk diunggah.
                                </small>
                            </div>
                        </div>

                        <!-- Upload Section -->
                        <div class="mb-4">
                            <h6 class="mb-3">
                                <i class="fas fa-upload text-primary me-2"></i>
                                Upload Bukti Pembayaran
                            </h6>

                            @if($latestProof && $latestProof->photo)
                                <div class="text-center">
                                    <div class="alert alert-success" role="alert">
                                        <i class="fas fa-check-circle me-2"></i>
                                        Bukti pembayaran sudah diunggah. Menunggu verifikasi dari admin.
                                    </div>

                                    <img src="{{ asset('storage/' . $latestProof->photo) }}" alt="Bukti Pembayaran" class="proof-preview mb-3">

                                    <div>
                                        <a href="{{ asset('storage/' . $latestProof->photo) }}" target="_blank" class="btn btn-outline-primary btn-modern me-2">
                                            <i class="fas fa-eye me-2"></i>Lihat Bukti
                                        </a>
                                        <a href="{{ asset('storage/' . $latestProof->photo) }}" download class="btn btn-outline-secondary btn-modern">
                                            <i class="fas fa-download me-2"></i>Download
                                        </a>
                                    </div>
                                </div>
                            @else
                                <form action="{{ route('transaksi.booking.upload', $transaction->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="upload-zone" id="uploadZone">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                        <h6 class="mb-3">Drag & Drop atau Klik untuk Upload</h6>
                                        <p class="text-muted mb-3">Format: JPG, PNG, PDF (Max: 5MB)</p>

                                        <input type="file" name="proof" class="form-control d-none" id="fileInput" accept="image/*,.pdf" required>

                                        <button type="button" class="btn btn-outline-primary btn-modern" onclick="document.getElementById('fileInput').click()">
                                            <i class="fas fa-folder-open me-2"></i>Pilih File
                                        </button>

                                        <div id="filePreview" class="mt-3 d-none">
                                            <div class="selected-file p-3 bg-light rounded">
                                                <i class="fas fa-file-image me-2"></i>
                                                <span id="fileName"></span>
                                                <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="removeFile()">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-upload btn-modern btn-lg" id="uploadBtn" disabled>
                                            <i class="fas fa-upload me-2"></i>Upload Bukti Pembayaran
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="text-center pt-3 border-top">
                            <a href="{{ route('dashboard.users') }}" class="btn btn-outline-secondary btn-modern">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                            </a>
                            
                            @if(!$latestProof || !$latestProof->photo)
                                <button class="btn btn-outline-info btn-modern ms-2" data-bs-toggle="modal" data-bs-target="#helpModal">
                                    <i class="fas fa-question-circle me-2"></i>Butuh Bantuan?
                                </button>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Help Modal -->
<div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="helpModalLabel">
                    <i class="fas fa-question-circle text-info me-2"></i>
                    Panduan Pembayaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-mobile-alt text-primary me-2"></i>Melalui Mobile Banking:</h6>
                        <ol class="small">
                            <li>Buka aplikasi mobile banking</li>
                            <li>Pilih menu Transfer</li>
                            <li>Masukkan nomor rekening: <strong>1234567890</strong></li>
                            <li>Pastikan nama penerima: <strong>LPK Amarta Bangun Indonesia</strong></li>
                            <li>Masukkan nominal: <strong>Rp{{ number_format($transaction->amount, 0, ',', '.') }}</strong></li>
                            <li>Screenshot bukti transfer</li>
                        </ol>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-building text-primary me-2"></i>Melalui ATM:</h6>
                        <ol class="small">
                            <li>Masukkan kartu ATM dan PIN</li>
                            <li>Pilih Transfer > Antar Bank</li>
                            <li>Pilih Bank BCA</li>
                            <li>Masukkan nomor rekening: <strong>1234567890</strong></li>
                            <li>Masukkan nominal: <strong>Rp{{ number_format($transaction->amount, 0, ',', '.') }}</strong></li>
                            <li>Foto struk sebagai bukti</li>
                        </ol>
                    </div>
                </div>
                
                <div class="alert alert-warning mt-3">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <small><strong>Catatan:</strong> Upload bukti pembayaran dalam format JPG, PNG, atau PDF dengan ukuran maksimal 5MB.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        // Perbaikan JavaScript untuk Upload File
        document.addEventListener('DOMContentLoaded', function() {
            const uploadZone = document.getElementById('uploadZone');
            const fileInput = document.getElementById('fileInput');
            const filePreview = document.getElementById('filePreview');
            const fileName = document.getElementById('fileName');
            const uploadBtn = document.getElementById('uploadBtn');
            const uploadForm = document.getElementById('uploadForm');

            // Pastikan semua element ada
            if (!uploadZone || !fileInput || !filePreview || !fileName || !uploadBtn) {
                console.error('Upload elements not found');
                return;
            }

            // Click to upload - perbaikan event handling
            uploadZone.addEventListener('click', function(e) {
                // Cegah event bubbling dan pastikan tidak mengklik button atau input yang sudah ada
                if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'BUTTON') {
                    e.preventDefault();
                    fileInput.click();
                }
            });

            // Drag and drop functionality - diperbaiki
            uploadZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                uploadZone.classList.add('dragover');
            });

            uploadZone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                // Hanya remove class jika benar-benar keluar dari zone
                if (!uploadZone.contains(e.relatedTarget)) {
                    uploadZone.classList.remove('dragover');
                }
            });

            uploadZone.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                uploadZone.classList.remove('dragover');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    // Set file ke input
                    const dt = new DataTransfer();
                    dt.items.add(files[0]);
                    fileInput.files = dt.files;
                    
                    // Trigger change event
                    fileInput.dispatchEvent(new Event('change', { bubbles: true }));
                }
            });

            // File input change - diperbaiki
            fileInput.addEventListener('change', function(e) {
                handleFileSelect(e.target.files[0]);
            });

            // Button untuk pilih file
            const selectFileBtn = uploadZone.querySelector('button[onclick*="fileInput"]');
            if (selectFileBtn) {
                selectFileBtn.removeAttribute('onclick');
                selectFileBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    fileInput.click();
                });
            }

            function handleFileSelect(file) {
                if (!file) {
                    resetFileSelection();
                    return;
                }

                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
                const fileType = file.type.toLowerCase();
                
                if (!allowedTypes.includes(fileType)) {
                    showAlert('Format file tidak didukung. Gunakan JPG, PNG, atau PDF.', 'danger');
                    resetFileSelection();
                    return;
                }

                // Validate file size (5MB)
                const maxSize = 5 * 1024 * 1024; // 5MB in bytes
                if (file.size > maxSize) {
                    showAlert('Ukuran file terlalu besar. Maksimal 5MB.', 'danger');
                    resetFileSelection();
                    return;
                }

                // Show file info
                fileName.textContent = file.name + ' (' + formatFileSize(file.size) + ')';
                filePreview.classList.remove('d-none');
                uploadBtn.disabled = false;
                
                // Show preview if it's an image
                showImagePreview(file);
                
                showAlert('File berhasil dipilih: ' + file.name, 'success');
            }

            function resetFileSelection() {
                fileInput.value = '';
                filePreview.classList.add('d-none');
                uploadBtn.disabled = true;
                removeImagePreview();
            }

            function showImagePreview(file) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        let existingPreview = filePreview.querySelector('.image-preview');
                        if (existingPreview) {
                            existingPreview.remove();
                        }
                        
                        const imagePreview = document.createElement('div');
                        imagePreview.className = 'image-preview mt-2';
                        imagePreview.innerHTML = `
                            <img src="${e.target.result}" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        `;
                        filePreview.appendChild(imagePreview);
                    };
                    reader.readAsDataURL(file);
                }
            }

            function removeImagePreview() {
                const existingPreview = filePreview.querySelector('.image-preview');
                if (existingPreview) {
                    existingPreview.remove();
                }
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            function showAlert(message, type = 'info') {
                // Remove existing alerts
                const existingAlerts = document.querySelectorAll('.upload-alert');
                existingAlerts.forEach(alert => alert.remove());
                
                // Create new alert
                const alert = document.createElement('div');
                alert.className = `alert alert-${type} alert-dismissible fade show upload-alert`;
                alert.style.position = 'fixed';
                alert.style.top = '20px';
                alert.style.right = '20px';
                alert.style.zIndex = '9999';
                alert.style.minWidth = '300px';
                alert.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
                `;
                
                document.body.appendChild(alert);
                
                // Auto remove after 5 seconds
                setTimeout(function() {
                    if (alert.parentElement) {
                        alert.remove();
                    }
                }, 5000);
            }

            // Remove file function - diperbaiki
            window.removeFile = function() {
                resetFileSelection();
            }

            // Form submission handling - diperbaiki
            if (uploadForm) {
                uploadForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    if (!fileInput.files || fileInput.files.length === 0) {
                        showAlert('Silakan pilih file terlebih dahulu.', 'warning');
                        return;
                    }

                    // Disable button dan show loading
                    uploadBtn.disabled = true;
                    const originalText = uploadBtn.innerHTML;
                    uploadBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengupload...';

                    // Create FormData
                    const formData = new FormData(uploadForm); // langsung ambil dari form
                    formData.set('proof', fileInput.files[0]); // pastikan field proof
                    formData.append('_method', 'PUT'); // karena pakai method PUT

                    fetch(uploadForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json', // penting supaya Laravel kirim JSON
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showAlert(data.message || 'Bukti pembayaran berhasil diupload!', 'success');
                            setTimeout(() => window.location.reload(), 1500);
                        } else {
                            showAlert(data.message || 'Upload gagal.', 'danger');
                            uploadBtn.disabled = false;
                            uploadBtn.innerHTML = originalText;
                        }
                    })
                    .catch(error => {
                        console.error('Upload error:', error);
                        showAlert('Gagal mengupload file: ' + error.message, 'danger');
                        uploadBtn.disabled = false;
                        uploadBtn.innerHTML = originalText;
                    });
                });
            }

            // Copy to clipboard function - diperbaiki
            window.copyToClipboard = function(text) {
                // Fallback untuk browser lama
                if (!navigator.clipboard) {
                    const textArea = document.createElement('textarea');
                    textArea.value = text;
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    try {
                        document.execCommand('copy');
                        showAlert('Nomor rekening berhasil disalin!', 'success');
                    } catch (err) {
                        showAlert('Gagal menyalin nomor rekening', 'danger');
                    }
                    document.body.removeChild(textArea);
                    return;
                }

                navigator.clipboard.writeText(text).then(function() {
                    showAlert('Nomor rekening berhasil disalin!', 'success');
                }).catch(function(err) {
                    showAlert('Gagal menyalin nomor rekening', 'danger');
                });
            }

            // Countdown function - diperbaiki
            const countdownElement = document.getElementById('countdown');
            if (countdownElement) {
                let remaining = parseInt(countdownElement.dataset.remaining) || 0;
                
                function updateCountdown() {
                    if (remaining <= 0) {
                        countdownElement.innerHTML = '<span class="text-danger fw-bold">Waktu habis</span>';
                        
                        // Disable upload form jika waktu habis
                        if (uploadForm) {
                            const formElements = uploadForm.querySelectorAll('input, button');
                            formElements.forEach(el => el.disabled = true);
                            uploadForm.style.opacity = '0.5';
                        }
                        
                        showAlert('Waktu pembayaran telah habis. Silakan buat transaksi baru.', 'danger');
                        return;
                    }

                    let hours = Math.floor(remaining / 3600);
                    let minutes = Math.floor((remaining % 3600) / 60);
                    let seconds = remaining % 60;

                    countdownElement.innerHTML = 
                        String(hours).padStart(2, '0') + ':' +
                        String(minutes).padStart(2, '0') + ':' +
                        String(seconds).padStart(2, '0');

                    remaining--;
                    setTimeout(updateCountdown, 1000);
                }

                updateCountdown();
            }
        });

        // Additional CSS untuk alert yang dinamis
        const additionalCSS = `
        <style>
        .upload-alert {
            max-width: 400px;
            word-wrap: break-word;
        }

        .image-preview img {
            transition: transform 0.2s ease;
        }

        .image-preview img:hover {
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .upload-alert {
                right: 10px !important;
                left: 10px !important;
                right: auto;
                max-width: calc(100vw - 20px);
            }
        }
        </style>
        `;

        // Inject additional CSS
        document.head.insertAdjacentHTML('beforeend', additionalCSS);
    </script>
@endpush
@endsection
