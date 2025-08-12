@extends('layouts.app')


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
        --gradient-secondary: linear-gradient(135deg, #a6550d 0%, #d4731a 100%);
        --gradient-success: linear-gradient(135deg, #24c224 0%, #2ed82e 100%);
        --gradient-warning: linear-gradient(135deg, #e2b11e 0%, #f7c942 100%);
        --gradient-danger: linear-gradient(135deg, #ac2020 0%, #d62c2c 100%);
        --gradient-info: linear-gradient(135deg, #297ba3 0%, #3498db 100%);
        --card-shadow: 0 10px 30px rgba(13, 94, 166, 0.1);
        --hover-shadow: 0 20px 40px rgba(13, 94, 166, 0.15);
    }

    /* Hero Section */
    .hero-gradient {
        background: var(--gradient-primary);
        position: relative;
        padding: 100px 0;
    }

    .hero-pattern {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.7;
    }

    .min-vh-75 {
        min-height: 75vh;
    }

    .hero-scroll {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 1.5rem;
        animation: bounce 2s infinite;
    }

    /* Wave Divider */
    .wave-divider {
        position: absolute;
        bottom: 0;
        width: 100%;
        overflow: hidden;
        line-height: 0;
    }

    .wave-divider svg {
        position: relative;
        display: block;
        width: calc(100% + 1.3px);
        height: 60px;
    }

    /* Section Header */
    .section-header {
        margin-bottom: 3rem;
    }

    .section-divider {
        width: 80px;
        height: 4px;
        background: var(--gradient-primary);
        border-radius: 2px;
    }

    /* Requirement Cards */
    .requirement-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(13, 94, 166, 0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .requirement-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .requirement-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--hover-shadow);
    }

    .requirement-card:hover::before {
        transform: scaleX(1);
    }

    .card-icon {
        background: var(--gradient-primary);
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 20px rgba(13, 94, 166, 0.3);
    }

    .card-icon.bg-info {
        background: var(--gradient-info);
        box-shadow: 0 10px 20px rgba(41, 123, 163, 0.3);
    }

    .card-icon.bg-warning {
        background: var(--gradient-warning);
        box-shadow: 0 10px 20px rgba(226, 177, 30, 0.3);
    }

    .card-icon.bg-success {
        background: var(--gradient-success);
        box-shadow: 0 10px 20px rgba(36, 194, 36, 0.3);
    }

    .card-icon.bg-danger {
        background: var(--gradient-danger);
        box-shadow: 0 10px 20px rgba(172, 32, 32, 0.3);
    }

    .card-icon i {
        color: white;
        font-size: 2rem;
    }

    .card-title {
        color: var(--color-dark);
        font-weight: 700;
        margin-bottom: 1.5rem;
        font-size: 1.4rem;
    }

    /* Requirements List */
    .requirements-list {
        space-y: 0.75rem;
    }

    .requirement-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1rem;
        padding: 0.5rem 0;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .requirement-item:hover {
        background: var(--color-hover);
        padding-left: 1rem;
    }

    .requirement-item i {
        font-size: 1rem;
        margin-right: 1rem;
        margin-top: 0.2rem;
        flex-shrink: 0;
    }

    .requirement-item span {
        color: var(--color-dark);
        line-height: 1.5;
        font-size: 0.95rem;
    }

    .requirement-item.special {
        background: rgba(226, 177, 30, 0.1);
        padding: 1rem;
        border-radius: 10px;
        border-left: 4px solid var(--color-warning);
    }

    /* Info Banner */
    .info-banner {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(13, 94, 166, 0.08);
    }

    /* CTA Section */
    .cta-gradient {
        background: var(--color-primary);
        position: relative;
    }

    .cta-pattern {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3Ccircle cx='0' cy='30' r='4'/%3E%3Ccircle cx='60' cy='30' r='4'/%3E%3Ccircle cx='30' cy='0' r='4'/%3E%3Ccircle cx='30' cy='60' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .cta-content {
        padding: 2rem 0;
    }

    .cta-buttons .btn {
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }

    .cta-buttons .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    /* Trust Indicators */
    .trust-indicators {
        padding-top: 2rem;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    .trust-item {
        text-align: center;
        padding: 1rem;
    }

    .trust-item .fw-bold {
        font-size: 2rem;
        color: var(--color-warning);
    }

    .trust-item small {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.9rem;
    }

    /* Animations */
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0) translateX(-50%);
        }
        40% {
            transform: translateY(-10px) translateX(-50%);
        }
        60% {
            transform: translateY(-5px) translateX(-50%);
        }
    }

    .animate-slide-up {
        animation: slideUp 0.8s ease-out forwards;
        opacity: 0;
        transform: translateY(30px);
    }

    @keyframes slideUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-gradient {
            padding: 60px 0;
        }

        .requirement-card {
            padding: 1.5rem;
        }

        .card-icon {
            width: 60px;
            height: 60px;
        }

        .card-icon i {
            font-size: 1.5rem;
        }

        .card-title {
            font-size: 1.2rem;
        }

        .info-banner {
            padding: 1.5rem;
            text-align: center;
        }

        .trust-item .fw-bold {
            font-size: 1.5rem;
        }

        .cta-buttons .btn {
            width: 100%;
            height: 50px;
            margin-bottom: 1rem;
            font-size: 14px; /* atur ukuran font agar pas */
            white-space: nowrap; /* agar teks tidak wrap ke baris baru */
            overflow: hidden;   /* sembunyikan jika kelebihan */
            text-overflow: ellipsis; /* tanda ... jika teks terlalu panjang */
        }
    }

    /* Alert Enhancements */
    .alert {
        border: none;
        border-radius: 10px;
        font-size: 0.9rem;
    }

    .alert-warning {
        background: var(--gradient-light);
        color: var(--color-warning);
        border-left: 4px solid var(--color-warning);
    }

    .alert-success {
        background: rgba(36, 194, 36, 0.1);
        color: var(--color-success);
        border-left: 4px solid var(--color-success);
    }

    .alert-info {
        background: rgba(41, 123, 163, 0.1);
        color: var(--color-info);
        border-left: 4px solid var(--color-info);
    }
</style>
@endpush
@section('content')

    <!-- Hero Section -->
    <section id="syarat-hero" class="hero-gradient position-relative overflow-hidden">
        <div class="hero-pattern"></div>
        <div class="container position-relative">
            <div class="row align-items-center justify-content-center min-vh-75">
                <div class="col-lg-8 text-center">
                    <div class="hero-content">
                        <div class="hero-icon mb-4">
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center" 
                                 style="width: 100px; height: 100px;">
                                <i class="fas fa-clipboard-check text-primary" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                        <h1 class="display-3 text-white fw-bold mb-4 animate-slide-up">
                            Persyaratan <span class="text-warning">Peserta</span>
                        </h1>
                        <p class="lead text-white-50 mb-5 animate-slide-up" style="animation-delay: 0.2s;">
                            Penuhi kualifikasi dan siapkan diri Anda untuk meraih kesempatan emas berkarir di Jepang bersama LPK Amarta!
                        </p>
                        <div class="hero-scroll animate-bounce">
                            <i class="fas fa-chevron-down text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </section>

    <!-- Main Content -->
    <section id="syarat-detail" class="py-5 bg-light">
        <div class="container">
            <!-- Section Header -->
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <div class="section-header">
                        <h2 class="text-center mb-5 text-primary fw-bold">
                            Apa Saja yang Dibutuhkan untuk Bergabung?
                        </h2>
                        <div class="section-divider mx-auto mb-4"></div>
                        <p class="lead text-muted">
                            Berikut adalah syarat-syarat lengkap yang perlu Anda penuhi untuk bergabung dengan program kami
                        </p>
                    </div>
                </div>
            </div>

            <!-- Requirements Grid -->
            <div class="row g-4">
                <!-- Persyaratan Umum -->
                <div class="col-lg-4 col-md-6">
                    <div class="requirement-card h-100">
                        <div class="card-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Persyaratan Umum</h3>
                            <div class="requirements-list">
                                <div class="requirement-item">
                                    <i class="fas fa-check text-success"></i>
                                    <span>Warga Negara Indonesia (WNI)</span>
                                </div>
                                <div class="requirement-item">
                                    <i class="fas fa-check text-success"></i>
                                    <span>Usia 18–30 tahun (program magang), atau hingga 35 tahun (SSW)</span>
                                </div>
                                <div class="requirement-item">
                                    <i class="fas fa-check text-success"></i>
                                    <span>Sehat jasmani dan rohani</span>
                                </div>
                                <div class="requirement-item">
                                    <i class="fas fa-check text-success"></i>
                                    <span>Lulusan minimal SMA/SMK sederajat</span>
                                </div>
                                <div class="requirement-item">
                                    <i class="fas fa-check text-success"></i>
                                    <span>Tidak memiliki catatan kriminal</span>
                                </div>
                                <div class="requirement-item">
                                    <i class="fas fa-check text-success"></i>
                                    <span>Tidak bertato atau bertindik berlebihan</span>
                                </div>
                                <div class="requirement-item">
                                    <i class="fas fa-check text-success"></i>
                                    <span>Bersedia mengikuti pelatihan selama beberapa bulan di LPK</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dokumen Administrasi -->
                <div class="col-lg-4 col-md-6">
                    <div class="requirement-card h-100">
                        <div class="card-icon bg-info">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Dokumen Administrasi</h3>
                            <div class="requirements-list">
                                <div class="requirement-item">
                                    <i class="fas fa-file text-info"></i>
                                    <span>KTP, KK, dan Akta Kelahiran</span>
                                </div>
                                <div class="requirement-item">
                                    <i class="fas fa-file text-info"></i>
                                    <span>Ijazah dan transkrip nilai terakhir</span>
                                </div>
                                <div class="requirement-item">
                                    <i class="fas fa-file text-info"></i>
                                    <span>SKCK (Surat Keterangan Catatan Kepolisian)</span>
                                </div>
                                <div class="requirement-item">
                                    <i class="fas fa-file text-info"></i>
                                    <span>Surat keterangan sehat dari dokter</span>
                                </div>
                                <div class="requirement-item">
                                    <i class="fas fa-file text-info"></i>
                                    <span>Pas foto latar belakang putih (3x4 & 4x6)</span>
                                </div>
                                <div class="requirement-item">
                                    <i class="fas fa-file text-info"></i>
                                    <span>Sertifikat pelatihan/pengalaman kerja (jika ada)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kemampuan Bahasa Jepang -->
                <div class="col-lg-4 col-md-6">
                    <div class="requirement-card h-100">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-language"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Kemampuan Bahasa Jepang</h3>
                            <div class="requirements-list">
                                <div class="requirement-item special">
                                    <i class="fas fa-star text-warning"></i>
                                    <div>
                                        <strong>Program Magang (TITP):</strong><br>
                                        <small>min. JLPT N5 atau JFT-Basic A2</small>
                                    </div>
                                </div>
                                <div class="requirement-item special">
                                    <i class="fas fa-star text-warning"></i>
                                    <div>
                                        <strong>Program SSW:</strong><br>
                                        <small>min. JLPT N4 atau JFT-Basic A2 + Ujian Keterampilan Kerja</small>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-warning mt-3">
                                <i class="fas fa-lightbulb me-2"></i>
                                <small><strong>Tips:</strong> Kami menyediakan kelas bahasa Jepang untuk mempersiapkan Anda!</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Biaya Pelatihan -->
                <div class="col-lg-6 col-md-6">
                    <div class="requirement-card h-100">
                        <div class="card-icon bg-success">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Biaya Pelatihan</h3>
                            <div class="requirements-list">
                                <div class="requirement-item">
                                    <i class="fas fa-money-bill text-success"></i>
                                    <span>Biaya pelatihan bahasa Jepang (3–12 bulan)</span>
                                </div>
                                <div class="requirement-item">
                                    <i class="fas fa-money-bill text-success"></i>
                                    <span>Biaya makan, asrama, dan seragam</span>
                                </div>
                                <div class="requirement-item">
                                    <i class="fas fa-money-bill text-success"></i>
                                    <span>Biaya dokumen dan visa (dibayarkan di akhir tahap)</span>
                                </div>
                            </div>
                            <div class="alert alert-success mt-3">
                                <i class="fas fa-gift me-2"></i>
                                <div>
                                    <strong>Kabar Baik!</strong><br>
                                    <small>Telah bekerja sama dengan perusahaan Jepang menyediakan program beasiswa atau pembayaran bertahap.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Siap Ikatan Kontrak -->
                <div class="col-lg-6 col-md-6">
                    <div class="requirement-card h-100">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Siap Ikatan Kontrak</h3>
                            <div class="requirements-list">
                                <div class="requirement-item">
                                    <i class="fas fa-clipboard-check text-danger"></i>
                                    <span>Siap terikat kontrak kerja/magang selama 3–5 tahun di Jepang</span>
                                </div>
                                <div class="requirement-item">
                                    <i class="fas fa-clipboard-check text-danger"></i>
                                    <span>Tidak menikah selama program (khusus magang, tergantung LPK & perusahaan)</span>
                                </div>
                            </div>
                            <div class="alert alert-info mt-3">
                                <i class="fas fa-info-circle me-2"></i>
                                <small><strong>Catatan:</strong> Kontrak ini melindungi hak dan kewajiban kedua belah pihak</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Info Section -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="info-banner">
                        <div class="row align-items-center">
                            <div class="col-lg-2 text-center">
                                <i class="fas fa-info-circle text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <div class="col-lg-10">
                                <h4 class="text-primary mb-2">Informasi Penting</h4>
                                <p class="mb-0 text-muted">
                                    Semua persyaratan di atas dapat berubah sewaktu-waktu tergantung pada kebijakan pemerintah Jepang dan perusahaan mitra. 
                                    Tim kami akan membantu Anda dalam mempersiapkan semua dokumen yang diperlukan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="marketing-cta" class="py-5 bg-primary text-white text-center">
        <div class="container">
            <h2 class="mb-4 text-white">Siap Mewujudkan Impian Berkarir di Jepang?</h2>
            <p class="lead mb-5">
                Jangan tunda lagi kesempatan emas ini! Dengan pendaftaran awal hanya
                <strong class="text-warning">Rp 500.000,-</strong>
                Anda sudah bisa memulai langkah pertama menuju masa depan cerah di Negeri Sakura!
            </p>
            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                <a href="{{ url('form') }}" class="btn btn-warning btn-lg px-4 me-sm-3">LANJUT DAFTAR</a>
                <a href="https://wa.me/6285183123744" target="_blank" class="btn btn-outline-light btn-lg px-4">Konsultasi via WhatsApp <i class="fab fa-whatsapp ms-2"></i></a>
            </div>
        </div>
    </section>

@endsection
