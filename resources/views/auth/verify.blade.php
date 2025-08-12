@extends('layouts.app') {{-- Ganti dengan layout yang kamu pakai --}}

@section('title', 'Verifikasi Akun')

@push('styles')
<style>
    /* Custom styles untuk halaman verifikasi */
    .verification-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
        padding: 20px 0;
    }

    .verification-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .verification-card:hover {
        transform: translateY(-5px);
    }

    .card-header-custom {
        background: linear-gradient(135deg, #1976D2 0%, #1565C0 100%);
        border: none;
        padding: 25px 30px;
        position: relative;
        overflow: hidden;
    }

    .card-header-custom::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: shimmer 3s ease-in-out infinite;
    }

    @keyframes shimmer {
        0%, 100% { transform: rotate(0deg); }
        50% { transform: rotate(180deg); }
    }

    .card-header-custom h5 {
        position: relative;
        z-index: 1;
        font-weight: 600;
        font-size: 1.4rem;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .card-header-custom .icon {
        font-size: 2.5rem;
        margin-bottom: 10px;
        display: block;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .card-body-custom {
        padding: 35px 30px;
    }

    /* Custom Alert Styles */
    .alert-custom {
        border: none;
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 25px;
        font-weight: 500;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .alert-success-custom {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .alert-danger-custom {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    .alert-custom ul {
        margin: 0;
        padding-left: 20px;
    }

    /* Email highlight */
    .email-highlight {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        padding: 15px;
        border-radius: 10px;
        border-left: 4px solid #2196f3;
        margin: 20px 0;
        text-align: center;
    }

    .email-highlight strong {
        color: #1976d2;
        font-weight: 600;
    }

    /* OTP Input dengan styling modern */
    .otp-container {
        margin: 25px 0;
    }

    .otp-input {
        background: rgba(248, 249, 250, 0.8);
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 15px 20px;
        font-size: 1.8rem;
        font-weight: 600;
        letter-spacing: 0.5rem;
        text-align: center;
        transition: all 0.3s ease;
        font-family: 'Courier New', monospace;
    }

    .otp-input:focus {
        border-color: #2196F3;
        box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
        background: white;
        transform: scale(1.02);
    }

    .otp-input::placeholder {
        color: #adb5bd;
        font-size: 1.2rem;
        letter-spacing: normal;
    }

    /* Button styles */
    .btn-verify {
        background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
        border: none;
        border-radius: 12px;
        padding: 15px 30px;
        font-weight: 600;
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(33, 150, 243, 0.3);
        position: relative;
        overflow: hidden;
    }

    .btn-verify::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .btn-verify:hover::before {
        left: 100%;
    }

    .btn-verify:hover {
        background: linear-gradient(135deg, #1976D2 0%, #1565C0 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(33, 150, 243, 0.4);
    }

    .btn-verify:active {
        transform: translateY(0);
    }

    .btn-resend {
        background: none;
        border: 2px dashed #6c757d;
        color: #6c757d;
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-resend:hover {
        border-color: #2196F3;
        color: #2196F3;
        background: rgba(33, 150, 243, 0.05);
        text-decoration: none;
        transform: scale(1.05);
    }

    /* Divider custom */
    .custom-divider {
        margin: 30px 0;
        text-align: center;
        position: relative;
    }

    .custom-divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, #dee2e6, transparent);
    }

    .custom-divider span {
        background: white;
        padding: 0 20px;
        color: #6c757d;
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Loading animation */
    .loading {
        opacity: 0.7;
        pointer-events: none;
    }

    .loading .btn-verify {
        background: #6c757d;
        cursor: not-allowed;
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        .verification-container {
            padding: 15px;
        }
        
        .card-body-custom {
            padding: 25px 20px;
        }
        
        .otp-input {
            font-size: 1.5rem;
            padding: 12px 15px;
            letter-spacing: 0.3rem;
        }
        
        .btn-verify {
            padding: 12px 25px;
            font-size: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="verification-container">
    <div class="container" style="max-width: 500px;">
        <div class="card verification-card shadow-lg">
            <div class="card-header card-header-custom text-white text-center">
                <span class="icon">🔐</span>
                <h5>Verifikasi Akun Anda</h5>
            </div>
            
            <div class="card-body card-body-custom">
                @if(session('success'))
                    <div class="alert alert-success-custom alert-custom">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger-custom alert-custom">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="text-center mb-4">
                    <p class="mb-2" style="color: #495057; font-size: 1.1rem;">
                        Kami telah mengirimkan kode verifikasi ke:
                    </p>
                    <div class="email-highlight">
                        <i class="fas fa-envelope me-2"></i>
                        <strong>{{ $email }}</strong>
                    </div>
                </div>
                
                <p class="text-center mb-4" style="color: #6c757d;">
                    Masukkan kode <strong>6 digit</strong> di bawah ini untuk mengaktifkan akun Anda.
                </p>
                
                <form action="{{ route('verifyOtp.process') }}" method="POST" id="otpForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    
                    <div class="otp-container">
                        <label for="verification_code" class="form-label fw-semibold" style="color: #495057;">
                            <i class="fas fa-key me-2"></i>Kode Verifikasi
                        </label>
                        <input 
                            type="text" 
                            name="verification_code" 
                            id="verification_code" 
                            class="form-control otp-input" 
                            maxlength="6" 
                            placeholder="000000"
                            required
                            autocomplete="off"
                            inputmode="numeric"
                            pattern="[0-9]{6}"
                        >
                        <small class="form-text text-muted mt-2">
                            <i class="fas fa-info-circle me-1"></i>
                            Masukkan 6 digit angka yang diterima via email
                        </small>
                    </div>
                    
                    <button type="submit" class="btn btn-verify w-100 mb-3">
                        <i class="fas fa-shield-alt me-2"></i>
                        Verifikasi Sekarang
                    </button>
                </form>
                
                <div class="custom-divider">
                    <span>Tidak menerima kode?</span>
                </div>
                
                <div class="text-center">
                    <form action="{{ route('resendOtp') }}" encriptype="multipart/form-data" method="POST" style="display: inline;">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <button type="submit" class="btn btn-resend">
                            <i class="fas fa-redo me-2"></i>
                            Kirim Ulang Kode
                        </button>
                    </form>
                </div>
                
                <div class="text-center mt-4">
                    <small class="text-muted">
                        <i class="fas fa-clock me-1"></i>
                        Kode akan kedaluwarsa dalam <strong>10 menit</strong>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const otpInput = document.getElementById('verification_code');
        const form = document.getElementById('otpForm');
        
        // Auto-submit saat 6 digit terisi
        otpInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, ''); // Hanya angka
            if (this.value.length === 6) {
                // Auto submit setelah delay singkat
                setTimeout(() => {
                    form.classList.add('loading');
                    form.submit();
                }, 500);
            }
        });
        
        // Prevent form submission jika kurang dari 6 digit
        form.addEventListener('submit', function(e) {
            if (otpInput.value.length !== 6) {
                e.preventDefault();
                otpInput.focus();
                otpInput.classList.add('is-invalid');
                setTimeout(() => {
                    otpInput.classList.remove('is-invalid');
                }, 2000);
            } else {
                form.classList.add('loading');
            }
        });
        
        // Focus pada input saat halaman dimuat
        otpInput.focus();
    });
</script>
@endsection