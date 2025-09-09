@extends('layouts.app')

@section('title', 'Login - Program ke Jepang')

@section('content')
<section class="section-spacing py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <!-- Header -->
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="fas fa-user-circle text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h2 class="mb-2">Login</h2>
                    <p class="text-muted">Masuk ke akun Anda</p>
                </div>

                <!-- Login Form -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('login') }}" encrtype="multipart/form-data">
                            @csrf

                            {{-- Alert jika ada error --}}
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    {{ $errors->first() }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           placeholder="nama@email.com"
                                           required 
                                           autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password" 
                                           name="password" 
                                           placeholder="Masukkan password"
                                           required>
                                    <button type="button" 
                                            class="btn btn-outline-secondary toggle-password" 
                                            data-target="#password"
                                            title="Tampilkan password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Remember Me --}}
                            <!-- <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           name="remember" 
                                           id="remember">
                                    <label class="form-check-label" for="remember">
                                        Ingat saya
                                    </label>
                                </div>
                            </div> -->

                            {{-- Submit Button --}}
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Link ke Register --}}
                <div class="text-center mt-4">
                    <p class="text-muted mb-0">
                        Belum punya akun? 
                        <a href="{{ url('register') }}" class="text-decoration-none">
                            Daftar di sini
                        </a>
                    </p>
                </div >

                <!-- Opsi 4: Simple dengan border dan ikon yang lebih prominent -->
                <div class="text-center mt-4 p-3 border rounded-3" style="background-color: #f8f9fa; border-color: #dee2e6 !important;">
                    <div class="mb-2">
                        <i class="fas fa-envelope-circle-check text-success" style="font-size: 1.5rem;"></i>
                    </div>
                    <small class="text-muted d-block">
                        <strong class="text-dark">Baru saja Mendaftar?</strong>
                    </small>
                    <small class="text-muted">
                        Jangan lupa cek email untuk verifikasi akun Anda
                    </small>
                </div>

                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Toggle password visibility
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const target = document.querySelector(this.dataset.target);
                const icon = this.querySelector('i');
                
                if (target.type === 'password') {
                    // Show password as plain text
                    target.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                    this.setAttribute('title', 'Sembunyikan password');
                } else {
                    // Hide password (show as dots/asterisks)
                    target.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                    this.setAttribute('title', 'Tampilkan password');
                }
            });
        });
        
        // Set initial tooltip
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.setAttribute('title', 'Tampilkan password');
        });
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
        background-color: var(--color-light);
        min-height: 100vh;
        display: flex;
        align-items: center;
    }

    .card {
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .btn-primary {
        background-color: var(--color-primary);
        border-color: var(--color-primary);
        padding: 12px;
        font-weight: 500;
    }

    .btn-primary:hover {
        background-color: #0b4d8c;
        border-color: #0b4d8c;
    }

    .form-control {
        border-radius: 8px;
        padding: 12px 16px;
        border: 1px solid #e0e0e0;
    }

    .form-control:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 0 0.2rem rgba(13, 94, 166, 0.15);
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-color: #e0e0e0;
        color: #6c757d;
    }

    .text-primary {
        color: var(--color-primary) !important;
    }

    .alert-danger {
        background-color: rgba(172, 32, 32, 0.1);
        border-color: var(--color-danger);
        color: var(--color-danger);
        border-radius: 8px;
    }

    .form-check-input:checked {
        background-color: var(--color-primary);
        border-color: var(--color-primary);
    }

    .is-invalid {
        border-color: var(--color-danger);
    }

    .invalid-feedback {
        color: var(--color-danger);
    }

    a {
        color: var(--color-primary);
        transition: color 0.2s ease;
    }

    a:hover {
        color: var(--color-secondary);
    }

    .toggle-password {
        border-left: 0;
    }

    .toggle-password:hover {
        background-color: #f8f9fa;
    }

    @media (max-width: 576px) {
        .section-spacing {
            padding: 2rem 0;
        }
        
        .card-body {
            padding: 2rem 1.5rem;
        }
        
        h2 {
            font-size: 1.5rem;
        }
    }
</style>
@endpush
@endsection