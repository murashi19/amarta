@extends('layouts.app')

@section('title', 'Form Pendaftaran Program ke Jepang')

@section('content')

<section class="section-spacing py-5" style="background: var(--gradient-primary); min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <!-- Header Section -->
                <div class="text-center mb-5">
                    <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-torii-gate text-primary" style="font-size: 2.5rem; color: var(--color-primary) !important;"></i>
                    </div>
                    <h1 class="text-white mb-3">Form Pendaftaran <span style="color: var(--color-warning);">Program ke Jepang</span></h1>
                    <div class="mx-auto mb-3" style="width: 100px; height: 3px; background-color: var(--color-warning);"></div>
                    <p class="text-white-50 lead">Bergabunglah dengan LPK Amarta dan wujudkan impian kerja di Jepang!</p>
                </div>

                <!-- Main Form -->
                <div class="card shadow-lg border-0" style="border-radius: 20px;">
                    <div class="card-body p-4 p-md-5">
                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Progress Indicator -->
                            <div class="row mb-5">
                                <div class="col-12">
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar" role="progressbar" style="width: 0%" id="form-progress"></div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <small class="text-muted">Data Pribadi</small>
                                        <small class="text-muted">Kontak</small>
                                        <small class="text-muted">Pendidikan</small>
                                        <small class="text-muted">Keamanan</small>
                                    </div>
                                </div>
                            </div>

                            {{-- Informasi Pribadi --}}
                            <div class="form-step active" id="step-1">
                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="step-icon d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                        <h4 class="mb-0 step-title">Informasi Pribadi</h4>
                                    </div>
                                    
                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <div class="form-floating">
                                                <input type="text" 
                                                       class="form-control @error('name') is-invalid @enderror" 
                                                       id="name" 
                                                       name="name" 
                                                       value="{{ old('name') }}" 
                                                       placeholder="Masukkan nama lengkap"
                                                       required>
                                                <label for="name">
                                                    <i class="fas fa-user me-2"></i>Nama Lengkap *
                                                </label>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-floating">
                                                <select class="form-select @error('gender') is-invalid @enderror" 
                                                        id="gender" 
                                                        name="gender" 
                                                        required>
                                                    <option value="">Pilih jenis kelamin</option>
                                                    <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                    <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                </select>
                                                <label for="gender">
                                                    <i class="fas fa-venus-mars me-2"></i>Jenis Kelamin *
                                                </label>
                                                @error('gender')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-floating">
                                                <input type="text" 
                                                       class="form-control @error('birth_place') is-invalid @enderror" 
                                                       id="birth_place" 
                                                       name="birth_place" 
                                                       value="{{ old('birth_place') }}" 
                                                       placeholder="Masukkan tempat lahir"
                                                       required>
                                                <label for="birth_place">
                                                    <i class="fas fa-map-marker-alt me-2"></i>Tempat Lahir *
                                                </label>
                                                @error('birth_place')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-floating">
                                                <input type="date" 
                                                       class="form-control @error('birth_date') is-invalid @enderror" 
                                                       id="birth_date" 
                                                       name="birth_date" 
                                                       value="{{ old('birth_date') }}" 
                                                       required>
                                                <label for="birth_date">
                                                    <i class="fas fa-calendar me-2"></i>Tanggal Lahir *
                                                </label>
                                                @error('birth_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-floating">
                                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                                          id="address" 
                                                          name="address" 
                                                          style="height: 120px"
                                                          placeholder="Masukkan alamat lengkap"
                                                          required>{{ old('address') }}</textarea>
                                                <label for="address">
                                                    <i class="fas fa-home me-2"></i>Alamat Lengkap *
                                                </label>
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="button" class="btn btn-primary btn-lg next-step">
                                            Selanjutnya <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Informasi Kontak --}}
                            <div class="form-step" id="step-2" style="display: none;">
                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="step-icon d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-phone text-white"></i>
                                        </div>
                                        <h4 class="mb-0 step-title">Informasi Kontak</h4>
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <div class="form-floating">
                                                <input type="email" 
                                                       class="form-control @error('email') is-invalid @enderror" 
                                                       id="email" 
                                                       name="email" 
                                                       value="{{ old('email') }}" 
                                                       placeholder="nama@email.com"
                                                       required>
                                                <label for="email">
                                                    <i class="fas fa-envelope me-2"></i>Email *
                                                </label>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-floating">
                                                <input type="tel" 
                                                       class="form-control @error('phone_number') is-invalid @enderror" 
                                                       id="phone_number" 
                                                       name="phone_number" 
                                                       value="{{ old('phone_number') }}" 
                                                       placeholder="08123456789"
                                                       pattern="[0-9]{10,15}"
                                                       required>
                                                <label for="phone_number">
                                                    <i class="fas fa-mobile-alt me-2"></i>Nomor Telepon *
                                                </label>
                                                @error('phone_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-secondary btn-lg prev-step">
                                            <i class="fas fa-arrow-left me-2"></i>Kembali
                                        </button>
                                        <button type="button" class="btn btn-primary btn-lg next-step">
                                            Selanjutnya <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Informasi Pendidikan --}}
                            <div class="form-step" id="step-3" style="display: none;">
                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="step-icon d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-graduation-cap text-white"></i>
                                        </div>
                                        <h4 class="mb-0 step-title">Informasi Pendidikan</h4>
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <div class="form-floating">
                                                <select class="form-select @error('education_level') is-invalid @enderror" 
                                                        id="education_level" 
                                                        name="education_level" 
                                                        required>
                                                    <option value="">Pilih pendidikan terakhir</option>
                                                    <option value="SMP/Sederajat" {{ old('education_level') == 'SMP/Sederajat' ? 'selected' : '' }}>SMP/Sederajat</option>
                                                    <option value="SMA/SMK/Sederajat" {{ old('education_level') == 'SMA/SMK/Sederajat' ? 'selected' : '' }}>SMA/SMK/Sederajat</option>
                                                    <option value="Diploma 3 (D3)" {{ old('education_level') == 'Diploma 3 (D3)' ? 'selected' : '' }}>Diploma 3 (D3)</option>
                                                    <option value="Sarjana (S1)" {{ old('education_level') == 'Sarjana (S1)' ? 'selected' : '' }}>Sarjana (S1)</option>
                                                    <option value="Lainnya" {{ old('education_level') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                                </select>
                                                <label for="education_level">
                                                    <i class="fas fa-school me-2"></i>Pendidikan Terakhir *
                                                </label>
                                                @error('education_level')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-floating">
                                                <input type="file" 
                                                       class="form-control @error('photo') is-invalid @enderror" 
                                                       id="photo" 
                                                       name="photo" 
                                                       accept="image/*">
                                                <label for="photo">
                                                    <i class="fas fa-camera me-2"></i>Foto Profil (Opsional)
                                                </label>
                                                @error('photo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">
                                                    <small class="text-muted">Format: JPG, PNG, maksimal 2MB</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-floating">
                                                <textarea class="form-control" 
                                                          id="notes" 
                                                          name="notes" 
                                                          style="height: 100px"
                                                          placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
                                                <label for="notes">
                                                    <i class="fas fa-sticky-note me-2"></i>Catatan Tambahan (Opsional)
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-secondary btn-lg prev-step">
                                            <i class="fas fa-arrow-left me-2"></i>Kembali
                                        </button>
                                        <button type="button" class="btn btn-primary btn-lg next-step">
                                            Selanjutnya <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Password --}}
                            <div class="form-step" id="step-4" style="display: none;">
                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="step-icon d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-lock text-white"></i>
                                        </div>
                                        <h4 class="mb-0 step-title">Keamanan Akun</h4>
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <div class="form-floating position-relative">
                                                <input type="password" 
                                                       class="form-control @error('password') is-invalid @enderror" 
                                                       id="password" 
                                                       name="password" 
                                                       placeholder="Password"
                                                       required>
                                                <label for="password">
                                                    <i class="fas fa-key me-2"></i>Password *
                                                </label>
                                                <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y me-3 toggle-password" 
                                                        data-target="#password" 
                                                        style="border: none; background: none; z-index: 10;">
                                                    <i class="fas fa-eye text-muted"></i>
                                                </button>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-floating position-relative">
                                                <input type="password" 
                                                       class="form-control" 
                                                       id="password_confirmation" 
                                                       name="password_confirmation" 
                                                       placeholder="Konfirmasi Password"
                                                       required>
                                                <label for="password_confirmation">
                                                    <i class="fas fa-key me-2"></i>Konfirmasi Password *
                                                </label>
                                                <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y me-3 toggle-password" 
                                                        data-target="#password_confirmation" 
                                                        style="border: none; background: none; z-index: 10;">
                                                    <i class="fas fa-eye text-muted"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="alert alert-info">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <strong>Tips Keamanan:</strong> Gunakan password minimal 8 karakter dengan kombinasi huruf besar, huruf kecil, angka, dan simbol.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-secondary btn-lg prev-step">
                                            <i class="fas fa-arrow-left me-2"></i>Kembali
                                        </button>
                                        <button type="submit" class="btn btn-success btn-lg">
                                            <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Link ke Login --}}
                            <div class="text-center mt-4 pt-4 border-top">
                                <p class="text-muted">
                                    Sudah punya akun? 
                                    <a href="{{ url('login') }}" class="text-decoration-none fw-bold login-link">
                                        Login di sini <i class="fas fa-sign-in-alt ms-1"></i>
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let currentStep = 1;
        const totalSteps = 4;
        
        // Multi-step form functionality
        function updateProgress() {
            const progress = (currentStep / totalSteps) * 100;
            document.getElementById('form-progress').style.width = progress + '%';
        }
        
        function showStep(step) {
            document.querySelectorAll('.form-step').forEach(el => {
                el.style.display = 'none';
                el.classList.remove('active');
            });
            
            const targetStep = document.getElementById('step-' + step);
            if (targetStep) {
                targetStep.style.display = 'block';
                targetStep.classList.add('active');
            }
            
            updateProgress();
        }
        
        // Next step buttons
        document.querySelectorAll('.next-step').forEach(btn => {
            btn.addEventListener('click', function() {
                if (validateCurrentStep()) {
                    if (currentStep < totalSteps) {
                        currentStep++;
                        showStep(currentStep);
                    }
                }
            });
        });
        
        // Previous step buttons
        document.querySelectorAll('.prev-step').forEach(btn => {
            btn.addEventListener('click', function() {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            });
        });
        
        // Simple validation for current step
        function validateCurrentStep() {
            const currentStepEl = document.getElementById('step-' + currentStep);
            const requiredFields = currentStepEl.querySelectorAll('input[required], select[required], textarea[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                field.classList.remove('is-invalid');
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                }
            });
            
            if (!isValid) {
                const toast = document.createElement('div');
                toast.className = 'toast-container position-fixed top-0 end-0 p-3';
                toast.innerHTML = `
                    <div class="toast show" role="alert">
                        <div class="toast-header" style="background-color: var(--color-warning); color: var(--color-dark);">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong class="me-auto">Perhatian</strong>
                        </div>
                        <div class="toast-body">
                            Mohon lengkapi semua field yang wajib diisi.
                        </div>
                    </div>
                `;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3000);
            }
            
            return isValid;
        }
        
        // Password toggle functionality
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function () {
                const target = document.querySelector(this.dataset.target);
                const icon = this.querySelector('i');
                
                if (target.type === 'password') {
                    target.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    target.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
        
        // Phone number formatting
        document.getElementById('phone_number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('08')) {
                e.target.value = value;
            } else if (value.startsWith('8')) {
                e.target.value = '0' + value;
            }
        });
        
        // Initialize first step
        updateProgress();
    });
</script>
@endpush

@push('styles')
    <style>
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
        
        .section-spacing {
            background-attachment: fixed;
        }
        
        .form-step {
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .step-icon {
            background: var(--gradient-primary);
            border-radius: 50%;
            box-shadow: var(--shadow-soft);
        }
        
        .step-title {
            color: var(--color-primary);
        }
        
        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label,
        .form-floating > .form-select ~ label {
            color: var(--color-primary);
            font-weight: 600;
        }
        
        .form-control:focus,
        .form-select:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 0.2rem rgba(13, 94, 166, 0.15);
        }
        
        .btn {
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: var(--gradient-primary);
            border-color: var(--color-primary);
        }
        
        .btn-primary:hover {
            background: var(--color-primary);
            border-color: var(--color-primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }
        
        .btn-success {
            background-color: var(--color-success);
            border-color: var(--color-success);
        }
        
        .btn-success:hover {
            background-color: #1da71d;
            border-color: #1da71d;
            transform: translateY(-2px);
            box-shadow: 0 20px 60px rgba(36, 194, 36, 0.2);
        }
        
        .btn-outline-secondary {
            color: var(--color-secondary);
            border-color: var(--color-secondary);
        }
        
        .btn-outline-secondary:hover {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
            transform: translateY(-2px);
        }
        
        .card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: var(--shadow-soft);
        }
        
        .toggle-password {
            z-index: 5;
        }
        
        .toggle-password i {
            transition: color 0.2s ease;
        }
        
        .toggle-password:hover i {
            color: var(--color-primary) !important;
        }
        
        .progress {
            border-radius: 10px;
            background: rgba(13, 94, 166, 0.1);
        }
        
        .progress-bar {
            background: var(--gradient-primary);
            border-radius: 10px;
            transition: width 0.3s ease;
        }
        
        .form-text {
            margin-top: 0.25rem;
        }
        
        .alert {
            border: none;
            border-radius: 10px;
            font-size: 0.9rem;
        }
        
        .alert-info {
            background: var(--gradient-light);
            color: var(--color-dark);
            border-left: 4px solid var(--color-info);
        }
        
        .login-link {
            color: var(--color-primary);
            transition: color 0.2s ease;
        }
        
        .login-link:hover {
            color: var(--color-secondary);
        }
        
        .toast {
            border: none;
            border-radius: 10px;
            box-shadow: var(--shadow-soft);
        }
        
        .is-invalid {
            border-color: var(--color-danger) !important;
        }
        
        .invalid-feedback {
            color: var(--color-danger);
        }
        
        .text-primary {
            color: var(--color-primary) !important;
        }
        
        .border-top {
            border-color: rgba(13, 94, 166, 0.1) !important;
        }
        
        @media (max-width: 768px) {
            .section-spacing {
                padding: 2rem 0 !important;
            }
            
            .card-body {
                padding: 2rem !important;
            }
            
            .btn-lg {
                font-size: 1rem;
                padding: 0.75rem 1.5rem;
            }
            
            .step-icon {
                width: 35px !important;
                height: 35px !important;
            }
            
            .step-title {
                font-size: 1.1rem;
            }
        }
    </style>
@endpush
@endsection