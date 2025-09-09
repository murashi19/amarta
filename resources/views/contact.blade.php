@extends('layouts.app')

@section('content')

@push('styles')
    <style>
        .hero-carousel-section {
            position: relative;
            overflow: hidden;
            height: 400px;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .hero-carousel-section .container-fluid {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        /* Slider */
        .carousel-item {
            height: 400px;
            position: relative;
        }

        /* Gambar */
        .carousel-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(50%) saturate(100%);
            transition: filter 0.2s ease-in-out;
        }

        /* Caption */
        .carousel-caption {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
        }

        .carousel-caption h1 {
            font-size: 3.5rem;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .carousel-caption p {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            max-width: 800px;
            margin: 0 auto;
        }

        /* Line */
        .wave-line {
            margin: 15px auto;
            display: block;
        }

        .wave-line svg {
            width: 100px;
            height: 20px;
        }

        .wave-line path {
            stroke: #fff;
            stroke-width: 2;
            fill: none;
        }

        /* Tombol */
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.4);
            border-radius: 50%;
            padding: 15px;
        }

        .text-white-75 {
            color: rgba(255, 255, 255, 0.75) !important;
        }

        /* KONTEN 2 FORM AND MAP */
        .section-title-custom {
            font-size: 2.2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1.5rem;
        }

        .form-control {
            border-radius: 0.5rem;
            padding: 0.8rem 1rem;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
        }

        .form-control::placeholder {
            color: #6c757d;
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            background-color: #fff;
        }

        .button-dark-blue {
            background-color: var(--color-primary); /* Menggunakan --color-primary */
            border-color: var(--color-primary);
            color: #fff;
            font-weight: 600;
            transition: var(--transition-normal);
        }

        .button-dark-blue:hover {
            background-color: var(--color-hover); /* Menggunakan --color-hover */
            border-color: var(--color-hover);
            color: var(
                --color-dark
            ); /* Teks tombol jadi dark saat hover di biru muda */
        }

        .map-container {
            border: 1px solid #e0e0e0;
        }

        .map-container iframe {
            display: block;
        }

        /* === KONTEN 3 CONTACT CARDS === */
        #contact-cards {
            background-color: #f8f9fa;
        }

        .contact-card {
            background-color: #ffffff; /* Semua card default background PUTIH */
            border-radius: 1rem;
            padding: 2.5rem 1.5rem;
            text-align: center;
            box-shadow: var(--shadow-md); /* Menggunakan variabel shadow */
            transition: var(--transition-normal); /* Menggunakan variabel transition */
            position: relative;
            overflow: hidden;
            z-index: 1;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #333; /* Warna teks default HITAM */
            will-change: transform, box-shadow, color;
        }

        .contact-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(
                --color-hover
            ); /* Warna overlay BIRU MUDA saat hover */
            border-radius: 1rem;
            z-index: -1;
            transform: scaleY(0); /* Awalnya tersembunyi */
            transform-origin: bottom;
            transition: transform 0.3s ease;
        }

        /* Hover effect for all contact cards - UNIFORM BLUE HOVER */
        .contact-card:hover {
            transform: translateY(-10px); /* Naik sedikit */
            box-shadow: var(--shadow-lg); /* Bayangan lebih jelas */
            /* Background card tetap putih, karena overlay ::before yang akan memberi warna biru */
            color: var(
                --color-dark
            ); /* Teks di dalam card berubah menjadi warna gelap (--color-dark) */
        }

        .contact-card:hover::before {
            transform: scaleY(1); /* Tampilkan overlay biru muda */
        }

        /* Pastikan icon, title, dan description berubah warna saat hover */
        .contact-card:hover .contact-title,
        .contact-card:hover .contact-description {
            color: var(
                --color-dark
            ); /* Ubah warna semua elemen teks/ikon menjadi warna gelap (--color-dark) saat di-hover */
            z-index: 2;
            position: relative;
        }

        /* Default colors for icon circles (background color) */
        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            font-size: 1.8rem;
            transition: background-color 0.3s ease, color 0.3s ease;
            z-index: 2;
            position: relative;
            color: #fff; /* Warna ikon di dalam lingkaran defaultnya putih */
        }

        .whatsapp-green {
            background-color: #25d366; /* WhatsApp Green */
        }

        .email-red {
            background-color: #ea4335; /* Gmail/Google Red */
        }

        .phone-blue {
            background-color: var(
                --color-primary
            ); /* Menggunakan --color-primary untuk biru ikon telepon */
        }

        /* Tidak perlu penyesuaian spesifik untuk whatsapp-card:hover::before atau icon-circle di sini
        karena semua sudah diatur oleh .contact-card:hover::before dan .contact-card:hover .icon-circle
        agar seragam biru muda. */

        .contact-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .contact-description {
            font-size: 0.95rem;
            color: #6c757d; /* Warna teks deskripsi default abu-abu */
            line-height: 1.5;
        }

        /* Override deskripsi saat hover */
        .contact-card:hover .contact-description {
            color: var(
                --color-dark
            ); /* Saat hover, teks deskripsi menjadi warna gelap */
        }

        /*========================================
              FAQ SECTION
            ========================================*/

        #faq-section .underline {
            width: 580px; /* Lebar garis bawah */
            height: 4px; /* Tinggi garis bawah */
            background-color: var(--color-primary); /* Warna garis bawah */
            margin-top: 10px;
            margin-bottom: 25px;
            border-radius: 2px;
        }

        .accordion-item {
            border: 1px solid #e0e0e0;
            margin-bottom: 10px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .accordion-header .accordion-button {
            background-color: white;
            color: var(--color-dark);
            font-weight: 600;
            padding: 15px 20px;
            border: none;
            width: 100%;
            text-align: left;
            transition: background-color 0.3s ease;
            border-radius: 8px; /* Pastikan radius sudut tetap saat belum terbuka */
        }

        .accordion-header .accordion-button:hover {
            background-color: var(--color-light); /* Warna hover sedikit abu-abu */
        }

        .accordion-header .accordion-button:not(.collapsed) {
            background-color: var(
                --color-primary
            ); /* Warna background saat aktif/terbuka */
            color: white; /* Warna teks saat aktif/terbuka */
            box-shadow: none;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

        .accordion-header .accordion-button:focus {
            box-shadow: none;
            border-color: transparent;
        }

        .accordion-body {
            padding: 15px 20px;
            border-top: 1px solid #e0e0e0;
            background-color: #fcfcfc;
            color: #555;
        }

        /* Style untuk icon di accordion button */
        .accordion-button::after {
            flex-shrink: 0;
            width: 1.25rem;
            height: 1.25rem;
            margin-left: auto;
            content: "";
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23212529'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-size: 1.25rem;
            transition: transform 0.2s ease-in-out;
        }

        .accordion-button:not(.collapsed)::after {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e"); /* Warna putih saat terbuka */
            transform: rotate(-180deg);
        }

        /*========================================
          SYARAT HERO SECTION
        ========================================*/
        #syarat-hero {
            position: relative;
            overflow: hidden;
            min-height: 50vh; /* Sesuaikan tinggi sesuai keinginan */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background-color: var(--color-primary); /* Menggunakan variabel Anda */
            /* GANTI DENGAN PATH RELATIF YANG SESUAI DARI app.css KE GAMBAR */
            /* Contoh: jika app.css di public/css/ dan gambar di public/Asset/img/ */
            background-image: url("../Asset/img/syarat-hero-bg.jpg"); /* Pastikan path ini benar! */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: white;
        }

        #syarat-hero::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(
                0,
                0,
                0,
                0.4
            ); /* Overlay gelap agar teks lebih mudah dibaca */
            z-index: 1;
        }

        #syarat-hero .container {
            position: relative;
            z-index: 2;
        }

        #syarat-hero h1 {
            font-weight: 700;
            font-size: clamp(2.5rem, 5vw, 4rem);
        }

        #syarat-hero p {
            font-size: clamp(1rem, 2vw, 1.25rem);
        }

        /*========================================
          SYARAT DETAIL SECTION
        ========================================*/
        .syarat-detail {
            padding-top: 6rem;
            padding-bottom: 6rem;
            background-color: var(
                --color-bg-light
            ); /* Menggunakan variabel Anda untuk bg-light */
        }

        .syarat-detail h2.text-primary {
            font-weight: 700;
            color: var(--color-primary); /* Menggunakan variabel Anda */
        }

        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: var(--shadow-sm); /* Menggunakan variabel shadow Anda */
            transition: var(
                --transition-normal
            ); /* Menggunakan variabel transition Anda */
            background-color: white;
            padding: 15px; /* Padding di dalam card */
        }

        .card-custom:hover {
            transform: translateY(-5px); /* Efek naik saat hover */
            box-shadow: var(--shadow-md); /* Menggunakan variabel shadow Anda */
        }

        .card-custom .card-title {
            font-weight: 600;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }

        .card-custom .card-title i {
            font-size: 1.8rem;
            color: var(--color-primary); /* Menggunakan variabel Anda */
        }

        .card-custom ul {
            padding-left: 0; /* Hapus padding default UL */
        }

        .card-custom ul li {
            margin-bottom: 10px;
            font-size: 1.05rem;
            color: var(--color-dark); /* Menggunakan variabel dark Anda */
            display: flex;
            align-items: flex-start;
        }

        .card-custom ul li i {
            margin-top: 5px; /* Menyelaraskan icon dengan teks */
            margin-right: 10px;
            color: var(--color-info); /* Menggunakan variabel info Anda */
            font-size: 1.1rem;
        }

        /*========================================
          MARKETING CALL TO ACTION SECTION
        ========================================*/
        .marketing-cta {
            background-color: var(--color-primary); /* Menggunakan variabel Anda */
            padding: 4rem 0;
        }

        .marketing-cta h2 {
            font-weight: 700;
            color: white;
        }

        .marketing-cta p.lead {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.3rem;
        }

        .marketing-cta .btn-warning {
            background-color: var(--color-warning); /* Menggunakan variabel Anda */
            border-color: var(--color-warning); /* Menggunakan variabel Anda */
            color: var(
                --color-dark
            ); /* Teks gelap agar kontras, menggunakan variabel Anda */
            font-weight: 700;
            border-radius: 50px; /* Bentuk pil */
            padding: 12px 30px;
            transition: var(
                --transition-normal
            ); /* Menggunakan variabel transition Anda */
        }

        .marketing-cta .btn-warning:hover {
            background-color: #e6b300; /* Kuning lebih gelap saat hover (nilai hex manual) */
            border-color: #e6b300;
            transform: translateY(-2px);
        }

        .marketing-cta .btn-outline-light {
            color: white;
            border-color: white;
            font-weight: 600;
            border-radius: 50px; /* Bentuk pil */
            padding: 12px 30px;
            transition: var(
                --transition-normal
            ); /* Menggunakan variabel transition Anda */
        }

        .marketing-cta .btn-outline-light:hover {
            background-color: white;
            color: var(--color-primary); /* Menggunakan variabel Anda */
            transform: translateY(-2px);
        }

        body {
            font-family: "Poppins", sans-serif; /* Already in your provided CSS */
            color: var(--color-dark); /* Already in your provided CSS */
            background-color: var(
                --color-bg-light
            ); /* Assuming this is your general background */
        }

        /* Headings in form should match section titles */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "Poppins", sans-serif;
            color: var(--color-dark); /* Match your section-title h1 */
            font-weight: 700; /* As defined in section-title h1 */
        }

        /* Form labels to match your general text/label style */
        .form-label {
            font-weight: 500; /* As per your button font-weight */
            color: var(--color-dark); /* Consistent with body text */
        }

        /* Multi-step form container and progress indicators */
        .form-step {
            display: none;
            padding: 30px;
            border: 1px solid #e0e0e0; /* A lighter border if not defined in your vars */
            border-radius: 12px;
            background-color: #ffffff; /* White background for the form steps themselves */
            box-shadow: var(--shadow-md); /* Using your defined shadow-md */
            margin-bottom: 30px;
        }
        .form-step.active {
            display: block;
        }
        .form-navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        .form-progress {
            display: flex;
            justify-content: center;
            margin-bottom: 40px;
        }
        .form-progress-step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--color-light); /* Use your light color */
            color: var(--color-dark); /* Use your dark color for inactive numbers */
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 15px;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition-normal); /* Use your transition var */
            border: 2px solid var(--color-light); /* Border to match background */
        }
        .form-progress-step.active {
            background-color: var(--color-primary); /* Your primary blue */
            color: var(--color-light); /* White for active number */
            border-color: var(--color-primary);
            box-shadow: var(--shadow-sm); /* Subtle shadow for active step */
        }
        .form-progress-step.completed {
            background-color: var(--color-success); /* Your success green */
            color: var(--color-light);
            border-color: var(--color-success);
        }

        /* Input Field Styling (consistent with Bootstrap but adjusted to your colors/radius) */
        .form-control,
        .form-select,
        .form-check-input {
            border-color: #ced4da; /* A neutral gray for input borders */
            border-radius: 8px; /* Match button radius */
            padding: 0.75rem 1rem;
            transition: var(--transition-fast); /* Use your fast transition */
        }
        .form-control:focus,
        .form-select:focus {
            border-color: var(--color-primary); /* Primary color on focus */
            box-shadow: 0 0 0 0.25rem rgba(13, 94, 166, 0.25); /* Using var(--color-primary) for rgba */
        }
        .form-control.is-invalid,
        .form-select.is-invalid,
        .form-check-input.is-invalid {
            border-color: var(--color-danger); /* Red border for invalid fields */
        }
        .invalid-feedback {
            color: var(--color-danger); /* Red text for validation messages */
        }

        /* Job Experience dynamic fields styling */
        .job-entry {
            background-color: var(
                --color-bg-light
            ); /* Lighter background for job entries */
            border-color: #e0e0e0;
            padding: 20px;
            margin-bottom: 20px;
        }

        /* Horizontal Rule */
        hr {
            border-top: 2px solid rgba(0, 0, 0, 0.1);
        }

        /* Specific overrides for button classes not conflicting with Bootstrap btn base */
        /* If you have global Bootstrap CSS, these might need !important if not overriding directly */
        .button-dark {
            height: auto; /* Bootstrap btn has padding, so height isn't needed here */
            padding: 10px 20px; /* Adjust padding to match your desired button size if not set by Bootstrap */
        }
    </style>
@endpush

    <section id="contact-hero" class="hero-carousel-section">
        <div class="container-fluid p-0"> {{-- Use container-fluid and remove padding to make carousel full width if desired --}}
            <div id="contactUsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner">
                    {{-- Carousel Item 1 --}}
                    <div class="carousel-item active">
                        <img src="asset/img/photo (21).jpg" class="d-block w-100 carousel-image" alt="Image 1">
                        <div class="carousel-caption d-flex align-items-center justify-content-center h-100">
                            <div class="text-center">
                                <h1 class="display-3 fw-bold text-white">{{__('app.contactus')}}</h1>
                                <div class="wave-line">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="20" viewBox="0 0 100 20">
                                        <path d="M0,10 Q25,0 50,10 T100,10" stroke="#fff" stroke-width="2" fill="none"/>
                                    </svg>
                                </div>
                                <p class="lead text-white-75 mt-3">{{__('app.text')}}</p>
                            </div>
                        </div>
                    </div>
                    {{-- Carousel Item 2 --}}
                    <div class="carousel-item">
                        <img src="asset/img/photo (30).jpg" class="d-block w-100 carousel-image" alt="Image 2">
                        <div class="carousel-caption d-flex align-items-center justify-content-center h-100">
                            <div class="text-center">
                                <h1 class="display-3 fw-bold text-white">{{__('app.ourlocation')}}</h1>
                                <div class="wave-line">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="20" viewBox="0 0 100 20">
                                        <path d="M0,10 Q25,0 50,10 T100,10" stroke="#fff" stroke-width="2" fill="none"/>
                                </svg>
                                </div>
                                <p class="lead text-white-75 mt-3">{{__('app.text2')}}</p>
                            </div>
                        </div>
                    </div>
                    {{-- Carousel Item 3 --}}
                    <div class="carousel-item">
                        <img src="asset/img/photo (22).jpg" class="d-block w-100 carousel-image" alt="Image 3">
                        <div class="carousel-caption d-flex align-items-center justify-content-center h-100">
                            <div class="text-center">
                                <h1 class="display-3 fw-bold text-white">{{__('app.getintouch')}}</h1>
                                <div class="wave-line">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="20" viewBox="0 0 100 20">
                                        <path d="M0,10 Q25,0 50,10 T100,10" stroke="#fff" stroke-width="2" fill="none"/>
                                    </svg>
                                </div>
                                <p class="lead text-white-75 mt-3">{{__('app.text3')}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Carousel Controls (Optional, tapi disarankan) --}}
                <button class="carousel-control-prev" type="button" data-bs-target="#contactUsCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#contactUsCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <section id="contact-form-map" class="py-5">
        <div class="container"> {{-- Ini adalah container kedua --}}
            <div class="row">
                {{-- Kolom Kiri: Form Kirim Pesan --}}
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="section-title-custom">{{__('app.title_form')}}</h2>
                        <p class="mb-4 text-muted">
                            {{__('app.text_form')}}
                        </p>
                    <form id="contactForm">
                        <div class="row gx-3 mb-3"> {{-- Menggunakan gx-3 untuk gap horizontal antar kolom --}}
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="nama" placeholder="Nama" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control" id="email" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="telepon" placeholder="Nomor Telepon" required>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="subjek" placeholder="Subjek" required>
                            </div>
                        </div>
                        <div class="mb-4"> {{-- mb-4 untuk margin bawah textarea --}}
                            <textarea class="form-control" id="pesan" rows="5" placeholder="Pesan" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary button-dark-blue px-4 py-2">{{__('app.button_form')}}</button>
                    </form>
                </div>

                {{-- Kolom Kanan: Google Map Embed --}}
                <div class="col-lg-6">
                    <div class="map-container rounded-3 overflow-hidden shadow-sm">
                        {{-- Embed Google Map di sini --}}
                        {{-- Ganti src dengan embed code dari Google Maps Anda.
                             Cara mendapatkan embed code:
                             1. Buka Google Maps.
                             2. Cari lokasi yang Anda inginkan (misal: LPK PT Amarta Jakarta).
                             3. Klik 'Bagikan' (Share) -> 'Sematkan Peta' (Embed Map).
                             4. Salin kode <iframe> yang diberikan. --}}
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.1603150901974!2d107.13979687399022!3d-6.242592193745714!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6985a955264c81%3A0xe4eb9858dcd796be!2sWaroeng%20Babeh!5e0!3m2!1sid!2sid!4v1753496771537!5m2!1sid!2sid"
                            width="100%"
                            height="450"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="contact-cards" class="py-5">
        <div class="container">
            <h2 class="text-center section-title-custom mb-5">{{__('app.contact_card')}}</h2> {{-- Anda bisa ganti judul ini --}}
            <div class="row justify-content-center">
                {{-- Card 1: WhatsApp --}}
                <div class="col-md-4 mb-4">
                    <a href="https://wa.me/6285283123744" target="_blank" class="contact-card whatsapp-card text-decoration-none d-block">
                        <div class="icon-circle whatsapp-green">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <h3 class="contact-title">{{__('app.contact_title')}}</h3>
                    </a>
                </div>
                {{-- Card 2: Email (Generic) --}}
                <div class="col-md-4 mb-4">
                    <a href="mailto:lpkamartacibitung@gmail.com" class="contact-card email-card text-decoration-none d-block">
                        <div class="icon-circle email-red">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3 class="contact-title">{{__('app.email_label')}}</h3>
                    </a>
                </div>

                {{-- Card 3: Telepon (Generic) --}}
                <div class="col-md-4 mb-4">
                    <a href="https://wa.me/6282134716388" class="contact-card phone-card text-decoration-none d-block">
                        <div class="icon-circle phone-blue">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <h3 class="contact-title">{{__('app.phone_label')}}</h3>
                    </a>
                </div>
            </div>
        </div>
    </section>

     <section id="faq-section" class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 text-center mb-5">
                    <h1 class="mb-4">{{__('app.faq_title')}}</h1>
                    <div class="underline mx-auto"></div> {{-- Garis bawah seperti di section title --}}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 d-flex justify-content-center align-items-center mb-6 mb-md-5">
                    <img src="{{ asset('Asset/img/faq-illustration.png') }}" alt="FAQ Illustration" class="img-fluid" style="max-height: 350px;">
                </div>
                <div class="col-lg-8">
                    <h2 class="mb-3 txt-primary fw-bold">{{__('app.faq_subtitle')}}</h2>
                    <p class="mb-4 text-muted">{{__('app.faq_description')}}</p>

                    <div class="accordion" id="faqAccordion">
                        {{-- FAQ Item 1 --}}
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                   {{__('app.q1')}}
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    {{__('app.a1')}}
                                </div>
                            </div>
                        </div>

                        {{-- FAQ Item 2 --}}
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    {{__('app.q2')}}
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                   {{__('app.a2')}}
                                </div>
                            </div>
                        </div>

                        {{-- FAQ Item 3 --}}
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    {{__('app.q3')}}
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    {{__('app.a3')}}
                                </div>
                            </div>
                        </div>

                        {{-- FAQ Item 4 --}}
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    {{__('app.q4')}}
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    {{__('app.a4')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var myCarousel = document.querySelector('#contactUsCarousel');
            var carousel = new bootstrap.Carousel(myCarousel, {
                interval: 5000, // Durasi 5 detik per slide
                wrap: true // Kembali ke slide pertama setelah slide terakhir
            });
        });

        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const nama = encodeURIComponent(document.getElementById('nama').value);
            const email = encodeURIComponent(document.getElementById('email').value);
            const telepon = encodeURIComponent(document.getElementById('telepon').value);
            const subjek = encodeURIComponent(document.getElementById('subjek').value);
            const pesan = encodeURIComponent(document.getElementById('pesan').value);  
            const gmailLink = `https://mail.google.com/mail/?view=cm&fs=1&to=trianapahmi@gmail.com&su=${subjek}&body=Nama:%20${nama}%0AEmail:%20${email}%0ATelepon:%20${telepon}%0APesan:%20${pesan}`;

            // buka Gmail di tab baru
            window.open(gmailLink, '_blank');
            // reset form setelah submit
            this.reset();
        });
                
    </script>
@endpush
