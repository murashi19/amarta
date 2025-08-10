@extends('layouts.app')

@section('content')
@push('styles')
    <style>
        /* KONTEN 1 */
        #program-unggulan {
            width: 100%;
            height: 100vh;
        }

        .judul-section {
            font-size: 2rem;
        }
        .judul-section span {
            color: var(--color-primary);
        }

        /* Carousel Styles */
        .carousel-indicators [data-bs-target] {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background-color: var(--color-disabletxt);
        }

        .carousel-indicators .active {
            background-color: var(--color-primary);
        }

        .carousel-item {
            margin-bottom: 80px;
            margin-top: 30px;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 50px;
            height: 50px;
            top: 50%;
            transform: translateY(-50%);
            background-color: var(--color-light);
            border-radius: 50%;
            opacity: 0.9;
            transition: var(--transition-normal);
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background-color: #0b5ed7;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-image: none;
            width: 100%;
            height: 100%;
            position: relative;
        }

        .carousel-control-prev-icon::after,
        .carousel-control-next-icon::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 12px;
            height: 12px;
            border-top: 3px solid white;
            border-right: 3px solid white;
            transform: translate(-50%, -50%) rotate(-135deg);
        }

        .carousel-control-next-icon::after {
            transform: translate(-50%, -50%) rotate(45deg);
        }

        .carousel-control-prev {
            left: -60px;
        }
        .carousel-control-next {
            right: -60px;
        }

        #program-tambahan {
            width: 100%;
            background-color: var(--color-info);
            height: 500px;
            margin-bottom: 50px;
        }

        .card-program {
            background-color: var(--color-light);
            color: var(--color-dark);
            border-radius: 20px;
            width: 100%;
            height: 200px;
            box-shadow: var(--shadow-sm);
            transition: var(--transition-normal);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .card-program:hover {
            transform: scale(1.05);
            background-color: var(--color-primary);
            color: var(--color-light);
        }

        /* KONTEN 3 */
        /* Base styles */
        #kegiatan-kami {
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            margin-top: 50px;
            margin-bottom: 100px;
        }

        .kegiatan-section {
            margin: 0 auto;
            width: 100%;
            padding: 0 20px; /* Add padding for better spacing */
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 60px;
            letter-spacing: -0.5px;
        }

        .carousel-section2 {
            position: relative;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .carousel-container2 {
            position: relative;
            overflow: hidden;
            width: 100%;
            height: 500px;
            margin: 0 auto;
            flex: 1;
            margin-bottom: 50px;
        }

        .carousel-wrapper2 {
            display: flex;
            height: 100%;
            transition: transform 0.5s ease;
            gap: 20px;
        }

        .carousel-item2 {
            flex: 0 0 calc(33.333% - 13.333px);
            height: 100%;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .carousel-item2:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .item-image2 {
            width: 100%;
            height: 300px;
            background: #f8f9fa;
            border-radius: 12px 12px 0 0;
            position: relative;
            overflow: hidden;
        }

        .item-image2 img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-content2 {
            padding: 24px;
        }

        .item-description {
            font-size: 0.95rem;
            line-height: 1.6;
            color: #495057;
            margin: 0;
            text-align: justify;
        }

        .nav-button2 {
            position: static;
            width: 50px;
            height: 50px;
            background: #f8f9fa;
            border: none;
            border-radius: 12px;
            color: #0066cc;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            flex-shrink: 0;
        }

        .nav-button2:hover {
            background: #0066cc;
            color: #ffffff;
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }

        .nav-prev2 {
            order: 1;
        }

        .nav-next2 {
            order: 3;
        }

        .carousel-container2 {
            order: 2;
        }

        .carousel-indicators {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #dee2e6;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }

        .indicator.active {
            background: #0066cc;
            transform: scale(1.2);
        }

        /* RESPONSIVE STYLES */

        /* Large tablets and small desktops (768px - 1199px) */
        @media (max-width: 1199px) {
            .carousel-item2 {
                flex: 0 0 calc(50% - 10px);
            }
            
            .section-title {
                font-size: 2.2rem;
                margin-bottom: 50px;
            }
        }

        /* Tablets (768px - 991px) */
        @media (max-width: 991px) {
            #kegiatan-kami {
                margin-top: 30px;
                margin-bottom: 60px;
                min-height: auto;
            }
            
            .kegiatan-section {
                padding: 0 15px;
            }
            
            .section-title {
                font-size: 2rem;
                margin-bottom: 40px;
            }
            
            .carousel-container2 {
                height: 450px;
                margin-bottom: 30px;
            }
            
            .item-image2 {
                height: 250px;
            }
            
            .item-content2 {
                padding: 20px;
            }
            
            .nav-button2 {
                width: 45px;
                height: 45px;
                font-size: 1.1rem;
            }
        }

        /* Small tablets and large phones (576px - 767px) */
        @media (max-width: 767px) {
            .carousel-section2 {
                flex-direction: column;
                gap: 20px;
            }
            
            .carousel-container2 {
                height: 400px;
                order: 1;
                margin-bottom: 0;
            }
            
            .carousel-item2 {
                flex: 0 0 100%;
            }
            
            .nav-prev2,
            .nav-next2 {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                z-index: 10;
                order: unset;
            }
            
            .nav-prev2 {
                left: 10px;
            }
            
            .nav-next2 {
                right: 10px;
            }
            
            .section-title {
                font-size: 1.8rem;
                margin-bottom: 30px;
            }
            
            .item-image2 {
                height: 220px;
            }
            
            .item-content2 {
                padding: 18px;
            }
            
            .item-description {
                font-size: 0.9rem;
                line-height: 1.5;
            }
            
            .carousel-indicators {
                order: 2;
                margin-top: 0;
            }
        }

        /* Mobile phones (up to 575px) */
        @media (max-width: 575px) {
            #kegiatan-kami {
                margin-top: 20px;
                margin-bottom: 40px;
                min-height: 450px;
            }
            
            .kegiatan-section {
                padding: 0 10px;
            }
            
            .section-title {
                font-size: 1.6rem;
                margin-bottom: 25px;
                letter-spacing: -0.3px;
            }
            
            .carousel-container2 {
                height: 350px;
            }
            
            .carousel-wrapper2 {
                gap: 10px;
                height: 300px;
            }
            
            .carousel-item2 {
                border-radius: 8px;
            }
            
            .item-image2 {
                height: 180px;
                border-radius: 8px 8px 0 0;
            }
            
            .item-content2 {
                padding: 15px;
            }
            
            .item-description {
                font-size: 0.85rem;
                line-height: 1.4;
            }
            
            .nav-button2 {
                width: 40px;
                height: 40px;
                font-size: 1rem;
                border-radius: 8px;
            }
            
            .nav-prev2 {
                left: 5px;
            }
            
            .nav-next2 {
                right: 5px;
            }
            
            .indicator {
                width: 10px;
                height: 10px;
            }
            
            .carousel-indicators {
                gap: 8px;
            }
        }

        /* Extra small devices (up to 380px) */
        @media (max-width: 380px) {
            .section-title {
                font-size: 1.4rem;
            }
            
            .carousel-container2 {
                height: 320px;
            }
            
            .item-image2 {
                height: 160px;
            }
            
            .item-content2 {
                padding: 12px;
            }
            
            .item-description {
                font-size: 0.8rem;
            }
            
            .nav-button2 {
                width: 35px;
                height: 35px;
                font-size: 0.9rem;
            }
        }

        /*========================================
        ENHANCED SWIPER GALLERY
        ========================================*/
        #gallery {
            padding: 100px 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #f1f5f9 100%);
            position: relative;
            overflow: hidden;
        }

        /* Animated background particles */
        #gallery::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(
                    circle at 20% 50%,
                    rgba(13, 94, 166, 0.1) 0%,
                    transparent 50%
                ),
                radial-gradient(
                    circle at 80% 20%,
                    rgba(41, 123, 163, 0.1) 0%,
                    transparent 50%
                ),
                radial-gradient(
                    circle at 40% 80%,
                    rgba(13, 94, 166, 0.05) 0%,
                    transparent 50%
                );
            animation: float 20s ease-in-out infinite;
            z-index: 1;
        }

        @keyframes float {
            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }
            33% {
                transform: translateY(-20px) rotate(1deg);
            }
            66% {
                transform: translateY(-10px) rotate(-1deg);
            }
        }

        #gallery .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 2;
        }

        .gallery-header {
            background: var(--color-primary);
            color: white;
            text-align: center;
            padding: 40px 20px;
            border-radius: 0 0 200px 200px;
            margin-bottom: 40px;
            box-shadow: 0 15px 35px rgba(46, 124, 231, 0.3);
            position: relative;
            overflow: hidden;
            margin-bottom: 100px;
        }

        .gallery-header::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, var(--color-hover) 0%, transparent 80%);
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%,
            100% {
                transform: rotate(0deg) scale(1);
                opacity: 0.3;
            }
            50% {
                transform: rotate(180deg) scale(1.1);
                opacity: 0.1;
            }
        }

        .gallery-header h1 {
            font-size: 4rem;
            font-weight: 700;
            letter-spacing: 2px;
            position: relative;
            z-index: 2;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        }

        .h3 {
            font-size: 30px;
            text-align: center;
            font-weight: 600;
            letter-spacing: 2px;
            position: relative;
            z-index: 2;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
            margin-bottom: 40px;
        }

        .gallery-title h2 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 700;
            color: var(--color-dark);
            margin-bottom: 20px;
            position: relative;
        }

        .gallery-title h2 span {
            color: var(--color-primary);
            position: relative;
        }

        .gallery-title h2 span::after {
            content: "";
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--color-primary), var(--color-info));
            border-radius: 2px;
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from {
                box-shadow: 0 0 5px var(--color-primary);
            }
            to {
                box-shadow: 0 0 20px var(--color-primary), 0 0 30px var(--color-info);
            }
        }

        /* Enhanced Swiper Styles */
        .swiper-container {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            padding: 20px 0;
        }

        .swiper-wrapper {
            display: flex;
            align-items: center;
        }

        /* ===============================
        DESKTOP STYLES (≥768px)
        =============================== */
        @media (min-width: 768px) {
            .swiper-slide {
                position: relative;
                border-radius: 16px;
                overflow: hidden;
                cursor: pointer;
                transition: all 0.4s ease;
                box-shadow: var(--shadow-md);
                background: var(--color-light);
            }

            .swiper-slide:hover {
                transform: translateY(-10px) scale(1.02);
                box-shadow: var(--shadow-xl);
            }

            .swiper-slide img {
                width: 100%;
                height: 400px;
                object-fit: cover;
                transition: all 0.4s ease;
                border-radius: 16px;
            }

            .swiper-slide:hover img {
                transform: scale(1.1);
                filter: brightness(0.7);
            }

            /* Style untuk title container - Desktop */
            .swiper-slide .title {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                background: linear-gradient(
                    45deg,
                    rgba(13, 94, 166, 0.95) 0%,
                    rgba(41, 123, 163, 0.9) 50%,
                    rgba(13, 94, 166, 0.95) 100%
                );
                color: white;
                padding: 30px 25px;
                text-align: center;
                transform: translateY(100%);
                transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
                backdrop-filter: blur(10px);
                border-radius: 0 0 16px 16px;
                z-index: 10;
            }

            .swiper-slide:hover .title {
                transform: translateY(0);
            }

            /* Style untuk span di dalam title - Desktop */
            .swiper-slide .title span {
                display: block;
                font-size: 1.8rem;
                font-weight: 700;
                letter-spacing: 1px;
                margin-bottom: 8px;
                text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
                position: relative;
            }

            .swiper-slide .title span::after {
                content: "";
                position: absolute;
                bottom: -4px;
                left: 50%;
                transform: translateX(-50%);
                width: 0;
                height: 3px;
                background: linear-gradient(90deg, #ffffff, rgba(255, 255, 255, 0.7));
                border-radius: 2px;
                transition: all 0.4s ease;
            }

            .swiper-slide:hover .title span::after {
                width: 80%;
            }

            /* Style untuk subtitle - Desktop */
            .swiper-slide .subtitle {
                font-size: 1.1rem;
                font-weight: 400;
                opacity: 0.95;
                line-height: 1.4;
                text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);
                letter-spacing: 0.5px;
                margin-top: 5px;
            }

            /* Animasi tambahan saat hover - Desktop */
            .swiper-slide:hover .title span {
                animation: titleGlow 1.5s ease-in-out infinite alternate;
            }

            @keyframes titleGlow {
                from {
                    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
                }
                to {
                    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3),
                        0 0 15px rgba(255, 255, 255, 0.3);
                }
            }

            /* Overlay gelap untuk readability yang lebih baik - Desktop */
            .swiper-slide::before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(
                    to bottom,
                    transparent 0%,
                    transparent 60%,
                    rgba(0, 0, 0, 0.3) 100%
                );
                z-index: 5;
                opacity: 0;
                transition: opacity 0.4s ease;
                border-radius: 16px;
            }

            .swiper-slide:hover::before {
                opacity: 1;
            }
        }

        /* ===============================
        MOBILE STYLES (≤767px) 
        SIMPLE SLIDE EFFECT ONLY
        =============================== */
        @media (max-width: 767px) {
            /* Remove all complex effects and transitions */
            .swiper-slide {
                position: relative;
                border-radius: 16px;
                overflow: hidden;
                cursor: pointer;
                transition: none !important;
                box-shadow: var(--shadow-md);
                background: var(--color-light);
                transform: none !important;
            }

            /* Remove hover effects completely */
            .swiper-slide:hover {
                transform: none !important;
                box-shadow: var(--shadow-md) !important;
            }

            .swiper-slide img {
                width: 100%;
                height: 280px;
                object-fit: cover;
                transition: none !important;
                border-radius: 16px;
                transform: none !important;
                filter: none !important;
            }

            /* Remove image hover effects */
            .swiper-slide:hover img {
                transform: none !important;
                filter: none !important;
            }

            /* Simple static title for mobile */
            .swiper-slide .title {
                position: static !important;
                bottom: auto !important;
                left: auto !important;
                right: auto !important;
                background: linear-gradient(
                    135deg,
                    rgba(13, 94, 166, 0.9) 0%,
                    rgba(41, 123, 163, 0.85) 100%
                ) !important;
                color: white;
                padding: 20px 15px !important;
                text-align: center;
                transform: none !important;
                transition: none !important;
                backdrop-filter: none !important;
                border-radius: 0 0 16px 16px !important;
                z-index: auto !important;
            }

            /* Remove title hover effects */
            .swiper-slide:hover .title {
                transform: none !important;
            }

            /* Simple title span for mobile */
            .swiper-slide .title span {
                display: block;
                font-size: 1.3rem !important;
                font-weight: 700;
                letter-spacing: 1px;
                margin-bottom: 5px !important;
                text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
                position: relative;
                animation: none !important;
            }

            /* Static underline for mobile */
            .swiper-slide .title span::after {
                content: "";
                position: absolute;
                bottom: -4px;
                left: 50%;
                transform: translateX(-50%);
                width: 80% !important;
                height: 3px;
                background: linear-gradient(90deg, #ffffff, rgba(255, 255, 255, 0.7));
                border-radius: 2px;
                transition: none !important;
            }

            /* Remove span hover effects */
            .swiper-slide:hover .title span::after {
                width: 80% !important;
            }

            /* Simple subtitle for mobile */
            .swiper-slide .subtitle {
                font-size: 0.9rem !important;
                font-weight: 400;
                opacity: 0.95;
                line-height: 1.4;
                text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);
                letter-spacing: 0.5px;
                margin-top: 5px;
            }

            /* Remove all animations for mobile */
            .swiper-slide:hover .title span {
                animation: none !important;
            }

            /* Remove overlay effects completely */
            .swiper-slide::before {
                display: none !important;
            }

            /* Mobile responsive header */
            .gallery-header h1 {
                font-size: 2.5rem !important;
            }

            .h3 {
                font-size: 1.5rem !important;
                margin-bottom: 30px !important;
            }

            #gallery {
                padding: 60px 0 !important;
            }

            .gallery-header {
                margin-bottom: 60px !important;
                padding: 30px 15px !important;
            }
        }

        /* Custom Navigation */
        .swiper-button-next,
        .swiper-button-prev {
            width: 60px !important;
            height: 60px !important;
            background: var(--color-light) !important;
            border-radius: 50% !important;
            box-shadow: var(--shadow-lg) !important;
            transition: all 0.3s ease !important;
            color: var(--color-primary) !important;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background: var(--color-primary) !important;
            color: var(--color-light) !important;
            transform: scale(1.1) !important;
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 1.2rem !important;
            font-weight: 700 !important;
        }

        /* Mobile navigation adjustments */
        @media (max-width: 767px) {
            .swiper-button-next,
            .swiper-button-prev {
                width: 44px !important;
                height: 44px !important;
                margin-top: -22px !important;
            }
            
            .swiper-button-next:after,
            .swiper-button-prev:after {
                font-size: 16px !important;
            }

            /* Remove hover effects on mobile navigation */
            .swiper-button-next:hover,
            .swiper-button-prev:hover {
                transform: none !important;
            }
        }

        /* Custom Pagination */
        .swiper-pagination {
            position: relative !important;
            margin-top: 40px !important;
        }

        .swiper-pagination-bullet {
            width: 14px !important;
            height: 14px !important;
            background: var(--color-disabletxt) !important;
            opacity: 1 !important;
            transition: all 0.3s ease !important;
        }

        .swiper-pagination-bullet-active {
            background: var(--color-primary) !important;
            transform: scale(1.3) !important;
            box-shadow: 0 0 10px rgba(13, 94, 166, 0.5) !important;
        }

        /* Mobile pagination adjustments */
        @media (max-width: 767px) {
            .swiper-pagination {
                margin-top: 30px !important;
            }

            .swiper-pagination-bullet {
                width: 12px !important;
                height: 12px !important;
            }

            .swiper-pagination-bullet-active {
                transform: scale(1.2) !important;
            }
        }

        /* KONTEN 2 */
        /* Custom CSS untuk ukuran card mobile */
        @media (max-width: 767.98px) {
            .card-mobile-size {
                height: 80px !important; /* Lebih kecil di mobile */
                min-height: 80px;
            }
            
            .card-mobile-size .card-body {
                padding: 0.75rem !important;
            }
        }

        @media (min-width: 768px) {
            .card-mobile-size {
                height: 120px; /* Ukuran normal di desktop */
                min-height: 120px;
            }
        }
    </style>
@endpush
<!-- Konten 1 -->
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
                <div class="col-md-6 text-center ">
                    <img src="{{ asset('Asset/img/6.jpg') }}" class="img-fluid rounded-4 shadow-sm slider-img" alt="Program 1"/>
                </div>
                <div class="col-md-6">
                    <h3 class="fw-bold mb-3">Kelas Bahasa Jepang Intensif:</h3>
                    <p class="mb-4">Dijamin nggak cuma hafal kata-kata, tapi bener-bener bisa komunikasi lancar di segala situasi.</p>
                    <button class="button-primary px-4 py-2">Lebih Lengkap..</button>
                </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
                <div class="row align-items-center g-4">
                <div class="col-md-6 text-center">
                    <img src="{{ asset('Asset/img/6.jpg') }}" class="img-fluid rounded-4 shadow-sm" alt="Program 2"/>
                </div>
                <div class="col-md-6">
                    <h3 class="fw-bold mb-3">Kelas Bahasa Inggris Profesional:</h3>
                    <p class="mb-4">Bangun kemampuan speaking & listening agar percaya diri berbicara dengan orang asing.</p>
                    <button class="btn btn-primary px-4 py-2">Lebih Lengkap..</button>
                </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item">
                <div class="row align-items-center g-4">
                <div class="col-md-6 text-center">
                    <img src="{{ asset('Asset/img/6.jpg') }}" class="img-fluid rounded-4 shadow-sm" alt="Program 3"/>
                </div>
                <div class="col-md-6">
                    <h3 class="fw-bold mb-3">Persiapan Interview Kerja Jepang:</h3>
                    <p class="mb-4">Latihan langsung teknik wawancara dengan skenario dunia kerja Jepang, siap lolos seleksi!</p>
                    <button class="btn btn-primary px-4 py-2">Lebih Lengkap..</button>
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

<!-- Konten 3 - Fixed -->
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
                        <div class="carousel-item2">
                            <div class="item-image2">
                                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=400&h=250&fit=crop&crop=center" alt="Kegiatan Siswa" loading="lazy">
                            </div>
                            <div class="item-content2">
                                <p class="item-description">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do 
                                    eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                </p>
                            </div>
                        </div>
                        
                        <div class="carousel-item2">
                            <div class="item-image2">
                                <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?w=400&h=250&fit=crop&crop=center" alt="Kegiatan Sekolah" loading="lazy">
                            </div>
                            <div class="item-content2">
                                <p class="item-description">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do 
                                    eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                </p>
                            </div>
                        </div>
                        
                        <div class="carousel-item2">
                            <div class="item-image2">
                                <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?w=400&h=250&fit=crop&crop=center" alt="Aktivitas Pembelajaran" loading="lazy">
                            </div>
                            <div class="item-content2">
                                <p class="item-description">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do 
                                    eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                </p>
                            </div>
                        </div>
                        
                        <div class="carousel-item2">
                            <div class="item-image2">
                                <img src="https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=400&h=250&fit=crop&crop=center" alt="Kegiatan Ekstrakurikuler" loading="lazy">
                            </div>
                            <div class="item-content2">
                                <p class="item-description">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do 
                                    eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                </p>
                            </div>
                        </div>
                        
                        <div class="carousel-item2">
                            <div class="item-image2">
                                <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=400&h=250&fit=crop&crop=center" alt="Kegiatan Olahraga" loading="lazy">
                            </div>
                            <div class="item-content2">
                                <p class="item-description">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do 
                                    eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                </p>
                            </div>
                        </div>
                        
                        <div class="carousel-item2">
                            <div class="item-image2">
                                <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=400&h=250&fit=crop&crop=center" alt="Kegiatan Seni" loading="lazy">
                            </div>
                            <div class="item-content2">
                                <p class="item-description">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do 
                                    eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button class="nav-button2 nav-next2" onclick="nextSlide()">
                    <i class="fa fa-chevron-right"></i>
                </button>
                <div class="carousel-indicators" id="indicators">
                    <!-- Indicators akan di-generate oleh JavaScript -->
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
    <div div class="container h-100">
      <!-- Gallery Section dengan Coverflow 3D -->
      <div class="swiper">
        <div class="swiper-wrapper">
          <!-- Slide 1 -->
          <div class="swiper-slide">
            <img src="{{ asset('Asset/img/1.jpg') }}" alt="Olahraga">
            <div class="title">
              <span>Olahraga</span>
              <div class="subtitle">Kegiatan Fisik & Kesehatan</div>
            </div>
          </div>

          <!-- Slide 2 -->
          <div class="swiper-slide">
            <img src="{{ asset('Asset/img/6.jpg') }}" alt="Pendidikan">
            <div class="title">
              <span>Pendidikan</span>
              <div class="subtitle">Program Belajar Mengajar</div>
            </div>
          </div>

          <!-- Slide 3 -->
          <div class="swiper-slide">
            <img src="{{ asset('Asset/img/5.jpg') }}" alt="Teknologi">
            <div class="title">
             <span>Penempatan Kerja</span>
              <div class="subtitle">Pengurusan Kontrak Kerja/Magang Perusahaan</div>
            </div>
          </div>

          <!-- Slide 4 -->
          <div class="swiper-slide">
            <img src="{{ asset('Asset/img/8.jpg') }}" alt="Seni & Budaya">
            <div class="title">
              <span>Interview Online</span>
              <div class="subtitle">Proses Wawancara Online dengan Perusahaan Jepang</div>
            </div>
          </div>

          <!-- Slide 5 -->
          <div class="swiper-slide">
            <img src="{{ asset('Asset/img/7.jpg') }}" alt="Lingkungan">
            <div class="title">
              <span>Interview Offline</span>
              <div class="subtitle">Proses Wawancara Offline dengan perwakilan Perusahaan Jepang</div>
            </div>
          </div>

          <!-- Slide 6 -->
          <div class="swiper-slide">
            <img src="{{ asset('Asset/img/4.jpg') }}" alt="Bisnis">
            <div class="title">
              <span>Passport</span>
              <div class="subtitle">Proses Pembuatan Passport</div>
            </div>
          </div>
          <!-- Slide 7 -->
          <div class="swiper-slide">
            <img src="{{ asset('Asset/img/9.jpg') }}" alt="Bisnis">
            <div class="title">
              <span>Pemberangkatan</span>
              <div class="subtitle">Proses Akhir Pemberangkatan ke Jepang</div>
            </div>
          </div>
          <!-- Slide 8 -->
          <div class="swiper-slide">
            <img src="{{ asset('Asset/img/10.jpg') }}" alt="Bisnis">
            <div class="title">
              <span>Sudah bekerja</span>
              <div class="subtitle">Foto siswa sudah di Jepang dan bekerja</div>
            </div>
          </div>
        </div>

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