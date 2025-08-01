@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section id="hero">
        <div class="container">
            <div class="row align-items-center h-100">
                <div class="col-lg-6 hero-content">
                    <div class="hero-tagline">
                        <h1>
                            Ingin Wujudkan <br>
                            <span class="span1">Kerja atau Magang</span>
                            <span class="span2">Ke Jepang?</span> 
                        </h1>
                        <p class="hero-text poppins-medium">
                            Klik tombol dibawah untuk info lengkap cara kerja atau magang ke Jepang
                        </p>
                        <div class="hero-buttons">
                            <button class="px-4 py-2 button-dark button-hover poppins-bold">Klik Disini!</button>
                            <a href="{{ url('about') }}" class="hero-link poppins-regular">
                                Tentang LPK PT Amarta <span>></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 hero-image d-none d-lg-block">
                    <div class="text-center ">
                        <img src="{{ asset('Asset/img/hero.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Alasan Section -->
    <section id="alasan">
        <div class="container">
            <div class="section-title">
                <h1>Kenapa Harus <span>PT. Amarta?</span></h1>
                <div class="underline"></div>
            </div>
            
            <div class="alasan-container">
                <!-- Card 1 -->
                <div class="alasan-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-language"></i>
                    </div>
                    <h3 class="alasan-title">Belajar Bahasa Jepang Sampai Jago!</h3>
                    <p class="alasan-text">
                        Kurikulum kami itu udah didesain khusus supaya kamu cepat fasih berbahasa Jepang.
                        Nggak cuma nulis atau baca, tapi yang paling penting: jago ngobrol buat kerja!
                        Kami juga siapin kamu buat ujian JLPT atau JFT biar makin pede.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="alasan-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3 class="alasan-title">Mentor Kelas Kakap (Plus Guru dari Jepang Langsung!)</h3>
                    <p class="alasan-text">
                        Bayangin, kamu bakal diajar sama para mentor yang udah punya pengalaman di Jepang, plus ada guru native speaker dari Jepang langsung! Ini berkat dukungan keren dari Incollex Jepang. Jadi, kamu dapat ilmunya authentic banget!
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="alasan-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h3 class="alasan-title">Ditemenin Terus Sampai Jepang</h3>
                    <p class="alasan-text">
                        Dari awal masuk Amarta, belajar, ngurusin dokumen, latihan wawancara, sampai kamu terbang dan adaptasi di Jepang, kami bakal temenin kamu di setiap langkahnya. Nggak bakal dilepas sendirian!
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gerbang Section -->
    <section id="gerbang">
        <div class="container">
            <div class="section-title">
                <h1>Gerbang Anda Menuju Karir Gemilang di Jepang!</h1>
            </div>
            
            <div class="gerbang-container">
                <!-- Image Section -->
                <div class="image-section">
                    <div class="bg-hover p-5 rounded text-center">
                        <img src="{{ asset('Asset/img/foto-konten3.png') }}" alt="LPK Amarta Training">
                        <h3 class="text-dark mt-3">LPK Amarta Training Center</h3>
                    </div>
                </div>
                
                <!-- Content Section -->
                <div class="content-section">
                    <div class="description">
                        <p>
                            <span class="company-name">LPK Amarta</span> <span class="legal-name">(PT Amarta Bangun Indonesia)</span> adalah Lembaga pelatihan kerja
                            terkemuka yang berdedikasi untuk mencetak tenaga kerja Indonesia yang
                            kompeten, berbudaya, dan siap bersaing di pasar global, khususnya Jepang.
                            Kami membimbing Anda dari nol hingga siap menghadapi tantangan dan peluang di Jepang.
                        </p>
                    </div>
                    
                    <div class="vision-mission">
                        <div class="vision">
                            <h3>VISI</h3>
                            <p>
                                TURUT BERKONTRIBUSI MEMBANGUN SUMBER DAYA MANUSIA PROFESIONAL TANGGUH DAN BERBUDAYA SAING GLOBAL UNTUK INDONESIA MAJU
                            </p>
                        </div>
                        
                        <div class="mission">
                            <h3>MISI</h3>
                            <ul>
                                <li>Memberikan pelatihan bahasa Jepang profesional</li>
                                <li>Pembekalan Budaya Kerja Jepang</li>
                                <li>Membentuk karakter kerja yang jujur, cepat dan bertanggungjawab</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lowongan Section -->
    <section id="lowongan">
        <div class="container h-100">
            <div class="section-title">
                <h1>Lowongan <span>Magang</span></h1>
                <div class="underline"></div>
            </div>
            
            <div class="lowongan-container">
                <!-- Card 1 -->
                <div class="lowongan-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h3 class="lowongan-title">Manufaktur</h3>
                </div>

                <!-- Card 2 -->
                <div class="lowongan-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-tractor"></i>
                    </div>
                    <h3 class="lowongan-title">Pertanian dan Perikanan</h3>
                </div>

                <!-- Card 3 -->
                <div class="lowongan-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h3 class="lowongan-title">Pengelohan Makanan dan Minuman</h3>
                </div>

                <!-- Card 4 -->
                 <div class="lowongan-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-hard-hat"></i>
                    </div>
                    <h3 class="lowongan-title">Kontruksi</h3>
                </div>
            </div>
        </div>
  </section>

  <!-- Testimonial Section  -->
   <section id="testimoni">
    <div class="container">
        <div class="testimonial-container">
            <div class="section-title">
                <h1>Testimoni <span>User</span></h1>
                <div class="underline"></div>
            </div>
            <!-- Navigation Arrows -->
            <div class="nav-arrow prev" onclick="changeTestimonial(-1)">
                <svg viewBox="0 0 24 24">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </div>
            <div class="nav-arrow next" onclick="changeTestimonial(1)">
                <svg viewBox="0 0 24 24">
                    <path d="M9 18l6-6-6-6"/>
                </svg>
            </div>

            <!-- Testimonials -->
            <div class="testimonial-wrapper">
                <div class="testimonial-card">
                    <div class="profile-container">
                        <div class="profile-ring">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&h=200&fit=crop&crop=face" alt="Michael Jackson" class="profile-image">
                        </div>
                    </div>
                    <h3 class="user-name">Michael Jackson</h3>
                    <p class="user-title">SMAN 1 Bekasi</p>
                    <div class="fas fa-quote-right"></div>
                    <p class="testimonial-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>

                <div class="testimonial-card active">
                    <div class="profile-container">
                        <div class="profile-ring">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200&h=200&fit=crop&crop=face" alt="Michael Jackson" class="profile-image">
                        </div>
                    </div>
                    <h3 class="user-name">Michael Jackson</h3>
                    <p class="user-title">SMAN 1 Bekasi</p>
                    <div class="fas fa-quote-right"></div>
                    <p class="testimonial-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>

                <div class="testimonial-card">
                    <div class="profile-container">
                        <div class="profile-ring">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200&h=200&fit=crop&crop=face" alt="Michael Jackson" class="profile-image">
                        </div>
                    </div>
                    <h3 class="user-name">Michael Jackson</h3>
                    <p class="user-title">SMAN 1 Bekasi</p>
                    <div class="fas fa-quote-right"></div>
                    <p class="testimonial-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>
            </div>
        </div>
    </div>
        <!-- Navigation Dots -->
        <div class="testimonial-nav">
            <div class="nav-dot" onclick="goToSlide(0)"></div>
            <div class="nav-dot active" onclick="goToSlide(1)"></div>
            <div class="nav-dot" onclick="goToSlide(2)"></div>
        </div>
    </div>
   </section>
@endsection
