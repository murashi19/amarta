@extends('layouts.app')


@section('content')

<!-- Konten 1: Program Unggulan -->
<!-- Konten 1: Program Unggulan -->
<section id="program-unggulan" class="py-5 mb-2 mb-md-0">
  <div class="container h-100">
    <div class="section-title">
      <h1 class="text-center fw-bold mb-4 judul-section">
        Program <span>Andalan Kita:</span>
      </h1>
      <div class="underline"></div>
    </div>

    <!-- Carousel -->
    <div id="carouselProgram" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">

        <!-- Slide 1 -->
        <div class="carousel-item active">
          <div class="row align-items-center g-4">
            <div class="col-md-6">
              <div class="ratio ratio-4x3">
                <img src="asset/img/photo (30).jpg" class="img-fluid rounded-4 shadow-sm" style="object-fit: cover;" alt="Program Pemagangan Jepang" />
              </div>
            </div>
            <div class="col-md-6 d-flex flex-column justify-content-center">
              <h3 class="fw-bold mb-3">Program Pemagangan ke Jepang</h3>
              <p class="mb-4">Ikuti program pemagangan resmi ke Jepang yang dirancang untuk membekali peserta dengan keterampilan dan etos kerja unggul.</p>
              <button class="button-primary px-4 py-2">Lebih Lengkap..</button>
            </div>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item">
          <div class="row align-items-center g-4">
            <div class="col-md-6">
              <div class="ratio ratio-4x3">
                <img src="asset/img/photo (33).jpg" class="img-fluid rounded-4 shadow-sm" style="object-fit: cover;" alt="Program Tokutei Ginou" />
              </div>
            </div>
            <div class="col-md-6 d-flex flex-column justify-content-center">
              <h3 class="fw-bold mb-3">Program Tokutei Ginou (Specified Skilled Worker)</h3>
              <p class="mb-4">Persiapan kerja di Jepang dengan status visa kerja Tokutei Ginou di berbagai bidang seperti perhotelan, pertanian, dan kesehatan.</p>
              <button class="button-primary px-4 py-2">Lebih Lengkap..</button>
            </div>
          </div>
        </div>

        <!-- Slide 3 -->
        <div class="carousel-item">
          <div class="row align-items-center g-4">
            <div class="col-md-6">
              <div class="ratio ratio-4x3">
                <img src="asset/img/photo2 (30).jpg" class="img-fluid rounded-4 shadow-sm" style="object-fit: cover;" alt="Program Nihongo Gakkou" />
              </div>
            </div>
            <div class="col-md-6 d-flex flex-column justify-content-center">
              <h3 class="fw-bold mb-3">Program Nihongo Gakkou</h3>
              <p class="mb-4">Belajar di sekolah bahasa Jepang (Nihongo Gakkou) sebagai jalan menuju pendidikan lanjutan atau karir profesional di Jepang.</p>
              <button class="button-primary px-4 py-2">Lebih Lengkap..</button>
            </div>
          </div>
        </div>

        <!-- Slide 4 -->
        <div class="carousel-item">
          <div class="row align-items-center g-4">
            <div class="col-md-6">
              <div class="ratio ratio-4x3">
                <img src="asset/img/photo2 (29).jpg" class="img-fluid rounded-4 shadow-sm" style="object-fit: cover;" alt="Program Engineering Jepang" />
              </div>
            </div>
            <div class="col-md-6 d-flex flex-column justify-content-center">
              <h3 class="fw-bold mb-3">Program Engineering Jepang</h3>
              <p class="mb-4">Kesempatan untuk bekerja di Jepang sebagai engineer dengan pelatihan khusus dan dukungan penempatan kerja langsung.</p>
              <button class="button-primary px-4 py-2">Lebih Lengkap..</button>
            </div>
          </div>
        </div>

      </div>
            <!-- Controls -->
            <button class="carousel-control-prev d-none d-md-block" type="button" data-bs-target="#carouselProgram" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next d-none d-md-block" type="button" data-bs-target="#carouselProgram" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>

            <!-- Indicators -->
            <div class="carousel-indicators mt-4">
            <button type="button" data-bs-target="#carouselProgram" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselProgram" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselProgram" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
        </div>
    </div>
</section>

<!-- Konten 2 -->
<section id="program-tambahan" class="d-flex justify-content-center align-items-center py-4 py-md-5 mb-5 mb-md-0">
  <div class="container">
    <div class="row justify-content-center g-3 g-md-4">
      <!-- Card 1 -->
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card card-program active-card text-center card-mobile-size">
          <div class="card-body d-flex align-items-center justify-content-center py-3 py-md-4">
            <h5 class="card-title fw-bold m-0 fs-6 fs-md-5">Sistem Dana <br> Talang</h5>
          </div>
        </div>
      </div>
      
      <!-- Card 2 -->
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card card-program text-center card-mobile-size">
          <div class="card-body d-flex align-items-center justify-content-center py-3 py-md-4">
            <h5 class="card-title fw-bold m-0 fs-6 fs-md-5">Pengurusan Dokumen Oleh PT</h5>
          </div>
        </div>
      </div>
      
      <!-- Card 3 -->
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card card-program text-center card-mobile-size">
          <div class="card-body d-flex align-items-center justify-content-center py-3 py-md-4">
            <h5 class="card-title fw-bold m-0 fs-6 fs-md-5">Supporting Awal sampai Akhir</h5>
          </div>
        </div>
      </div>
      
      <!-- Card 4 -->
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card card-program text-center card-mobile-size">
          <div class="card-body d-flex align-items-center justify-content-center py-3 py-md-4">
            <h5 class="card-title fw-bold m-0 fs-6 fs-md-5">Mengirim <br> Pemagang Tiap Tahun</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Konten 3 - Final -->
<section id="kegiatan-kami" class="mt-5 mt-md-0">
  <div class="container">
    <div class="kegiatan-section">
      <h1 class="section-title">Kegiatan Kami</h1>

      <div class="carousel-section2">
        <button class="nav-button2 nav-prev2" onclick="previousSlide()">
          <i class="fa fa-chevron-left"></i>
        </button>

        <div class="carousel-container2">
          <div class="carousel-wrapper2" id="carouselWrapper">
            <!-- Kegiatan 1 -->
            <div class="carousel-item2">
              <div class="item-image2">
                <img src="asset/img/photo2 (36).jpg" alt="Kelas Pemantapan" loading="lazy">
              </div>
              <div class="item-content2">
                <p class="item-description">
                  Kegiatan kelas pemantapan materi bahasa Jepang dan pembekalan kerja sebelum peserta menghadapi wawancara kerja dan proses keberangkatan.
                </p>
              </div>
            </div>

            <!-- Kegiatan 2 -->
            <div class="carousel-item2">
              <div class="item-image2">
                <img src="asset/img/photo2 (35).jpg" alt="Kelas Olahraga Fisik" loading="lazy">
              </div>
              <div class="item-content2">
                <p class="item-description">
                  Latihan fisik rutin yang dilakukan peserta untuk menjaga kesehatan jasmani dan disiplin sebelum keberangkatan ke Jepang.
                </p>
              </div>
            </div>

            <!-- Kegiatan 3 -->
            <div class="carousel-item2">
              <div class="item-image2">
                <img src="asset/img/photo2 (45).jpg" alt="Ujian Bahasa dan Interview" loading="lazy">
              </div>
              <div class="item-content2">
                <p class="item-description">
                  Ujian dan simulasi wawancara kerja langsung dilakukan oleh tim LPK sebagai bentuk evaluasi kesiapan kerja ke Jepang.
                </p>
              </div>
            </div>
          </div>
        </div>

        <button class="nav-button2 nav-next2" onclick="nextSlide()">
          <i class="fa fa-chevron-right"></i>
        </button>
        <div class="carousel-indicators" id="indicators">
          <!-- Diisi lewat JS -->
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Gallery Section -->
<section id="gallery">
  <div class="gallery-header">
    <h1 class="text-white">Gallery</h1>
  </div>
  <h3 class="h3">
    Kumpulan momen terbaik dari berbagai kegiatan kami
  </h3>
  <div class="container h-100">
    <!-- Gallery Section dengan Coverflow 3D -->
    <div class="swiper">
      <div class="swiper-wrapper">
        
        <!-- Loop dari photo2 (42) sampai photo2 (59) -->
        <div class="swiper-slide">
          <img src="asset/img/photo2 (42).jpg" alt="Gallery 42">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (43).jpg" alt="Gallery 43">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (44).jpg" alt="Gallery 44">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (45).jpg" alt="Gallery 45">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (46).jpg" alt="Gallery 46">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (47).jpg" alt="Gallery 47">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (48).jpg" alt="Gallery 48">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (49).jpg" alt="Gallery 49">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (50).jpg" alt="Gallery 50">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (51).jpg" alt="Gallery 51">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (52).jpg" alt="Gallery 52">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (53).jpg" alt="Gallery 53">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (54).jpg" alt="Gallery 54">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (55).jpg" alt="Gallery 55">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (56).jpg" alt="Gallery 56">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (57).jpg" alt="Gallery 57">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (58).jpg" alt="Gallery 58">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (59).jpg" alt="Gallery 59">
        </div>

      </div>
    </div>
  </div>
</section>


        <!-- Pagination -->
        <div class="swiper-pagination"></div>

        <!-- Navigation -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
      </div>
    </div>
  </section>

@push('scripts')
    <script>
        // ================================= ENHANCED GALLERY SWIPER =================================
        const GallerySwiper = {
            swiper: null,
            isMobile: window.innerWidth <= 768,

            init() {
                // Pastikan DOM sudah ready
                const swiperContainer = document.querySelector('.swiper');
                if (!swiperContainer) {
                    console.warn('Swiper container not found');
                    return;
                }

                // Check if we're on mobile
                this.isMobile = window.innerWidth <= 768;
                console.log('Device type:', this.isMobile ? 'Mobile' : 'Desktop');

                try {
                    this.swiper = new Swiper('.swiper', {
                        // Effect - Use different effects for mobile vs desktop
                        effect: this.isMobile ? 'slide' : 'coverflow',
                        grabCursor: true,
                        centeredSlides: true,
                        slidesPerView: 'auto',
                        initialSlide: 2,

                        // Touch Settings - CRITICAL for mobile
                        touchRatio: 1,
                        touchAngle: 45,
                        simulateTouch: true,
                        allowTouchMove: true,
                        touchStartPreventDefault: false,
                        touchStartForcePreventDefault: false,
                        touchMoveStopPropagation: false,
                        resistanceRatio: 0.85,

                        // Swipe Settings
                        threshold: 10,
                        longSwipesRatio: 0.5,
                        longSwipesMs: 300,
                        followFinger: true,

                        // Coverflow Effect Parameters (for desktop)
                        coverflowEffect: {
                            rotate: 60,
                            stretch: 80,
                            depth: 200,
                            modifier: 1.5,
                            slideShadows: true,
                        },

                        // Loop Configuration
                        loop: true,
                        loopedSlides: 8, // Match your slide count

                        // Autoplay Configuration - Different for mobile
                        autoplay: this.isMobile ? {
                            delay: 4000,
                            disableOnInteraction: false,
                            pauseOnMouseEnter: false, // Mouse events don't apply on mobile
                        } : {
                            delay: 3500,
                            disableOnInteraction: false,
                            pauseOnMouseEnter: true,
                        },

                        // Speed and Animation
                        speed: this.isMobile ? 600 : 800,

                        // Pagination
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                            dynamicBullets: true,
                            dynamicMainBullets: this.isMobile ? 3 : 5,
                        },

                        // Navigation - Make sure it works on mobile
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },

                        // Keyboard Control - Disable on mobile
                        keyboard: {
                            enabled: !this.isMobile,
                            onlyInViewport: true,
                        },

                        // Mouse wheel control - Disable on mobile
                        mousewheel: this.isMobile ? false : {
                            thresholdDelta: 70,
                            sensitivity: 1,
                        },

                        // Enhanced Responsive Breakpoints
                        breakpoints: {
                            // Mobile Portrait
                            320: {
                                effect: 'slide',
                                slidesPerView: 1,
                                spaceBetween: 20,
                                centeredSlides: true,
                                coverflowEffect: {
                                    rotate: 0,
                                    stretch: 0,
                                    depth: 0,
                                    modifier: 1,
                                    slideShadows: false,
                                },
                                touchRatio: 1.5, // More sensitive on small screens
                                longSwipesRatio: 0.3,
                            },
                            // Mobile Landscape / Small Tablet
                            480: {
                                effect: 'slide',
                                slidesPerView: 1.2,
                                spaceBetween: 15,
                                centeredSlides: true,
                                touchRatio: 1.3,
                                coverflowEffect: {
                                    rotate: 0,
                                    stretch: 0,
                                    depth: 0,
                                    modifier: 1,
                                    slideShadows: false,
                                }
                            },
                            // Tablet
                            640: {
                                effect: 'coverflow',
                                slidesPerView: 2.2,
                                spaceBetween: -40,
                                coverflowEffect: {
                                    rotate: 35,
                                    stretch: 40,
                                    depth: 120,
                                    modifier: 1.2,
                                    slideShadows: true,
                                }
                            },
                            // Large Tablet
                            768: {
                                effect: 'coverflow',
                                slidesPerView: 2.5,
                                spaceBetween: -45,
                                coverflowEffect: {
                                    rotate: 45,
                                    stretch: 60,
                                    depth: 150,
                                    modifier: 1.3,
                                    slideShadows: true,
                                }
                            },
                            // Desktop
                            1024: {
                                effect: 'coverflow',
                                slidesPerView: 3,
                                spaceBetween: -50,
                                coverflowEffect: {
                                    rotate: 60,
                                    stretch: 80,
                                    depth: 200,
                                    modifier: 1.5,
                                    slideShadows: true,
                                }
                            }
                        },

                        // Enhanced Events
                        on: {
                            init: function () {
                                console.log('Swiper initialized successfully');
                                console.log('Current breakpoint:', this.currentBreakpoint);
                                console.log('Slides per view:', this.params.slidesPerView);
                                
                                document.querySelector('.swiper')?.classList.add('loaded');
                                
                                // Add mobile-specific class
                                if (GallerySwiper.isMobile) {
                                    document.querySelector('.swiper')?.classList.add('mobile-mode');
                                }
                            },

                            slideChange: function () {
                                console.log('Slide changed to:', this.activeIndex);
                                const activeSlide = document.querySelector('.swiper-slide-active');
                                if (activeSlide && !GallerySwiper.isMobile) {
                                    activeSlide.style.animation = 'none';
                                    setTimeout(() => {
                                        activeSlide.style.animation = 'pulse 0.6s ease-in-out';
                                    }, 10);
                                }
                            },

                            touchStart: function (swiper, event) {
                                console.log('Touch start detected');
                                this.autoplay.stop();
                            },

                            touchMove: function (swiper, event) {
                                // Optional: Add visual feedback during swipe
                                console.log('Touch move detected');
                            },

                            touchEnd: function (swiper, event) {
                                console.log('Touch end detected');
                                setTimeout(() => {
                                    if (this.autoplay) {
                                        this.autoplay.start();
                                    }
                                }, 2000);
                            },

                            transitionStart: function () {
                                console.log('Transition started');
                            },

                            transitionEnd: function () {
                                console.log('Transition ended');
                            },

                            reachBeginning: function () {
                                console.log('Reached beginning');
                            },

                            reachEnd: function () {
                                console.log('Reached end');
                            },

                            navigationNext: function () {
                                console.log('Next button clicked');
                            },

                            navigationPrev: function () {
                                console.log('Previous button clicked');
                            },

                            resize: function () {
                                console.log('Swiper resized');
                                // Update mobile status on resize
                                GallerySwiper.isMobile = window.innerWidth <= 768;
                            }
                        }
                    });

                    // Add CSS for animations
                    this.addCustomStyles();

                    // Add enhanced interaction effects (desktop only)
                    if (!this.isMobile) {
                        this.addInteractionEffects();
                    }

                    // Add mobile-specific enhancements
                    if (this.isMobile) {
                        this.addMobileEnhancements();
                    }

                    console.log('Gallery Swiper initialized successfully for', this.isMobile ? 'mobile' : 'desktop');

                } catch (error) {
                    console.error('Error initializing Swiper:', error);
                    console.error('Error stack:', error.stack);
                }
            },

            addCustomStyles() {
                const existingStyle = document.getElementById('swiper-custom-styles');
                if (existingStyle) return;

                const style = document.createElement('style');
                style.id = 'swiper-custom-styles';
                style.textContent = `
                    @keyframes pulse {
                        0% { transform: scale(1.1); }
                        50% { transform: scale(1.15); }
                        100% { transform: scale(1.1); }
                    }

                    /* Mobile-specific styles */
                    .swiper.mobile-mode .swiper-slide {
                        transition: all 0.3s ease !important;
                    }

                    .swiper.mobile-mode .swiper-slide-active {
                        transform: scale(1.05) !important;
                    }

                    /* Enhanced touch feedback */
                    .swiper-slide {
                        user-select: none;
                        -webkit-user-select: none;
                        -webkit-touch-callout: none;
                        -webkit-tap-highlight-color: transparent;
                    }

                    /* Better navigation buttons for mobile */
                    @media (max-width: 768px) {
                        .swiper-button-next,
                        .swiper-button-prev {
                            width: 44px !important;
                            height: 44px !important;
                            margin-top: -22px !important;
                        }
                        
                        .swiper-button-next:after,
                        .swiper-button-prev:after {
                            font-size: 18px !important;
                        }
                    }
                `;
                document.head.appendChild(style);
            },

            addInteractionEffects() {
                // Wait for slides to be ready
                setTimeout(() => {
                    const slides = document.querySelectorAll('.swiper-slide');
                    slides.forEach(slide => {
                        slide.addEventListener('mouseenter', function () {
                            if (!this.classList.contains('swiper-slide-active')) {
                                this.style.transform += ' translateY(-10px)';
                            }
                        });

                        slide.addEventListener('mouseleave', function () {
                            if (!this.classList.contains('swiper-slide-active')) {
                                this.style.transform = this.style.transform.replace(' translateY(-10px)', '');
                            }
                        });
                    });
                }, 500);
            },

            addMobileEnhancements() {
                // Add swipe indicators or hints for mobile users
                setTimeout(() => {
                    const swiperContainer = document.querySelector('.swiper');
                    if (swiperContainer && !document.querySelector('.swipe-hint')) {
                        const hint = document.createElement('div');
                        hint.className = 'swipe-hint';
                        hint.innerHTML = '← Swipe →';
                        hint.style.cssText = `
                            position: absolute;
                            bottom: 10px;
                            left: 50%;
                            transform: translateX(-50%);
                            color: rgba(255,255,255,0.7);
                            font-size: 12px;
                            z-index: 10;
                            pointer-events: none;
                            animation: fadeInOut 3s ease-in-out;
                        `;
                        
                        swiperContainer.appendChild(hint);
                        
                        // Remove hint after animation
                        setTimeout(() => {
                            hint.remove();
                        }, 3000);
                    }
                }, 1000);

                // Add fade in/out animation for hint
                const style = document.createElement('style');
                style.textContent = `
                    @keyframes fadeInOut {
                        0%, 100% { opacity: 0; }
                        50% { opacity: 1; }
                    }
                `;
                document.head.appendChild(style);
            },

            // Enhanced debugging method
            checkStatus() {
                console.log('=== SWIPER DEBUG INFO ===');
                console.log('Swiper instance:', this.swiper);
                console.log('Is mobile:', this.isMobile);
                console.log('Window width:', window.innerWidth);
                
                if (this.swiper) {
                    console.log('Swiper initialized:', this.swiper.initialized);
                    console.log('Current effect:', this.swiper.params.effect);
                    console.log('Slides per view:', this.swiper.params.slidesPerView);
                    console.log('Touch enabled:', this.swiper.allowTouchMove);
                    console.log('Autoplay status:', this.swiper.autoplay?.running);
                }

                this.checkNavigation();
                this.checkSlides();
            },

            checkNavigation() {
                const nextBtn = document.querySelector('.swiper-button-next');
                const prevBtn = document.querySelector('.swiper-button-prev');

                console.log('Next button exists:', !!nextBtn);
                console.log('Previous button exists:', !!prevBtn);

                if (nextBtn) {
                    console.log('Next button classes:', nextBtn.className);
                    console.log('Next button disabled:', nextBtn.classList.contains('swiper-button-disabled'));
                }
                if (prevBtn) {
                    console.log('Previous button classes:', prevBtn.className);
                    console.log('Previous button disabled:', prevBtn.classList.contains('swiper-button-disabled'));
                }
            },

            checkSlides() {
                const slides = document.querySelectorAll('.swiper-slide');
                console.log('Total slides found:', slides.length);
                
                if (this.swiper) {
                    console.log('Active slide index:', this.swiper.activeIndex);
                    console.log('Real index:', this.swiper.realIndex);
                }
            },

            // Method to manually trigger slide change (for testing)
            testSlide(direction = 'next') {
                if (this.swiper) {
                    if (direction === 'next') {
                        this.swiper.slideNext();
                    } else {
                        this.swiper.slidePrev();
                    }
                }
            },

            // Reinitialize swiper (useful for debugging)
            reinit() {
                this.destroy();
                setTimeout(() => {
                    this.init();
                }, 100);
            },

            destroy() {
                if (this.swiper) {
                    this.swiper.destroy(true, true);
                    this.swiper = null;
                    console.log('Swiper destroyed');
                }
            }
        };
    </script>
@endpush
@endsection