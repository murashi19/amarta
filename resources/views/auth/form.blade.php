@extends('layouts.app')

@section('title', 'Form Pendaftaran Program ke Jepang')

@section('content')

<section class="section-spacing py-5">
    <div class="container">
        <div class="section-title text-center mb-4">
            <h1>Form Pendaftaran <span>Program ke Jepang</span></h1>
            <div class="underline mx-auto"></div>
        </div>
        <p class="text-center text-muted mb-5">Lengkapi data diri Anda untuk mengikuti program kerja atau magang di Jepang.</p>

        <form method="POST" action="{{ route('register') }}" class="p-4 border rounded shadow-sm bg-white">
            @csrf

            {{-- Informasi Pribadi --}}
            <div class="mb-4">
                <h4 class="mb-3 text-primary">Informasi Pribadi</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="phone_number" class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" 
                               id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
                        @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="birth_date" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                               id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
                        @error('birth_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="address" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Informasi Pendidikan --}}
            <div class="mb-4">
                <h4 class="mb-3 text-primary">Informasi Pendidikan</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="education" class="form-label">Pendidikan Terakhir</label>
                        <select class="form-select @error('education') is-invalid @enderror" 
                                id="education" name="education" required>
                            <option value="" disabled {{ old('education') ? '' : 'selected' }}>-- Pilih Pendidikan --</option>
                            <option value="SD" {{ old('education') == 'SD' ? 'selected' : '' }}>SD</option>
                            <option value="SMP" {{ old('education') == 'SMP' ? 'selected' : '' }}>SMP</option>
                            <option value="SMA/SMK" {{ old('education') == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                            <option value="D3" {{ old('education') == 'D3' ? 'selected' : '' }}>Diploma (D3)</option>
                            <option value="S1" {{ old('education') == 'S1' ? 'selected' : '' }}>Sarjana (S1)</option>
                            <option value="S2" {{ old('education') == 'S2' ? 'selected' : '' }}>Magister (S2)</option>
                            <option value="S3" {{ old('education') == 'S3' ? 'selected' : '' }}>Doktor (S3)</option>
                        </select>
                        @error('education')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="japanese_level" class="form-label">Tingkat Bahasa Jepang</label>
                        <select class="form-select @error('japanese_level') is-invalid @enderror" 
                                id="japanese_level" name="japanese_level" required>
                            <option value="">Pilih tingkat...</option>
                            <option value="N1" {{ old('japanese_level') == 'N1' ? 'selected' : '' }}>N1</option>
                            <option value="N2" {{ old('japanese_level') == 'N2' ? 'selected' : '' }}>N2</option>
                            <option value="N3" {{ old('japanese_level') == 'N3' ? 'selected' : '' }}>N3</option>
                            <option value="N4" {{ old('japanese_level') == 'N4' ? 'selected' : '' }}>N4</option>
                            <option value="N5" {{ old('japanese_level') == 'N5' ? 'selected' : '' }}>N5</option>
                            <option value="Belum Menguasai" {{ old('japanese_level') == 'Belum Menguasai' ? 'selected' : '' }}>Belum Menguasai</option>
                        </select>
                        @error('japanese_level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="motivation" class="form-label">Motivasi Mengikuti Program</label>
                        <textarea class="form-control @error('motivation') is-invalid @enderror" 
                                  id="motivation" name="motivation" rows="3" required>{{ old('motivation') }}</textarea>
                        @error('motivation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <h4 class="mb-3 text-primary">Keamanan Akun</h4>
                <div class="row g-3">
                    <div class="col-md-6 position-relative">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                            id="password" name="password" required>
                        <i class="fas fa-eye position-absolute top-50 end-0 translate-middle-y me-3 mt-3 toggle-password" 
                        style="cursor: pointer;" data-target="#password"></i>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 position-relative">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" 
                            id="password_confirmation" name="password_confirmation" required>
                        <i class="fas fa-eye position-absolute top-50 end-0 translate-middle-y me-3 mt-3 toggle-password" 
                        style="cursor: pointer;" data-target="#password_confirmation"></i>
                    </div>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-paper-plane me-2"></i>Daftar Sekarang
                </button>
            </div>

            {{-- Link ke Login --}}
            <div class="text-center mt-3">
                <p class="text-muted">Sudah punya akun? <a href="{{ url('login') }}" class="text-decoration-none">Login di sini</a></p>
            </div>
        </form>
    </div>
</section>

@endsection

{{-- CSS efek opacity --}}
<style>
    .toggle-password {
        cursor: pointer;
        color: #6c757d;
        opacity: 30%; /* selalu redup */
        transition: opacity 0.2s ease;
    }
    .toggle-password:hover {
        opacity: 150%; /* jadi jelas ketika diarahkan kursor */
    }
</style>
{{-- Script untuk toggle password --}}
@push('scripts')
<script>
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function () {
            const target = document.querySelector(this.dataset.target);
            const icon = this.querySelector('i');
            if (target.type === 'password') {
                target.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                target.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });
</script>
@endpush