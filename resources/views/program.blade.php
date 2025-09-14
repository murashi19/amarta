@extends('layouts.app')

@section('content')
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
        --shadow-soft: 0 10px 40px rgba(13, 94, 166, 0.1);
        --shadow-hover: 0 20px 60px rgba(13, 94, 166, 0.2);

        /* Shadows */
        --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.1);
        --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.15);
        --shadow-lg: 0 8px 25px rgba(0, 0, 0, 0.2);
        --shadow-xl: 0 20px 50px rgba(0, 0, 0, 0.3);

        /* Transitions */
        --transition-fast: 0.2s ease;
        --transition-normal: 0.3s ease;
        --transition-slow: 0.5s ease;

        /* Custom Gradients menggunakan warna template */
        --primary-gradient: linear-gradient(135deg, var(--color-primary) 0%, #1976d2 100%);
        --secondary-gradient: linear-gradient(135deg, var(--color-secondary) 0%, #d4851a 100%);
        --success-gradient: linear-gradient(135deg, var(--color-success) 0%, #4caf50 100%);
        --info-gradient: linear-gradient(135deg, var(--color-info) 0%, #42a5f5 100%);
        
        /* Alternative gradients dengan kombinasi warna template */
        --primary-alt-gradient: linear-gradient(135deg, var(--color-primary) 0%, var(--color-info) 100%);
        --secondary-alt-gradient: linear-gradient(135deg, var(--color-secondary) 0%, var(--color-warning) 100%);
        --success-alt-gradient: linear-gradient(135deg, var(--color-success) 0%, #16a085 100%);
        --info-alt-gradient: linear-gradient(135deg, var(--color-info) 0%, var(--color-primary) 100%);
        
        --shadow-soft: 0 8px 32px rgba(0,0,0,0.1);
        --shadow-hover: 0 20px 40px rgba(0,0,0,0.2);
    }


        /*========================================
        PROGRAM UNGGULAN
        ========================================*/
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

        .img-custom1 {
            height: 814px;
        }


        /*========================================
        PROGRAM TAMBAHAN
        ========================================*/

        #program-tambahan{
            width: 100%;
            height: 100vh;
            background-color: var(--color-hover);
        }
        .interactive-program-card {
            border-radius: 20px;
            padding: 0;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: none;
            height: 180px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            box-shadow: var(--shadow-soft);
        }

        .interactive-program-card .card-body {
            position: relative;
            z-index: 2;
            height: 100%;
        }

        /* Gradient Backgrounds */
        .interactive-program-card.primary-gradient {
            background: var(--primary-gradient);
        }

        .interactive-program-card.secondary-gradient {
            background: var(--secondary-gradient);
        }

        .interactive-program-card.success-gradient {
            background: var(--success-gradient);
        }

        .interactive-program-card.info-gradient {
            background: var(--info-gradient);
        }

        /* Hover Overlay Effect */
        .interactive-program-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.1);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
        }

        .interactive-program-card:hover::after {
            opacity: 1;
        }

        /* Hover Effects */
        .interactive-program-card:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: var(--shadow-hover);
        }

        /* Card Title Styling */
        .interactive-program-card .card-title {
            color: white;
            font-weight: 600;
            margin: 0;
            z-index: 3;
            position: relative;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
            line-height: 1.3;
        }

        /* Decorative Pattern */
        .card-pattern {
            position: absolute;
            top: -50px;
            right: -50px;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transition: all 0.3s ease;
            z-index: 1;
        }

        .interactive-program-card:hover .card-pattern {
            transform: scale(1.5);
            opacity: 0.3;
        }

        /* Additional Decorative Elements */
        .interactive-program-card::before {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            transition: all 0.3s ease;
            z-index: 1;
        }

        .interactive-program-card:hover::before {
            transform: scale(1.3);
            opacity: 0.8;
        }

        /* Active Card Enhancement */
        .interactive-program-card.active-card {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .interactive-program-card.active-card::after {
            opacity: 0.5;
        }

        /* Focus States untuk Accessibility */
        .interactive-program-card:focus {
            outline: none;
            box-shadow: var(--shadow-hover), 0 0 0 3px rgba(13, 94, 166, 0.3);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .interactive-program-card {
                height: 160px;
                margin-bottom: 1rem;
            }
            
            .interactive-program-card .card-title {
                font-size: 0.9rem !important;
                line-height: 1.2;
            }
            
            .interactive-program-card:hover {
                transform: translateY(-5px) scale(1.02);
            }
            
            .card-pattern {
                width: 80px;
                height: 80px;
                top: -40px;
                right: -40px;
            }
        }

        @media (max-width: 576px) {
            .interactive-program-card {
                height: 140px;
            }
            
            .interactive-program-card .card-title {
                font-size: 0.85rem !important;
            }
            
            .card-pattern {
                width: 60px;
                height: 60px;
                top: -30px;
                right: -30px;
            }
        }

        /* Loading Animation */
        .interactive-program-card {
            animation: cardFadeIn 0.6s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        .interactive-program-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .interactive-program-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .interactive-program-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .interactive-program-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        @keyframes cardFadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Pulse Animation untuk Active Card */
        .interactive-program-card.active-card {
            animation: activePulse 2s infinite;
        }

        @keyframes activePulse {
            0%, 100% {
                box-shadow: var(--shadow-hover);
            }
            50% {
                box-shadow: var(--shadow-hover), 0 0 0 5px rgba(13, 94, 166, 0.1);
            }
        }

        /* Additional Enhancement - Glow Effect */
        .interactive-program-card:hover {
            position: relative;
        }

        .primary-gradient:hover {
            box-shadow: var(--shadow-hover), 0 0 30px rgba(13, 94, 166, 0.3);
        }

        .secondary-gradient:hover {
            box-shadow: var(--shadow-hover), 0 0 30px rgba(166, 85, 13, 0.3);
        }

        .success-gradient:hover {
            box-shadow: var(--shadow-hover), 0 0 30px rgba(36, 194, 36, 0.3);
        }

        .info-gradient:hover {
            box-shadow: var(--shadow-hover), 0 0 30px rgba(41, 123, 163, 0.3);
        }

        /*========================================
        kegiatan
        ========================================*/
        /* Base styles */
        #kegiatan-kami {
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            margin-top: 100px;
            margin-bottom: 100px;
            padding: 60px 0;
            background-color: #f9f9f9;
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
            margin-top: 60px;
            margin-bottom: 60px;
            letter-spacing: -0.5px;
        }
        .kegiatan-section .section-title {
        font-size: 2rem;
        text-align: center;
        margin-bottom: 40px;
        position: relative;
        }

        .carousel-section2 {
            position: relative;
            display: flex;
            align-items: center;
            gap: 5px;
            position: relative;
            width: 100%;
            overflow: hidden;
            padding: 0 30px;
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
            gap: 1rem;
            transition: transform 0.5s ease-in-out;
        }

        .carousel-item2 {
            height: 100%;
            border-radius: 12px;
            transition: all 0.3s ease;
            overflow: hidden;
            background-color: #fff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
            flex: 0 0 100%;
            max-width: 100%;
            transition: transform 0.4s ease;
        }

        .carousel-item2:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            transform: translateY(-4px);
        }

        .item-image2 {
            width: 100%;
            height: 220px;
            background: #f8f9fa;
            border-radius: 12px 12px 0 0;
            position: relative;
            overflow: hidden;
        }

        .item-image2 img {
            width: 100%;
            object-fit: cover;
            width: 100%;
            height: 220px;
        }

        .item-content2 {
            padding: 20px;
        }

        .item-description {
            font-size: 0.95rem;
            line-height: 1.6rem;
            color: #495057;
            margin: 0;
            text-align: justify;
        }

        .nav-button2 {
            width: 50px;
            height: 50px;
            background: var(--color-light);
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            flex-shrink: 0;
            position: absolute;
            top: 50%;
            color: #fff;
            border: none;
            padding: 12px 16px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 2;
            transition: background 0.3s ease;
        }

        .nav-button2:hover {
            background: #0d5ea6;
            color: #ffffff;
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            background-color: #0c3a91;
        }
         .nav-prev2 {
        left: 0;
        }

        .nav-next2 {
        right: 0;
        }

        .carousel-indicators {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .carousel-indicators div {
            width: 10px;
            height: 10px;
            background-color: #ccc;
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
         .carousel-indicators .active {
        background-color: #1d4ed8;
        }

        .indicators2 {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #dee2e6;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }

        .indicators2.active {
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


        /* ===== Responsive Carousel (1 - 3 columns) ===== */
        @media (min-width: 768px) {
        .carousel-item2 {
            flex: 0 0 48%;
            max-width: 48%;
        }
        }

        @media (min-width: 1024px) {
        .carousel-item2 {
            flex: 0 0 32%;
            max-width: 32%;
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

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            padding-top: 50px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.9);
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            margin: auto;
            display: block;
            max-width: 50%;
            max-height: 90%;
            border-radius: 10px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            animation: zoomIn 0.3s ease;
        }

        @keyframes zoomIn {
            from { transform: scale(0.5); }
            to { transform: scale(1); }
        }

        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
        }

        .modal-caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
        }

        .modal-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255,255,255,0.2);
            color: white;
            border: none;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 20px;
            transition: all 0.3s ease;
        }

        .modal-nav:hover {
            background: rgba(255,255,255,0.4);
        }

        .modal-prev {
            left: 20px;
        }

        .modal-next {
            right: 20px;
        }

        /* Hover effect untuk gambar */
        .item-image2 {
            cursor: pointer;
            position: relative;
        }

        .item-image2::after {
            content: '\f002';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 2rem;
            opacity: 0;
            transition: opacity 0.3s ease;
            background: rgba(0,0,0,0.5);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .item-image2:hover::after {
            opacity: 1;
        }
</style>
@endpush



@section('content')

    <!-- Konten 1: Program Unggulan -->
    <section id="program-unggulan" class="py-5 mb-2 mb-md-0">
        <div class="container h-100">
        <div class="section-title">
        <h1 class="text-center fw-bold mb-4 judul-section">
            {{__('app.program_title')}} <span>{{__('app.program_subtitle')}}</span>
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
                <div class="ratio ratio-4x3" onclick="openModal('asset/img/photo (30).webp', 'Program Pemagangan Jepang')">
                    <img src="asset/img/photo (30).webp" class="img-fluid rounded-4 shadow-sm" style="object-fit: cover;" alt="Program Pemagangan Jepang" />
                </div>
                </div>
                <div class="col-md-6 d-flex flex-column justify-content-center">
                <h3 class="fw-bold mb-3">{{__('app.program_1')}}</h3>
                <p class="mb-4">{{__('app.program_1_text')}}</p>
                <!-- <button class="button-primary px-4 py-2">{{__('app.program_1_button')}}</button> -->
                </div>
            </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
            <div class="row align-items-center g-4">
                <div class="col-md-6">
                <div class="ratio ratio-4x3" onclick="openModal('asset/img/photo (33).webp', 'Program Tokutei Ginou')">
                    <img src="asset/img/photo (33).webp" class="img-fluid rounded-4 shadow-sm" style="object-fit: cover;" alt="Program Tokutei Ginou" />
                </div>
                </div>
                <div class="col-md-6 d-flex flex-column justify-content-center">
                <h3 class="fw-bold mb-3">{{__('app.program_2')}}</h3>
                <p class="mb-4">{{__('app.program_2_text')}}</p>
                <!-- <button class="button-primary px-4 py-2">{{__('app.program_2_button')}}</button> -->
                </div>
            </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item">
            <div class="row align-items-center g-4">
                <div class="col-md-6">
                <div class="ratio ratio-4x3" onclick="openModal('asset/img/photo2 (30).webp', 'Program Nihongo Gakkou')">
                    <img src="asset/img/photo2 (30).webp" class="img-fluid rounded-4 shadow-sm" style="object-fit: cover;" alt="Program Nihongo Gakkou" />
                </div>
                </div>
                <div class="col-md-6 d-flex flex-column justify-content-center">
                <h3 class="fw-bold mb-3">{{__('app.program_4')}}</h3>
                <p class="mb-4">{{__('app.program_4_text')}}</p>
                <!-- <button class="button-primary px-4 py-2">{{__('app.program_4_button')}}</button> -->
                </div>
            </div>
            </div>

            <!-- Slide 4 -->
            <div class="carousel-item">
            <div class="row align-items-center g-4">
                <div class="col-md-6">
                <div class="ratio ratio-4x3" onclick="openModal('asset/img/photo2 (16).webp', 'Program Engineering Jepang')">
                    <img src="asset/img/photo2 (16).webp" class="img-fluid rounded-4 shadow-sm" style="object-fit: cover;" alt="Program Engineering Jepang" />
                </div>
                </div>
                <div class="col-md-6 d-flex flex-column justify-content-center">
                <h3 class="fw-bold mb-3">{{__('app.program_3')}}</h3>
                <p class="mb-4">{{__('app.program_3_text')}}</p>
                <!-- <button class="button-primary px-4 py-2">{{__('app.program_3_button')}}</button> -->
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
                <button type="button" data-bs-target="#carouselProgram" data-bs-slide-to="3" aria-label="Slide 4"></button>
                </div>
            </div>
        </div>
    </section>

    <!-- Konten 2 -->
    <section id="program-tambahan" class="d-flex justify-content-center align-items-center py-4 py-md-5 mb-5 mb-md-0">
        <div class="container">
            <div class="row justify-content-center g-3 g-md-4">
                {{-- Card 1 --}}
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card interactive-program-card primary-gradient text-center">
                        <div class="card-body d-flex align-items-center justify-content-center py-3 py-md-4">
                            <div class="card-pattern"></div>
                            <h5 class="card-title fw-bold m-0 fs-6 fs-md-5">{{__('app.card1_title')}} <br> {{__('app.card1_subtitle')}}</h5>
                        </div>
                    </div>
                </div>

                {{-- Card 2 --}}
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card interactive-program-card secondary-gradient text-center">
                        <div class="card-body d-flex align-items-center justify-content-center py-3 py-md-4">
                            <div class="card-pattern"></div>
                            <h5 class="card-title fw-bold m-0 fs-6 fs-md-5">{{__('app.card2_title')}}</h5>
                        </div>
                    </div>
                </div>

                {{-- Card 3 --}}
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card interactive-program-card success-gradient text-center">
                        <div class="card-body d-flex align-items-center justify-content-center py-3 py-md-4">
                            <div class="card-pattern"></div>
                            <h5 class="card-title fw-bold m-0 fs-6 fs-md-5">{{__('app.card3_title')}}</h5>
                        </div>
                    </div>
                </div>

                {{-- Card 4 --}}
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card interactive-program-card info-gradient text-center">
                        <div class="card-body d-flex align-items-center justify-content-center py-3 py-md-4">
                            <div class="card-pattern"></div>
                            <h5 class="card-title fw-bold m-0 fs-6 fs-md-5">{{__('app.card4_title')}} <br> {{__('app.card4_subtitle')}}</h5>
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
        <h1 class="section-title">{{__('app.kegiatan_title')}}</h1>

        <div class="carousel-section2">
            <button class="nav-button2 nav-prev2" onclick="previousSlide()">
            <i class="fa fa-chevron-left"></i>
            </button>

            <div class="carousel-container2">
            <div class="carousel-wrapper2" id="carouselWrapper2">
                <!-- Kegiatan 1 -->
                <div class="carousel-item2">
                <div class="item-image2" onclick="openModal('asset/img/6.webp', 'Kelas Bahasa')">
                    <img src="asset/img/6.webp" alt="Kelas Bahasa" loading="lazy">
                </div>
                <div class="item-content2">
                    <p class="item-description">
                    {{__('app.kegiatan5')}}
                    </p>
                </div>
                </div>

                <div class="carousel-item2">
                <div class="item-image2" onclick="openModal('asset/img/photo2 (36).webp', 'Kelas Pemantapan')">
                    <img src="asset/img/photo2 (36).webp" alt="Kelas Pemantapan" loading="lazy">
                </div>
                <div class="item-content2">
                    <p class="item-description">
                    {{__('app.kegiatan1')}}
                    </p>
                </div>
                </div>

                <!-- Kegiatan 2 -->
                <div class="carousel-item2">
                <div class="item-image2" onclick="openModal('asset/img/photo2 (35).webp', 'Kelas Olahraga Fisik')">
                    <img src="asset/img/photo2 (35).webp" alt="Kelas Olahraga Fisik" loading="lazy">
                </div>
                <div class="item-content2">
                    <p class="item-description">
                    {{__('app.kegiatan2')}}
                    </p>
                </div>
                </div>

                <!-- Kegiatan 3 -->
                <div class="carousel-item2">
                <div class="item-image2" onclick="openModal('asset/img/photo (22).webp', 'Ujian Bahasa')">
                    <img src="asset/img/photo (22).webp" alt="Ujian Bahasa" loading="lazy">
                </div>
                <div class="item-content2">
                    <p class="item-description">
                    {{__('app.kegiatan3')}}
                    </p>
                </div>
                </div>
                
                <!-- Kegiatan 4 -->
                <div class="carousel-item2">
                <div class="item-image2" onclick="openModal('asset/img/8.webp', 'Interview')">
                    <img src="asset/img/8.webp" alt="Interview" loading="lazy">
                </div>
                <div class="item-content2">
                    <p class="item-description">
                    {{__('app.kegiatan4')}}
                    </p>
                </div>
                </div>

                <div class="carousel-item2">
                <div class="item-image2" onclick="openModal('asset/img/photo2 (63).webp', 'Tes Skill dan Interview Offline')">
                    <img src="asset/img/photo2 (63).webp" alt="Tes Skill dan Interview Offline" loading="lazy">
                </div>
                <div class="item-content2">
                    <p class="item-description">
                    {{__('app.kegiatan6')}}
                    </p>
                </div>
                </div>

                <div class="carousel-item2">
                <div class="item-image2" onclick="openModal('asset/img/5.webp', 'Tanda Tangan Kontrak')">
                    <img src="asset/img/5.webp" alt="Tanda Tangan Kontrak" loading="lazy">
                </div>
                <div class="item-content2">
                    <p class="item-description">
                    {{__('app.kegiatan7')}}
                    </p>
                </div>
                </div>

                <div class="carousel-item2">
                <div class="item-image2" onclick="openModal('asset/img/4.webp', 'Persiapan Keberangkatan')">
                    <img src="asset/img/4.webp" alt="Persiapan Keberangkatan" loading="lazy">
                </div>
                <div class="item-content2">
                    <p class="item-description">
                    {{__('app.kegiatan8')}}
                    </p>
                </div>
                </div>

                <div class="carousel-item2">
                <div class="item-image2" onclick="openModal('asset/img/photo (38).webp', 'Pemberangkatan')">
                    <img src="asset/img/photo (38).webp" alt="Pemberangkatan" loading="lazy">
                </div>
                <div class="item-content2">
                    <p class="item-description">
                    {{__('app.kegiatan9')}}
                    </p>
                </div>
                </div>
            </div>
            </div>

            <button class="nav-button2 nav-next2" onclick="nextSlide()">
            <i class="fa fa-chevron-right"></i>
            </button>
            <div class="carousel-indicators" id="indicators2">
            <!-- Diisi lewat JS -->
            </div>
        </div>
        </div>
    </div>
    </section>

    <!-- Modal untuk popup foto -->
    <div id="imageModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <button class="modal-nav modal-prev" onclick="previousModalImage()">
            <i class="fa fa-chevron-left"></i>
        </button>
        <img class="modal-content" id="modalImage">
        <button class="modal-nav modal-next" onclick="nextModalImage()">
            <i class="fa fa-chevron-right"></i>
        </button>
        <div class="modal-caption" id="modalCaption"></div>
    </div>

  <section id="gallery">
    <div class="gallery-header">
      <h1 class="text-white">{{__('app.galeri_title')}}</h1>
    </div>
      <h3 class="h3">
        {{__('app.galeri_text')}}
      </h3>
    <div div class="container h-100">
      <!-- Gallery Section dengan Coverflow 3D -->
      <div class="swiper">
        <div class="swiper-wrapper">
        <div class="swiper-slide">
          <img src="asset/img/photo2 (35).webp" alt="Gallery 42">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo (44).webp" alt="Gallery 43">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (44).webp" alt="Gallery 44">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (45).webp" alt="Gallery 45">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (46).webp" alt="Gallery 46">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (47).webp" alt="Gallery 47">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (48).webp" alt="Gallery 48">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (49).webp" alt="Gallery 49">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (50).webp" alt="Gallery 50">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (51).webp" alt="Gallery 51">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (52).webp" alt="Gallery 52">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (53).webp" alt="Gallery 53">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (54).webp" alt="Gallery 54">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (55).webp" alt="Gallery 55">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (64).webp" alt="Gallery 56">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (57).webp" alt="Gallery 57">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (68).webp" alt="Gallery 58">
        </div>
        <div class="swiper-slide">
          <img src="asset/img/photo2 (59).webp" alt="Gallery 59">
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

        // ================================= ENHANCED Kegiatan CAROUSEL ===============================
        let currentIndex = 0;
            const wrapper = document.getElementById("carouselWrapper2");
            const items = document.querySelectorAll(".carousel-item2");
            const indicatorsContainer = document.getElementById("indicators2");

            // Jumlah item per slide
            const itemsPerSlide = 3;
            // Hitung total slide
            const totalSlides = Math.ceil(items.length / itemsPerSlide);

            // Buat indikator sesuai jumlah slide
            for (let i = 0; i < totalSlides; i++) {
                const btn = document.createElement("button");
                btn.classList.add("indicators2");
                if (i === 0) btn.classList.add("active");
                btn.setAttribute("data-index", i);
                btn.onclick = () => goToSlide(i);
                indicatorsContainer.appendChild(btn);
            }

            const indicators = document.querySelectorAll(".indicators2");

            function updateCarousel() {
                // Geser wrapper berdasarkan index slide (bukan item tunggal)
                wrapper.style.transform = `translateX(-${currentIndex * 100}%)`;

                // Update indikator aktif
                indicators.forEach((ind, i) => {
                    ind.classList.toggle("active", i === currentIndex);
                });
            }

            function previousSlide() {
                currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                updateCarousel();
            }

            function nextSlide() {
                currentIndex = (currentIndex + 1) % totalSlides;
                updateCarousel();
            }

            function goToSlide(index) {
                currentIndex = index;
                updateCarousel();
            }

            // Inisialisasi posisi awal
            updateCarousel();

            // Modal Pop up gambar
            let currentModalImage = 0;
            // Array untuk menyimpan data gambar
            const images = [
                { src: 'asset/img/photo (30).webp', alt: 'Program Pemagangan Jepang' },
                { src: 'asset/img/photo (33).webp', alt: 'Program Tokutei Ginou' },
                { src: 'asset/img/photo2 (30).webp', alt: 'Program Nihongo Gakkou' },
                { src: 'asset/img/photo2 (16).webp', alt: 'Program Engineering Jepang' },
                { src: 'asset/img/6.webp', alt: 'Kelas Bahasa' },
                { src: 'asset/img/photo2 (36).webp', alt: 'Kelas Pemantapan' },
                { src: 'asset/img/photo2 (35).webp', alt: 'Kelas Olahraga Fisik' },
                { src: 'asset/img/photo (22).webp', alt: 'Ujian Bahasa' },
                { src: 'asset/img/8.webp', alt: 'Interview' },
                { src: 'asset/img/photo2 (63).webp', alt: 'Tes Skill dan Interview Offline' },
                { src: 'asset/img/5.webp', alt: 'Tanda Tangan Kontrak' },
                { src: 'asset/img/4.webp', alt: 'Persiapan Keberangkatan' },
                { src: 'asset/img/photo (38).webp', alt: 'Pemberangkatan' }
            ];

            // Modal functions
            function openModal(src, alt) {
                const modal = document.getElementById('imageModal');
                const modalImg = document.getElementById('modalImage');
                const caption = document.getElementById('modalCaption');
                
                // Find current image index
                currentModalImage = images.findIndex(img => img.src === src);
                
                modal.style.display = 'block';
                modalImg.src = src;
                caption.innerHTML = alt;
                
                // Prevent body scroll
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                const modal = document.getElementById('imageModal');
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }

            function nextModalImage() {
                currentModalImage = (currentModalImage + 1) % images.length;
                updateModalImage();
            }

            function previousModalImage() {
                currentModalImage = (currentModalImage - 1 + images.length) % images.length;
                updateModalImage();
            }

            function updateModalImage() {
                const modalImg = document.getElementById('modalImage');
                const caption = document.getElementById('modalCaption');
                
                modalImg.src = images[currentModalImage].src;
                caption.innerHTML = images[currentModalImage].alt;
            }

            // Close modal when clicking outside the image
            window.onclick = function(event) {
                const modal = document.getElementById('imageModal');
                if (event.target == modal) {
                    closeModal();
                }
            }

            // Keyboard navigation
            document.addEventListener('keydown', function(event) {
                const modal = document.getElementById('imageModal');
                if (modal.style.display === 'block') {
                    if (event.key === 'Escape') {
                        closeModal();
                    } else if (event.key === 'ArrowLeft') {
                        previousModalImage();
                    } else if (event.key === 'ArrowRight') {
                        nextModalImage();
                    }
                }
            });
    </script>
@endpush
@endsection