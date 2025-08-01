@extends('layouts.app')

@section('title', 'Login - Program ke Jepang')

@section('content')

<section class="section-spacing py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="section-title text-center mb-4">
                    <h1>Login <span>Program ke Jepang</span></h1>
                    <div class="underline mx-auto"></div>
                </div>
                <p class="text-center text-muted mb-5">Masuk ke akun Anda untuk melanjutkan proses pendaftaran.</p>

                <form method="POST" action="{{ route('login') }}" class="p-4 border rounded shadow-sm bg-white">
                    @csrf

                    {{-- Alert jika ada error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Remember Me --}}
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label ms-3 mt-1" for="remember">
                                Ingat saya
                            </label>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </div>

                    {{-- Link ke Register --}}
                    <div class="text-center mt-3">
                        <p class="text-muted">Belum punya akun? <a href="{{ url('form') }}" class="text-decoration-none">Daftar di sini</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection