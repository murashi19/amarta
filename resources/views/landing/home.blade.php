@extends('layouts.app')
@section('content')
    <!-- Hero Section -->
    <section id="hero">
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <!-- Konten Kiri -->
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
                            <a href="about" class="hero-link poppins-regular">
                                Tentang LPK Amarta Bekasi <span>&gt;</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Gambar Hero -->
                <div class="col-lg-6 hero-image d-none d-lg-block">
                    <div class="text-center">
                        <img img src="asset/img/hero.png" alt="Hero Image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Alasan Section -->
    <section id="alasan">
        <div class="container">
            <div class="section-title text-center">
                <h1>Kenapa Harus <span>Amarta Cabang Bekasi</span></h1>
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
                        Kurikulum kami udah didesain supaya kamu cepat fasih bahasa Jepang. Nggak cuma nulis atau baca, tapi jago ngobrol buat kerja! Kami siapin juga buat ujian JLPT atau JFT biar makin pede.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="alasan-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3 class="alasan-title">Mentor Kelas Kakap & Native Speaker!</h3>
                    <p class="alasan-text">
                        Kamu bakal diajar mentor berpengalaman dari Jepang + native speaker langsung dari Jepang (thanks to Incollex). Belajar langsung dari sumbernya!
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="alasan-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h3 class="alasan-title">Ditemenin Sampai Dapet Job di Jepang</h3>
                    <p class="alasan-text">
                        Dari awal belajar, dokumen, wawancara, sampai kamu adaptasi di Jepang — tim kami bakal dampingi kamu. No worries!
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
                        <img src="asset/img/foto-konten3.png" alt="LPK Amarta Training">
                        <h3 class="text-dark mt-3">LPK Amarta Training Center</h3>
                    </div>
                </div>
                
                <!-- Content Section -->
                <div class="content-section">
                    <div class="description">
                        <p>
                            <span class="company-name">LPK Amarta Bekasi</span> <span class="legal-name">(PT Amarta Bangun Indonesia)</span> adalah Lembaga pelatihan kerja
                            terkemuka yang berdedikasi untuk mencetak tenaga kerja Indonesia yang
                            kompeten, berbudaya, dan siap bersaing di pasar global, khususnya Jepang.
                            Kami membimbing Anda dari nol hingga siap menghadapi tantangan dan peluang di Jepang.
                        </p>
                    </div>
                    
                    <div class="vision-mission">
                        <div class="vision">
                            <h3>VISI</h3>
                            <p>
                                Turut berkontribusi membangun sumber daya manusia profesional, tangguh, dan berbudaya saing global untuk Indonesia maju                            </p>
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
<!-- Lowongan Section -->
<section id="lowongan">
  <div class="container">
    <div class="section-title">
      <h2>Lowongan <span>Magang</span></h2>
      <div class="underline"></div>
    </div>

    <div class="lowongan-container">
      <!-- Card 1 -->
      <a href="/lowongan_kerja" class="lowongan-card">
        <div class="icon-wrapper">
          <i class="fas fa-cogs"></i>
        </div>
        <h3 class="lowongan-title">Manufaktur</h3>
        <span class="detail-btn">Detail</span>
      </a>

      <!-- Card 2 -->
      <a href="/lowongan_kerja" class="lowongan-card">
        <div class="icon-wrapper">
          <i class="fas fa-tractor"></i>
        </div>
        <h3 class="lowongan-title">Pertanian dan Perikanan</h3>
        <span class="detail-btn">Detail</span>
      </a>

      <!-- Card 3 -->
      <a href="/lowongan_kerja" class="lowongan-card">
        <div class="icon-wrapper">
          <i class="fas fa-utensils"></i>
        </div>
        <h3 class="lowongan-title">Pengolahan Makanan dan Minuman</h3>
        <span class="detail-btn">Detail</span>
      </a>

      <!-- Card 4 -->
      <a href="/lowongan_kerja" class="lowongan-card">
        <div class="icon-wrapper">
          <i class="fas fa-hard-hat"></i>
        </div>
        <h3 class="lowongan-title">Konstruksi</h3>
        <span class="detail-btn">Detail</span>
      </a>

      <!-- Card 5 -->
      <a href="/lowongan_kerja" class="lowongan-card">
        <div class="icon-wrapper">
          <i class="fas fa-paw"></i>
        </div>
        <h3 class="lowongan-title">Peternakan</h3>
        <span class="detail-btn">Detail</span>
      </a>
    </div>
  </div>
</section>



 <!-- Testimonial Section -->
<!-- <section id="testimoni">
  <div class="container">
    <div class="testimonial-container">
      <div class="section-title text-center mb-12">
        <h1>Testimoni <span>User</span></h1>
        <div class="underline mx-auto mt-2"></div>
      </div> -->

      <!-- Navigation Arrows -->
      <!-- <div class="nav-arrow prev" onclick="changeTestimonial(-1)">
        <svg viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
      </div>
      <div class="nav-arrow next" onclick="changeTestimonial(1)">
        <svg viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
      </div> -->

      <!-- Testimonials -->
      <!-- <div class="testimonial-wrapper"> -->
        <!-- Card 1 -->
        <!-- <div class="testimonial-card">
          <div class="profile-container">
            <div class="profile-ring">
              <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&h=200&fit=crop&crop=face" alt="User Image" class="profile-image">
            </div>
          </div>
          <h3 class="user-name">Michael Jackson</h3>
          <p class="user-title">SMAN 1 Bekasi</p>
          <div class="quote-icon fas fa-quote-right"></div>
          <p class="testimonial-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div> -->

        <!-- Card 2 (Active) -->
        <!-- <div class="testimonial-card active">
          <div class="profile-container">
            <div class="profile-ring">
              <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200&h=200&fit=crop&crop=face" alt="User Image" class="profile-image">
            </div>
          </div>
          <h3 class="user-name">Michael Jackson</h3>
          <p class="user-title">SMAN 1 Bekasi</p>
          <div class="quote-icon fas fa-quote-right"></div>
          <p class="testimonial-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div> -->

        <!-- Card 3 -->
        <!-- <div class="testimonial-card">
          <div class="profile-container">
            <div class="profile-ring">
              <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200&h=200&fit=crop&crop=face" alt="User Image" class="profile-image">
            </div>
          </div>
          <h3 class="user-name">Michael Jackson</h3>
          <p class="user-title">SMAN 1 Bekasi</p>
          <div class="quote-icon fas fa-quote-right"></div>
          <p class="testimonial-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
      </div>
    </div> -->

    <!-- Navigation Dots -->
    <!-- <div class="testimonial-nav">
      <div class="nav-dot" onclick="goToSlide(0)"></div>
      <div class="nav-dot active" onclick="goToSlide(1)"></div>
      <div class="nav-dot" onclick="goToSlide(2)"></div>
    </div>
  </div>
</section> -->

@endsection
