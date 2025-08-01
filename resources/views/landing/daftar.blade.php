@extends('layouts.app')

@section('content')

    <section id="syarat-hero" class="carousel-header">
        <div class="container">
            <div class="row align-items-center justify-content-center h-100">
                <div class="col-12 text-center">
                    <h1 class="display-4 text-white mb-3">Persyaratan Peserta</h1>
                    <p class="lead text-white-50 mx-auto" style="max-width: 700px;">
                        Penuhi kualifikasi dan siapkan diri Anda untuk meraih kesempatan emas berkarir di Jepang bersama LPK Amarta!
                    </p>
                    {{-- Opsional: Tambahkan gelombang jika desain Anda menggunakannya --}}
                    {{-- <div class="wave-divider"></div> --}}
                </div>
            </div>
        </div>
    </section>

    <section id="syarat-detail" class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h2 class="text-center mb-5 text-primary">Apa Saja yang Dibutuhkan untuk Bergabung?</h2>

                    {{-- Card untuk setiap kategori persyaratan --}}
                    <div class="row g-4"> {{-- g-4 for gutter spacing --}}

                        <div class="col-md-12 col-lg-4 d-flex">
                            <div class="card card-custom flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title text-primary mb-3"><i class="fas fa-check-circle me-2"></i> Persyaratan Umum</h3>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-arrow-alt-circle-right me-2 text-info"></i> Warga Negara Indonesia (WNI)</li>
                                        <li><i class="fas fa-arrow-alt-circle-right me-2 text-info"></i> Usia 18–30 tahun (program magang), atau hingga 35 tahun (SSW)</li>
                                        <li><i class="fas fa-arrow-alt-circle-right me-2 text-info"></i> Sehat jasmani dan rohani</li>
                                        <li><i class="fas fa-arrow-alt-circle-right me-2 text-info"></i> Lulusan minimal SMA/SMK sederajat (beberapa LPK menerima lulusan SMP)</li>
                                        <li><i class="fas fa-arrow-alt-circle-right me-2 text-info"></i> Tidak memiliki catatan kriminal</li>
                                        <li><i class="fas fa-arrow-alt-circle-right me-2 text-info"></i> Tidak bertato atau bertindik berlebihan</li>
                                        <li><i class="fas fa-arrow-alt-circle-right me-2 text-info"></i> Bersedia mengikuti pelatihan selama beberapa bulan di LPK</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-4 d-flex">
                            <div class="card card-custom flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title text-primary mb-3"><i class="fas fa-file-alt me-2"></i> Dokumen Administrasi</h3>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-arrow-alt-circle-right me-2 text-info"></i> KTP, KK, dan Akta Kelahiran</li>
                                        <li><i class="fas fa-arrow-alt-circle-right me-2 text-info"></i> Ijazah dan transkrip nilai terakhir</li>
                                        <li><i class="fas fa-arrow-alt-circle-right me-2 text-info"></i> SKCK (Surat Keterangan Catatan Kepolisian)</li>
                                        <li><i class="fas fa-arrow-alt-circle-right me-2 text-info"></i> Surat keterangan sehat dari dokter</li>
                                        <li><i class="fas fa-arrow-alt-circle-right me-2 text-info"></i> Pas foto latar belakang putih (3x4 & 4x6)</li>
                                        <li><i class="fas fa-arrow-alt-circle-right me-2 text-info"></i> Sertifikat pelatihan/pengalaman kerja (jika ada)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-4 d-flex">
                            <div class="card card-custom flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title text-primary mb-3"><i class="fas fa-language me-2"></i> Kemampuan Bahasa Jepang</h3>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-arrow-alt-circle-right me-2 text-info"></i> Program Magang (TITP): min. JLPT N5 atau JFT-Basic A2</li>
                                        <li><i class="fas fa-arrow-alt-circle-right me-2 text-info"></i> Program SSW: min. JLPT N4 atau JFT-Basic A2 + Ujian Keterampilan Kerja</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-6 d-flex">
                            <div class="card card-custom flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title text-primary mb-3"><i class="fas fa-wallet me-2"></i> Biaya Pelatihan</h3>
                                    <ul class="list-unstyled">
                                        <li>
                                            <i class="fas fa-arrow-alt-circle-right me-2 text-info"></i> 
                                            Biaya pelatihan bahasa Jepang (3–12 bulan)</li>
                                        <li>
                                            <i class="fas fa-arrow-alt-circle-right me-2 text-info"></i> 
                                            Biaya makan, asrama, dan seragam</li>
                                        <li>
                                            <i class="fas fa-arrow-alt-circle-right me-2 text-info"></i> 
                                            Biaya dokumen dan visa (dibayarkan di akhir tahap)</li>
                                        <li>
                                            <i class="fas fa-arrow-alt-circle-right me-2 text-info"></i> 
                                            <p><strong>Kabar Baik!</strong> telah bekerja sama dengan perusahaan Jepang menyediakan program beasiswa atau pembayaran bertahap.</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-6 d-flex">
                            <div class="card card-custom flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title text-primary mb-3"><i class="fas fa-handshake me-2"></i> Siap Ikatan Kontrak</h3>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-arrow-alt-circle-right me-2 text-info"></i> Siap terikat kontrak kerja/magang selama 3–5 tahun di Jepang</li>
                                        <li><i class="fas fa-arrow-alt-circle-right me-2 text-info"></i> Tidak menikah selama program (khusus magang, tergantung LPK & perusahaan)</li>
                                    </ul>
                                </div>
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
                <a href="https://wa.me/NOMOR_WHATSAPP_ANDA" target="_blank" class="btn btn-outline-light btn-lg px-4">Konsultasi via WhatsApp <i class="fab fa-whatsapp ms-2"></i></a>
            </div>
        </div>
    </section>

@endsection