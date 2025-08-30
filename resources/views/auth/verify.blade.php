@extends('layouts.app')

@section('title', 'Verifikasi Akun')

@push('styles')
<style>
    /* Custom Color Variables */
    :root {
        --color-primary: #0d5ea6;
        --color-secondary: #a6550d;
        --color-success: #24c224;
        --color-warning: #e2b11e;
        --color-danger: #ac2020;
        --color-info: #297ba3;
        --color-light: #eff2f6;
        --color-dark: #162737;
        --color-hover: #d6eafe;
        --color-disabletxt: #9e9e9e;
        --gradient-primary: linear-gradient(135deg, #0d5ea6 0%, #1e7bb8 100%);
        --gradient-light: linear-gradient(135deg, #d6eafe 0%, #e8f4fd 100%);
        --shadow-soft: 0 10px 40px rgba(13, 94, 166, 0.1);
        --shadow-hover: 0 20px 60px rgba(13, 94, 166, 0.2);
    }

    /* Reset dan Base Styles */
    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        line-height: 1.6;
    }

    /* Desktop First - Main Container */
    .verification-wrapper {
        min-height: 100vh;
        background: var(--gradient-primary);
        position: relative;
        overflow: hidden;
    }

    /* Animated Background Elements */
    .verification-wrapper::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="20" cy="20" r="1" fill="%23ffffff" fill-opacity="0.05"/><circle cx="80" cy="40" r="1" fill="%23ffffff" fill-opacity="0.03"/><circle cx="40" cy="80" r="1" fill="%23ffffff" fill-opacity="0.04"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        animation: float 20s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(1deg); }
    }

    /* Desktop Layout - Two Column */
    .verification-container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        padding: 20px;
        position: relative;
        z-index: 1;
    }

    .verification-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        max-width: 1200px;
        width: 100%;
        gap: 60px;
        align-items: center;
    }

    /* Left Side - Welcome Section (Desktop Only) */
    .welcome-section {
        color: white;
        padding: 40px;
        text-align: left;
    }

    .welcome-section h1 {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 24px;
        line-height: 1.2;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .welcome-section p {
        font-size: 1.3rem;
        margin-bottom: 32px;
        opacity: 0.9;
        line-height: 1.6;
    }

    .feature-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .feature-list li {
        display: flex;
        align-items: center;
        margin-bottom: 16px;
        font-size: 1.1rem;
        opacity: 0.85;
    }

    .feature-list li::before {
        content: '✨';
        margin-right: 12px;
        font-size: 1.2rem;
    }

    /* Right Side - Verification Card */
    .verification-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 24px;
        box-shadow: var(--shadow-soft);
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .verification-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
        background-size: 200% 100%;
        animation: shimmer 2s linear infinite;
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    .verification-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
    }

    /* Card Header */
    .card-header-custom {
        background: var(--gradient-primary);
        border: none;
        padding: 40px 40px 32px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .card-header-custom::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: rotate 6s linear infinite;
    }

    @keyframes rotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .card-header-custom .icon {
        font-size: 4rem;
        margin-bottom: 16px;
        display: block;
        position: relative;
        z-index: 1;
        animation: bounce 2s ease-in-out infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .card-header-custom h2 {
        position: relative;
        z-index: 1;
        font-weight: 700;
        font-size: 2rem;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        color: white;
    }

    /* Card Body */
    .card-body-custom {
        padding: 40px;
    }

    /* Alert Styles */
    .alert-custom {
        border: none;
        border-radius: 16px;
        padding: 20px 24px;
        margin-bottom: 32px;
        font-weight: 500;
        box-shadow: var(--shadow-soft);
        position: relative;
        overflow: hidden;
    }

    .alert-custom::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: currentColor;
    }

    .alert-success-custom {
        background: linear-gradient(135deg, #e7f5e7 0%, #c8e6c9 100%);
        color: var(--color-success);
        border-left: 4px solid var(--color-success);
    }

    .alert-danger-custom {
        background: linear-gradient(135deg, #fce4e4 0%, #ffcdd2 100%);
        color: var(--color-danger);
        border-left: 4px solid var(--color-danger);
    }

    /* Email Highlight */
    .email-highlight {
        background: var(--gradient-light);
        padding: 24px;
        border-radius: 16px;
        margin: 24px 0;
        text-align: center;
        border: 1px solid rgba(13, 94, 166, 0.2);
        position: relative;
        overflow: hidden;
    }

    .email-highlight::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        animation: slide 3s ease-in-out infinite;
    }

    @keyframes slide {
        0% { left: -100%; }
        50% { left: 100%; }
        100% { left: 100%; }
    }

    .email-highlight strong {
        color: white;
        font-weight: 700;
        font-size: 1.1rem;
        position: relative;
        z-index: 1;
    }

    /* OTP Input */
    .otp-container {
        margin: 32px 0;
    }

    .otp-input {
        background: rgba(248, 249, 250, 0.8);
        border: 2px solid #e9ecef;
        border-radius: 16px;
        padding: 20px 24px;
        font-size: 2.2rem;
        font-weight: 700;
        letter-spacing: 0.8rem;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: 'SF Mono', 'Monaco', 'Cascadia Code', monospace;
        width: 100%;
    }

    .otp-input:focus {
        border-color: var(--color-primary);
        box-shadow: 
            0 0 0 4px rgba(13, 94, 166, 0.15),
            var(--shadow-soft);
        background: white;
        transform: scale(1.02);
        outline: none;
    }

    .otp-input::placeholder {
        color: var(--color-disabletxt);
        font-size: 1.6rem;
        letter-spacing: 0.4rem;
    }

    /* Buttons */
    .btn-verify {
        background: var(--gradient-primary);
        border: none;
        border-radius: 16px;
        padding: 20px 32px;
        font-weight: 700;
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: var(--shadow-soft);
        position: relative;
        overflow: hidden;
        color: white;
    }

    .btn-verify::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.6s;
    }

    .btn-verify:hover::before {
        left: 100%;
    }

    .btn-verify:hover {
        background: linear-gradient(135deg, #1e7bb8 0%, #0d5ea6 100%);
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
    }

    .btn-verify:active {
        transform: translateY(-1px);
    }

    .btn-resend {
        background: none;
        border: 2px dashed var(--color-disabletxt);
        color: var(--color-disabletxt);
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-resend:hover {
        border-color: var(--color-primary);
        color: var(--color-primary);
        background: var(--color-hover);
        text-decoration: none;
        transform: scale(1.05);
    }

    /* Divider */
    .custom-divider {
        margin: 40px 0;
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
        background: rgba(255, 255, 255, 0.98);
        padding: 0 24px;
        color: var(--color-disabletxt);
        font-size: 0.95rem;
        font-weight: 500;
    }

    /* Loading State */
    .loading {
        opacity: 0.7;
        pointer-events: none;
    }

    .loading .btn-verify {
        background: var(--color-disabletxt);
        cursor: not-allowed;
    }

    /* Tablet Styles */
    @media (max-width: 1024px) {
        .verification-content {
            grid-template-columns: 1fr;
            gap: 40px;
            max-width: 600px;
        }

        .welcome-section {
            text-align: center;
            padding: 20px;
        }

        .welcome-section h1 {
            font-size: 2.5rem;
        }

        .welcome-section p {
            font-size: 1.1rem;
        }

        .feature-list {
            display: none;
        }
    }

    /* Mobile Styles */
    @media (max-width: 768px) {
        .verification-wrapper {
            background: var(--gradient-primary);
        }

        .verification-container {
            padding: 20px 15px;
            min-height: 100vh;
        }

        .verification-content {
            gap: 30px;
        }

        .welcome-section h1 {
            font-size: 2rem;
            margin-bottom: 16px;
        }

        .welcome-section p {
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .verification-card {
            border-radius: 20px;
            margin: 0;
        }

        .card-header-custom {
            padding: 30px 20px 24px;
        }

        .card-header-custom .icon {
            font-size: 3rem;
            margin-bottom: 12px;
        }

        .card-header-custom h2 {
            font-size: 1.5rem;
        }

        .card-body-custom {
            padding: 30px 20px;
        }

        .otp-input {
            font-size: 1.8rem;
            padding: 16px 20px;
            letter-spacing: 0.5rem;
        }

        .otp-input::placeholder {
            font-size: 1.2rem;
            letter-spacing: 0.3rem;
        }

        .btn-verify {
            padding: 16px 24px;
            font-size: 1rem;
        }

        .email-highlight {
            padding: 20px 16px;
        }

        .custom-divider {
            margin: 30px 0;
        }
    }

    /* Small Mobile */
    @media (max-width: 480px) {
        .verification-container {
            padding: 15px 10px;
        }

        .welcome-section h1 {
            font-size: 1.8rem;
        }

        .card-body-custom {
            padding: 25px 16px;
        }

        .otp-input {
            font-size: 1.6rem;
            letter-spacing: 0.4rem;
        }
    }

    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        .verification-card {
            background: rgba(22, 39, 55, 0.95);
            color: white;
        }

        .email-highlight {
            background: linear-gradient(135deg, rgba(22, 39, 55, 0.8) 0%, rgba(13, 94, 166, 0.3) 100%);
        }

        .custom-divider span {
            background: rgba(22, 39, 55, 0.95);
            color: var(--color-light);
        }
    }

    /* Accessibility improvements */
    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }

    /* Focus indicators */
    *:focus {
        outline: 2px solid var(--color-primary);
        outline-offset: 2px;
    }

    /* Reduce motion for users who prefer it */
    @media (prefers-reduced-motion: reduce) {
        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>
@endpush

@section('content')
<div class="verification-wrapper">
    <div class="verification-container">
        <div class="verification-content">
            <!-- Welcome Section (Desktop Only) -->
            <div class="welcome-section d-none d-lg-block">
                <h1>Selamat Datang! 👋</h1>
                <p>Keamanan akun Anda adalah prioritas utama kami. Mari verifikasi email Anda untuk melanjutkan.</p>
                <ul class="feature-list">
                    <li>Perlindungan akun yang lebih kuat</li>
                    <li>Akses ke semua fitur premium</li>
                    <li>Notifikasi keamanan real-time</li>
                    <li>Pemulihan akun yang mudah</li>
                </ul>
            </div>

            <!-- Verification Card -->
            <div class="verification-card shadow-lg">
                <div class="card-header-custom">
                    <span class="icon">🔐</span>
                    <h2>Verifikasi Akun Anda</h2>
                </div>
                
                <div class="card-body-custom">
                    @if(session('success'))
                        <div class="alert alert-success-custom alert-custom" role="alert">
                            <i class="fas fa-check-circle me-2" aria-hidden="true"></i>
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger-custom alert-custom" role="alert">
                            <i class="fas fa-exclamation-triangle me-2" aria-hidden="true"></i>
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
                            <i class="fas fa-envelope me-2" aria-hidden="true"></i>
                            <strong>{{ $user->email }}</strong>
                        </div>
                    </div>
                    
                    <p class="text-center mb-4" style="color: #6c757d;">
                        Masukkan kode <strong>6 digit</strong> di bawah ini untuk mengaktifkan akun Anda.
                    </p>
                    
                    <form action="{{ route('verifyOtp.process') }}" method="POST" id="otpForm" novalidate>
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">

                        <div class="otp-container">
                            <label for="verification_code" class="form-label fw-semibold sr-only">
                                Kode Verifikasi
                            </label>
                            <input 
                                type="text" 
                                name="verification_code" 
                                id="verification_code" 
                                class="form-control otp-input" 
                                maxlength="6" 
                                placeholder="000000"
                                required
                                autocomplete="one-time-code"
                                inputmode="numeric"
                                pattern="[0-9]{6}"
                                aria-describedby="otp-help"
                                autocorrect="off"
                                autocapitalize="off"
                                spellcheck="false"
                            >
                            <small id="otp-help" class="form-text mt-3 d-block text-center text-white">
                                <i class="fas fa-info-circle me-1" aria-hidden="true" ></i>
                                Masukkan 6 digit angka yang diterima via email
                            </small>
                        </div>
                        
                        <button type="submit" class="btn btn-verify w-100 mb-4" aria-describedby="verify-help">
                            <i class="fas fa-shield-alt me-2" aria-hidden="true"></i>
                            <span>Verifikasi Sekarang</span>
                        </button>
                        <small id="verify-help" class="sr-only">
                            Klik untuk memverifikasi kode OTP yang Anda masukkan
                        </small>
                    </form>
                    
                    <div class="custom-divider">
                        <span>Tidak menerima kode?</span>
                    </div>
                    
                   <div class="text-center">
                        <form action="{{ route('resendOtp') }}" method="POST" style="display: inline;" novalidate>
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">

                            <button type="submit" id="resend-btn" class="btn btn-resend" aria-describedby="resend-help">
                                <i class="fas fa-redo me-2" aria-hidden="true"></i>
                                <span>Kirim Ulang Kode</span>
                            </button>

                            <small id="resend-help" class="sr-only">
                                Klik untuk mengirim ulang kode verifikasi ke email Anda
                            </small>
                        </form>

                        <small id="resend-timer" class="text-muted d-block mt-2" style="display:none;">
                            Tunggu <span id="countdown">60</span> detik untuk kirim ulang
                        </small>
                    </div>

                    
                    <div class="text-center mt-4">
                        <small class="text-white">
                            <i class="fas fa-clock me-1" aria-hidden="true"></i>
                            Kode akan kedaluwarsa dalam <strong>10 menit</strong>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpInput = document.getElementById('verification_code');
    const form = document.getElementById('otpForm');
    const submitButton = form.querySelector('.btn-verify');
    const originalButtonText = submitButton.innerHTML;
    
    // Auto-submit saat 6 digit terisi
    otpInput.addEventListener('input', function() {
        // Hanya angka yang diizinkan
        this.value = this.value.replace(/\D/g, '');
        
        // Remove any previous error states
        this.classList.remove('is-invalid');
        
        // Auto submit jika 6 digit
        if (this.value.length === 6) {
            setTimeout(() => {
                if (!form.classList.contains('loading')) {
                    submitForm();
                }
            }, 300);
        }
    });
    
    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (otpInput.value.length !== 6) {
            showError('Kode verifikasi harus 6 digit');
            otpInput.focus();
            return;
        }
        
        submitForm();
    });
    
    function submitForm() {
        form.classList.add('loading');
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memverifikasi...';
        submitButton.disabled = true;
        
        // Submit form setelah delay
        setTimeout(() => {
            form.submit();
        }, 500);
    }
    
    function showError(message) {
        otpInput.classList.add('is-invalid');
        
        // Create or update error message
        let errorEl = document.getElementById('otp-error');
        if (!errorEl) {
            errorEl = document.createElement('div');
            errorEl.id = 'otp-error';
            errorEl.className = 'invalid-feedback d-block mt-2 text-center';
            otpInput.parentNode.appendChild(errorEl);
        }
        
        errorEl.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i>' + message;
        
        // Remove error after 3 seconds
        setTimeout(() => {
            otpInput.classList.remove('is-invalid');
            if (errorEl) {
                errorEl.remove();
            }
        }, 3000);
        
        // Add shake animation
        otpInput.style.animation = 'shake 0.5s ease-in-out';
        setTimeout(() => {
            otpInput.style.animation = '';
        }, 500);
    }
    
    // Handle resend form
    const resendForm = document.querySelector('form[action*="resendOtp"]');
    if (resendForm) {
        resendForm.addEventListener('submit', function() {
            const resendButton = this.querySelector('.btn-resend');
            const originalText = resendButton.innerHTML;
            
            resendButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
            resendButton.disabled = true;
            
            // Re-enable after 3 seconds
            setTimeout(() => {
                resendButton.innerHTML = originalText;
                resendButton.disabled = false;
            }, 3000);
        });
    }
    
    // Focus pada input saat halaman dimuat
    setTimeout(() => {
        otpInput.focus();
    }, 500);
    
    // Handle paste event
    otpInput.addEventListener('paste', function(e) {
        e.preventDefault();
        const pastedData = (e.clipboardData || window.clipboardData).getData('text');
        const numericData = pastedData.replace(/\D/g, '').substring(0, 6);
        
        if (numericData.length === 6) {
            this.value = numericData;
            setTimeout(() => {
                submitForm();
            }, 300);
        } else {
            this.value = numericData;
        }
    });

    const btn = document.getElementById("resend-btn");
    const timer = document.getElementById("resend-timer");
    const countdown = document.getElementById("countdown");

    btn.addEventListener("click", function () {
        let seconds = 120; // durasi limit (sesuai dengan backend RateLimiter)

        btn.disabled = true;
        timer.style.display = "block";

        const interval = setInterval(() => {
            seconds--;
            countdown.textContent = seconds;

            if (seconds <= 0) {
                clearInterval(interval);
                btn.disabled = false;
                timer.style.display = "none";
            }
        }, 1000);
    });
});

// Add CSS for shake animation
const style = document.createElement('style');
style.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-10px); }
        20%, 40%, 60%, 80% { transform: translateX(10px); }
    }
`;
document.head.appendChild(style);
</script>
@endsection