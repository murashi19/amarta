@extends('layouts.app')

@push('styles')
<style>
    #about {
    width: 100%;
    height: 558px;
}

.about-section {
    position: relative;
    min-height: 558px;
    background: var(--color-primary);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.about-section::before {
    content: "";
    position: absolute;
    top: -50%;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: url("../Asset/img/foto-konten3.png");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    opacity: 40%;
    z-index: 1;
}

/* Background image overlay - simulating the group photo */
.about-section::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: #0d5fa6(30, 60, 114);
    z-index: 2;
}

.container {
    position: relative;
    z-index: 3;
}

.about-content {
    text-align: center;
    color: white;
    padding: 4rem 0;
    opacity: 0;
    animation: fadeInUp 1s ease-out forwards;
}

.about-content .section-title {
    animation-delay: 0.2s;
}

.about-content .decorative-line {
    animation-delay: 0.6s;
}

.section-subtitle {
    font-size: 1rem;
    font-weight: 300;
    letter-spacing: 3px;
    text-transform: uppercase;
    margin-bottom: 1rem;
    opacity: 0.9;
}

.section-title {
    font-size: 4rem;
    font-weight: 700;
    margin-bottom: 2rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.decorative-line {
    margin: 0 auto 2rem;
    position: relative;
    margin-left: -20px;
    animation: pulse 2s ease-in-out infinite;
}
@keyframes pulse {
    0%,
    100% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.1);
        opacity: 0.8;
    }
}
.decorative-line::before,
.decorative-line::after {
    content: "";
    position: absolute;
    top: 50%;
    background: white;
    border-radius: 50%;
}

.decorative-line::before {
    left: -15px;
}

.decorative-line::after {
    right: -15px;
}

.section-description {
    font-size: 1.1rem;
    font-weight: 300;
    line-height: 1.8;
    max-width: 700px;
    margin: 0 auto;
    opacity: 0.95;
}

/* Animated background elements */
.floating-elements {
    position: absolute;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: 1;
}

.floating-element {
    position: absolute;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
}

.floating-element:nth-child(1) {
    width: 80px;
    height: 80px;
    top: 10%;
    left: 10%;
    animation-delay: 0s;
}

.floating-element:nth-child(2) {
    width: 60px;
    height: 60px;
    top: 20%;
    right: 15%;
    animation-delay: 1s;
}

.floating-element:nth-child(3) {
    width: 100px;
    height: 100px;
    bottom: 20%;
    left: 20%;
    animation-delay: 2s;
}

.floating-element:nth-child(4) {
    width: 40px;
    height: 40px;
    bottom: 30%;
    right: 25%;
    animation-delay: 3s;
}

@keyframes float {
    0%,
    100% {
        transform: translateY(0px) rotate(0deg);
        opacity: 0.7;
    }
    50% {
        transform: translateY(-20px) rotate(180deg);
        opacity: 0.3;
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .section-title {
        font-size: 2.5rem;
    }

    .section-description {
        font-size: 1rem;
        padding: 0 1rem;
    }

    .about-content {
        padding: 2rem 0;
    }
}

@media (max-width: 576px) {
    .section-title {
        font-size: 2rem;
    }

    .section-subtitle {
        font-size: 0.9rem;
        letter-spacing: 2px;
    }
}

/* Hover effects */
.about-content:hover .section-title {
    transform: translateY(-10px);
    transition: transform 0.3s ease;
}

.about-content:hover .decorative-line {
    transform: translateY(-10px);
    transition: transform 0.3s ease;
}

/*========================================
  ABOUT KONTEN 2 - ENHANCED
========================================*/
#company {
    min-height: 100vh;
    align-items: center;
    padding-top: 80px;
    overflow: hidden;
}

/* Main content animations */
.company-content {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s ease-out;
}

.company-content.animate {
    opacity: 1;
    transform: translateY(0);
}

.company-image {
    opacity: 0;
    transform: translateX(50px);
    transition: all 0.8s ease-out 0.3s;
}

.company-image.animate {
    opacity: 1;
    transform: translateX(0);
}

/* Enhanced Cards */
.vision-mission-card {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    box-shadow: var(--shadow-soft);
    backdrop-filter: blur(10px);
    opacity: 0;
    transform: translateY(50px);
}

.vision-mission-card.animate {
    opacity: 1;
    transform: translateY(0);
}

.vision-card {
    background: var(--gradient-primary);
    color: white;
    transition-delay: 0.2s;
}

.mission-card {
    background: var(--gradient-light);
    color: var(--color-dark);
    transition-delay: 0.4s;
}

.vision-mission-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        90deg,
        transparent,
        rgba(255, 255, 255, 0.2),
        transparent
    );
    transition: left 0.5s;
}

.vision-mission-card:hover::before {
    left: 100%;
}

.vision-mission-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: var(--shadow-hover);
}

/* Text animations */
.company-title {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s ease-out 0.1s;
}

.company-title.animate {
    opacity: 1;
    transform: translateY(0);
}

.company-subtitle {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s ease-out 0.2s;
}

.company-subtitle.animate {
    opacity: 1;
    transform: translateY(0);
}

.company-description {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s ease-out 0.3s;
}

.company-description.animate {
    opacity: 1;
    transform: translateY(0);
}

/* Enhanced List Styling */
.mission-list {
    list-style: none;
    padding-left: 0;
}

.mission-list li {
    position: relative;
    padding-left: 30px;
    margin-bottom: 15px;
    opacity: 0;
    transform: translateX(-20px);
    transition: all 0.5s ease-out;
}

.mission-list.animate li:nth-child(1) {
    animation: slideInLeft 0.6s ease-out 0.8s forwards;
}
.mission-list.animate li:nth-child(2) {
    animation: slideInLeft 0.6s ease-out 1s forwards;
}
.mission-list.animate li:nth-child(3) {
    animation: slideInLeft 0.6s ease-out 1.2s forwards;
}

.mission-list li::before {
    content: "✓";
    position: absolute;
    left: 0;
    top: 0;
    width: 20px;
    height: 20px;
    background: var(--gradient-primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: bold;
    transform: scale(0);
    transition: transform 0.3s ease-out 0.2s;
}

.mission-list.animate li::before {
    transform: scale(1);
    animation: bounce 2s infinite 1.5s;
}

/* Keyframes */
@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes bounce {
    0%,
    20%,
    50%,
    80%,
    100% {
        transform: scale(1);
    }
    40% {
        transform: scale(1.1);
    }
    60% {
        transform: scale(1.05);
    }
}

/* Card hover effect */
.card-hover:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
}

.card-hover {
    transition: all 0.3s ease;
}

/* Image hover */
.img-fluid:hover {
    transform: scale(1.02);
    transition: transform 0.4s ease;
}

/* Loading state */
.loading-dots {
    display: inline-block;
}

.loading-dots::after {
    content: "";
    animation: dots 1.5s steps(4, end) infinite;
}

@keyframes dots {
    0%,
    20% {
        content: "";
    }
    40% {
        content: ".";
    }
    60% {
        content: "..";
    }
    80%,
    100% {
        content: "...";
    }
}

/* Responsive */
@media (max-width: 768px) {
    .bg-decor {
        width: 100px;
        top: -20px;
        right: 0;
    }

    h2 {
        font-size: 1.5rem;
    }

    .text-body {
        font-size: 0.95rem;
    }

    .vision-mission-card {
        margin-bottom: 2rem;
    }
}

/*========================================
  ABOUT KONTEN 3 - ENHANCED
========================================*/
#pendiri {
    background-color: var(--color-hover);
    min-height: 100vh;
    align-items: center;
    padding-top: 80px;
    padding-bottom: 90px;
    overflow: hidden;
    position: relative;
}

/* Background decoration */
#pendiri::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        135deg,
        transparent 0%,
        rgba(var(--color-primary-rgb), 0.03) 50%,
        transparent 100%
    );
    pointer-events: none;
}

/* Image animations */
.pendiri-image2 {
    opacity: 0;
    transform: translateX(-100px) scale(1.2);
    transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.pendiri-image2.animate {
    opacity: 1;
    transform: translateX(0) scale(1);
}

.pendiri-image2 img {
    background-color: transparent;
    transition: all 0.4s ease;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.pendiri-image2:hover img {
    transform: scale(1.05) rotate(1deg);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

/* Content animations */
.pendiri-content {
    opacity: 0;
    transform: translateX(50px);
    transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) 0.2s;
}

.pendiri-content.animate {
    opacity: 1;
    transform: translateX(0);
}

/* Typography animations */
.judul-h3 {
    font-size: 40px;
    font-weight: 700;
    color: var(--color-dark);
    text-align: center;
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease-out;
    position: relative;
}

.judul-h3.animate {
    opacity: 1;
    transform: translateY(0);
}

.judul-h3::after {
    content: "";
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%) scaleX(0);
    width: 80px;
    height: 3px;
    background: var(--color-primary);
    border-radius: 2px;
    transition: transform 0.6s ease-out 0.3s;
}

.judul-h3.animate::after {
    transform: translateX(-50%) scaleX(1);
}

.judul-h1 {
    font-size: 60px;
    font-weight: 700;
    color: var(--color-primary);
    text-align: center;
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease-out 0.2s;
    background-color: var(--color-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.judul-h1.animate {
    opacity: 1;
    transform: translateY(0);
}

.text-body {
    font-size: 20px;
    color: var(--color-dark);
    text-align: justify;
    line-height: 1.6;
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease-out 0.4s;
}

.text-body.animate {
    opacity: 1;
    transform: translateY(0);
}

/* Text reveal effect */
.text-reveal {
    position: relative;
    overflow: hidden;
}

.text-reveal::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--color-hover);
    transform: translateX(-100%);
    transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.text-reveal.animate::before {
    transform: translateX(100%);
}

/* Floating animation untuk gambar */
@keyframes float {
    0%,
    100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-10px);
    }
}

.pendiri-image2.animate img {
    animation: float 6s ease-in-out infinite;
}

/* Parallax background circles */
.bg-circle {
    position: absolute;
    border-radius: 50%;
    background: linear-gradient(
        135deg,
        rgba(var(--color-primary-rgb), 0.1),
        rgba(var(--color-secondary-rgb), 0.1)
    );
    pointer-events: none;
}

.bg-circle-1 {
    width: 200px;
    height: 200px;
    top: 10%;
    right: 10%;
    animation: floatSlow 8s ease-in-out infinite;
}

.bg-circle-2 {
    width: 150px;
    height: 150px;
    bottom: 15%;
    left: 5%;
    animation: floatSlow 10s ease-in-out infinite reverse;
}

.bg-circle-3 {
    width: 100px;
    height: 100px;
    top: 50%;
    left: 15%;
    animation: floatSlow 12s ease-in-out infinite;
}

@keyframes floatSlow {
    0%,
    100% {
        transform: translateY(0px) translateX(0px);
    }
    25% {
        transform: translateY(-20px) translateX(10px);
    }
    50% {
        transform: translateY(0px) translateX(20px);
    }
    75% {
        transform: translateY(20px) translateX(10px);
    }
}

/* Loading skeleton */
.skeleton {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
}

@keyframes loading {
    0% {
        background-position: 200% 0;
    }
    100% {
        background-position: -200% 0;
    }
}

/* Responsive */
@media (max-width: 992px) {
    .judul-h3 {
        font-size: 32px;
    }

    .judul-h1 {
        font-size: 48px;
    }

    .text-body {
        font-size: 18px;
    }

    .pendiri-image2 {
        margin-bottom: 2rem;
    }
}

@media (max-width: 768px) {
    .judul-h3 {
        font-size: 28px;
    }

    .judul-h1 {
        font-size: 36px;
    }

    .text-body {
        font-size: 16px;
        text-align: left;
    }

    .bg-circle {
        display: none;
    }

    #pendiri {
        min-height: auto;
        padding-top: 60px;
        padding-bottom: 60px;
    }
}

@media (max-width: 576px) {
    .judul-h3 {
        font-size: 24px;
    }

    .judul-h1 {
        font-size: 30px;
    }

    .text-body {
        font-size: 15px;
    }
}

/* Konten 4 Legalitas */
#legalitas {
    width: 100%;
    height: 1199px;
    padding: 100px 0;
    overflow: hidden;
}
.legal-hero {
    background-color: var(--color-hover);
    width: 1561px;
    height: 908px;
    border-radius: 0 50px 50px 0;
}

.legal-hero-content-text {
    padding: 80px 50px 0 50px;
}
.legal-hero-content-text h3 {
    font-size: 40px;
    color: var(--color-dark);
    font-weight: 500;
}
.legal-hero-content-text h1 {
    font-size: 60px;
    color: var(--color-primary);
    font-weight: 700;
}
/* Bungkus slider */
.slider-container2 {
    height: 100%;
    position: relative;
    overflow: hidden;
    width: 100%; /* lebar sesuai card */
}
.content-wrapper {
    position: relative;
    width: 100%;
    margin-top: -650px;
    margin-left: 50px;
    display: flex;
    text-align: center;
}
/* Bungkus slider */
.slider-container {
    position: relative;
    overflow: hidden;
    width: 636px; /* lebar sesuai card */
}

/* Wrapper geser */
.slider-wrapper {
    display: flex;
    transition: transform 0.5s ease-in-out;
}

.certificate-card {
    min-width: 636px;
    min-height: 700px;
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    margin-right: 20px;
}

.certificate-image {
    width: 100%;
    height: 700px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    overflow: hidden;
}

.certificate-image img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain; /* tetap contain */
}

.certificate-card:hover .certificate-image img {
    transform: scale(1.05);
}

.certificate-info-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: var(--color-primary);
    color: var(--color-light);
    padding: 40px 30px 30px;
    transform: translateY(100%);
    transition: transform 0.3s ease;
}

.certificate-card:hover .certificate-info-overlay {
    transform: translateY(0);
}

.certificate-title {
    color: white;
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 8px;
}

.certificate-subtitle {
    font-size: 1rem;
    opacity: 0.9;
    margin-bottom: 15px;
    font-weight: 500;
}

.certificate-description {
    font-size: 0.9rem;
    line-height: 1.5;
    opacity: 0.8;
    font-weight: 500;
}
/* Tombol Next */
.slider-next {
    position: absolute;
    top: 50%;
    right: -50px;
    transform: translateY(-50%);
    background: var(--color-primary);
    border: none;
    border-radius: 50%;
    color: var(--color-light);
    font-size: 2rem;
    padding: 10px 15px;
    cursor: pointer;
    z-index: 10;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
.slider-next:hover {
    background: var(--color-hover);
}

/* Indikator */
.slider-indicators {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    gap: 10px;
}
.slider-indicators span {
    width: 12px;
    height: 12px;
    background: #ccc;
    border-radius: 50%;
    display: inline-block;
    cursor: pointer;
}
.slider-indicators .active {
    background: var(--color-primary);
}
</style>
@endpush

@section('content')

<!-- KONTEN 1 -->
<section id="about">
    <div class="about-section">
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="about-content">
                        <h1 class="section-title text-white">About Us</h1>
                        <div class="decorative-line"><img src="{{ asset('Asset/line/Vector 1.png') }}" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- KONTEN 2 - ENHANCED -->
<section id="company">
    <div class="container">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 company-content">
                    <h3 class="fw-semibold txt-dark text-center company-title">Lembaga Pelatihan Kerja</h3>
                    <h1 class="fw-bold txt-primary text-center company-subtitle">PT. Amarta Indonesia</h1>
                    <p class="text-body mt-3 company-description">
                        PT. Amarta Bangun Indonesia (PT. ABI), berdiri tahun 2020 dikarawang. PT. ABI bergerak di bidang recruitment consulting dalam negri, seiiring waktu PT. ABI mendirikan sebuah LPK dengan nama LPK Amarta Kazoku. 
                        PT. ABI mempunyai klien di dalam negri terutama area karawang dan bekasi, kebanyaka klien PT. ABI berasal dari pma Jepang. PT. ABI mengembangkan bisnis dengan membuka pelatian bahasa Jepang dan juga pelatihan keperawatan yang di suport oleh perusahaan besar di Jepang yaitu Iincollex. <br>
                        Kini PT. ABI membuka peluang bagi siapapun anda yang ingin berkarir di negri Sakura dengan program khusus dan sangat cepat dengan pelatihan bahasa Jepang dan juga pelatihan keperawatan dari tenaga ahli yang berkualitas di bidang nya
                        dengan ada nya suport dari Incollex Jepang tentu saja tenaga pengajar kami sangat berkualitas dan di pandu belajar langsung dengan guru orang Jepang
                        kami mempunyai target bagi anda yang pemula, madya dan mahir dalam bahasa Jepang selanjutnya silahkan hubungi kami.
                    </p>
                </div>
                <div class="col-lg-6 position-relative company-image">
                    <img src="{{ asset('Asset/img/foto.png') }}" alt="Group Photo" class="img-fluid rounded">
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-6 mb-4">
                    <div class="vision-mission-card vision-card p-4 h-100">
                        <h4 class="fw-bold mt-3 mb-3 text-center text-white">VISI</h4>
                        <p class="mb-0 text-center" style="line-height: 1.6;">
                            Menjadi LPK AMARTA sebagai sarana pengembangan pengetahuan INDUSTRI, BUDAYA dan BAHASA JEPANG yang berkualitas, SKILL dan terarah sesuai dengan perencanaan PEMAGANGAN
                        </p>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="vision-mission-card mission-card p-4 h-100">
                        <div class="text-center mb-3">
                        </div>
                        <h4 class="fw-bold txt-primary mb-3 text-center">MISI</h4>
                        <ul class="mission-list mb-0 txt-primary">
                            <li>Mempersiapkan, memproses dan mencetak calon tenaga kerja yang handal dan berkualitas.</li>
                            <li>Pembekalan Budaya Kerja Jepang</li>
                            <li>Membentuk karakter kerja yang jujur, cepat dan bertanggungjawab</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Profile Pendiri - ENHANCED -->
<section id="pendiri">
    <!-- Background decorative circles -->
    <div class="bg-circle bg-circle-1"></div>
    <div class="bg-circle bg-circle-2"></div>
    <div class="bg-circle bg-circle-3"></div>
    
    <div class="container">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 position-relative pendiri-image2">
                    <img src="{{ asset('Asset/img/pendiri.png') }}" alt="Profile Pendiri" class="img-fluid rounded-5">
                </div>
                <div class="col-lg-6 pendiri-content">
                    <h3 class="judul-h3 text-reveal">
                        Profile Pendiri LPK
                    </h3>
                    <h1 class="judul-h1 text-reveal">
                        PT. Amarta Indonesia
                    </h1>
                    <p class="text-body mt-3 text-reveal">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Legalitas  -->
<section id="legalitas">
    <div class="container-fluid h-full">
        <div class="col-12">
            <div class="legal-hero">
                <div class="legal-hero-content-text">
                    <h3>Legalitas Perizinan LPK</h3>
                    <h1>PT. Amarta Indonesia</h1>
                </div>
            </div>
            <button class="slider-next" id="nextBtn">
                <i class="fa fa-chevron-right"></i>
            </button>
            <!-- Custom Slider -->
            <div class="content-wrapper">
                <div class="slider-container2">
                    <!-- Tombol Next -->
                    <div class="slider-wrapper" id="sliderWrapper">
                        <!-- Slide 1 -->
                        <div class="certificate-card">
                            <div class="certificate-image">
                                <img src="{{ asset('Asset/img/legal1.png') }}" alt="">
                            </div>
                            <div class="certificate-info-overlay">
                                <h3 class="certificate-title">Surat Dinas Tenaga Kerja</h3>
                                <p class="certificate-subtitle">Pemerintah Kota Tasikmalaya</p>
                                <p class="certificate-description">
                                    Dokumen resmi dari Dinas Tenaga Kerja Kota Tasikmalaya yang menyatakan 
                                    pengakuan terhadap LPK Shiro Kuma Indonesia sesuai dengan standar yang berlaku.
                                </p>
                            </div>
                        </div>
                        <!-- Slide 2 -->
                        <div class="certificate-card">
                            <div class="certificate-image">
                                    <img src="{{ asset('Asset/img/legal2.jpg') }}" alt="">
                            </div>
                            <div class="certificate-info-overlay">
                                <h3 class="certificate-title">Sertifikat Perizinan LPK</h3>
                                <p class="certificate-subtitle">Lembaga Pelatihan Kerja</p>
                                <p class="certificate-description">
                                    Sertifikat resmi yang memberikan izin operasional kepada LPK Shiro Kuma Indonesia 
                                    untuk menyelenggarakan program pelatihan bahasa Jepang.
                                </p>
                            </div>
                        </div>
                        <!-- Slide 3 -->
                        <div class="certificate-card">
                            <div class="certificate-image">
                                
                                    <img src="{{ asset('Asset/img/legal3.jpg') }}" alt="">
                            
                            </div>
                            <div class="certificate-info-overlay">
                                <h3 class="certificate-title">Dokumen Pendukung</h3>
                                <p class="certificate-subtitle">Sertifikat & Akreditasi</p>
                                <p class="certificate-description">
                                    Dokumen tambahan yang mendukung legalitas dan kredibilitas lembaga pelatihan 
                                    dalam menyelenggarakan program pelatihan kerja.
                                </p>
                            </div>
                        </div>

                        <!-- Slide 4 -->
                        <div class="certificate-card">
                            <div class="certificate-image">
                                
                                    <img src="{{ asset('Asset/img/legal2.jpg') }}" alt="">
                                
                            </div>
                            <div class="certificate-info-overlay">
                                <h3 class="certificate-title">Dokumen Pendukung</h3>
                                <p class="certificate-subtitle">Sertifikat & Akreditasi</p>
                                <p class="certificate-description">
                                    Dokumen tambahan yang mendukung legalitas dan kredibilitas lembaga pelatihan 
                                    dalam menyelenggarakan program pelatihan kerja.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Indikator -->
            <div class="slider-indicators" id="sliderIndicators">
                <span class="active"></span>
                <span></span>
                <span></span>
            </div>
                </div>
            </div>
        </div>
    </div>
</section>


 
@endsection