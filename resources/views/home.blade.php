@extends('layouts.app')
@push('styles')
<style>
   /*========================================
    HERO SECTION
    ========================================*/
    #hero {
            width: 100%;
            background-color: var(--color-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 80px;
            overflow: hidden;
            position: relative;
        }

        #hero::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grain)"/></svg>');
            opacity: 0;
            animation: fadeInGrain 2s ease-out 0.5s forwards;
        }

        @keyframes fadeInGrain {
            to {
                opacity: 0.3;
            }
        }

        /* Enhanced particle background */
        #hero::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: radial-gradient(
                    2px 2px at 20px 30px,
                    rgba(255, 255, 255, 0.3),
                    transparent
                ),
                radial-gradient(
                    2px 2px at 40px 70px,
                    rgba(255, 255, 255, 0.2),
                    transparent
                ),
                radial-gradient(
                    1px 1px at 90px 40px,
                    rgba(255, 255, 255, 0.4),
                    transparent
                ),
                radial-gradient(
                    1px 1px at 130px 80px,
                    rgba(255, 255, 255, 0.2),
                    transparent
                );
            background-repeat: repeat;
            background-size: 75px 100px;
            animation: sparkle 8s linear infinite,
                pulseParticles 3s ease-in-out infinite alternate;
            pointer-events: none;
            opacity: 0;
            animation-delay: 1s;
            animation-fill-mode: forwards;
        }

        @keyframes sparkle {
            0% {
                transform: translateY(0px);
            }
            100% {
                transform: translateY(-100px);
            }
        }

        @keyframes pulseParticles {
            0% {
                opacity: 0.4;
            }
            100% {
                opacity: 0.8;
            }
        }

        /* Animated content container */
        .hero-content {
            position: relative;
            z-index: 2;
            opacity: 0;
            transform: translateX(-50px);
            animation: slideInLeft 1s ease-out 0.3s forwards;
        }

        @keyframes slideInLeft {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Animated heading with typewriter effect */
        .hero-tagline h1 {
            font-weight: 600;
            line-height: 1.2;
            color: var(--color-light);
            margin-bottom: 20px;
            font-size: clamp(2rem, 5vw, 4rem);
            overflow: hidden;
            opacity: 0;
            animation: fadeInUp 0.8s ease-out 0.8s forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Staggered animation for spans */
        .span1,
        .span2 {
            color: var(--color-light);
            font-weight: 600;
            display: block;
            margin: 10px 0;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .span1 {
            animation-delay: 1.2s;
        }

        .span2 {
            animation-delay: 1.4s;
            position: relative;
        }

        /* Glowing effect for span2 */
        .span2::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(
                45deg,
                transparent,
                rgba(255, 255, 255, 0.1),
                transparent
            );
            animation: shimmer 3s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes shimmer {
            0%,
            100% {
                transform: translateX(-100%);
            }
            50% {
                transform: translateX(100%);
            }
        }

        /* Animated hero text */
        .hero-text {
            font-size: clamp(1rem, 2vw, 1.5rem);
            line-height: 1.6;
            color: var(--color-light);
            margin: 30px 0;
            max-width: 600px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s ease-out 1.6s forwards;
        }

        /* Animated buttons container */
        .hero-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: center;
            margin-top: 30px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s ease-out 1.8s forwards;
        }

        /* Enhanced button animations */
        .button-dark {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            transform: translateY(0);
        }

        .button-dark::before {
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

        .button-dark:hover::before {
            left: 100%;
        }

        .button-dark:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .button-dark:active {
            transform: translateY(0);
        }

        /* Enhanced hero link */
        .hero-link {
            color: var(--color-light);
            font-weight: 600;
            text-decoration: none;
            position: relative;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transform: translateX(0);
        }

        .hero-link:hover {
            color: var(--color-light);
            transform: translateX(5px);
        }

        .hero-link::after {
            content: "";
            position: absolute;
            bottom: -4px;
            left: 0;
            height: 2px;
            width: 100%;
            background: var(--color-light);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .hero-link:hover::after {
            transform: scaleX(1);
        }

        /* Arrow animation */
        .hero-link span {
            transition: transform 0.3s ease;
            display: inline-block;
        }

        .hero-link:hover span {
            transform: translateX(5px);
        }

        /* Professional hero image container */
        .hero-image {
            position: relative;
            z-index: 1;
            opacity: 0;
            transform: translateY(30px);
            animation: imageSlideUp 1s ease-out 0.6s forwards;
        }

        @keyframes imageSlideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Modern image styling with subtle effects */
        .hero-image img {
            max-width: 100%;
            height: auto;
            max-height: 80vh;
            margin-right: -400px;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.1));
        }

        /* Professional hover effect */
        .hero-image img:hover {
            transform: translateY(-5px);
            filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.15));
        }

        /* Subtle breathing animation for modern feel */
        .hero-image::before {
            content: "";
            position: absolute;
            top: -5%;
            left: -5%;
            right: -5%;
            bottom: -5%;
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.1) 0%,
                rgba(255, 255, 255, 0.05) 50%,
                rgba(255, 255, 255, 0.1) 100%
            );
            border-radius: 20px;
            opacity: 0;
            transition: opacity 0.6s ease;
            z-index: -1;
            animation: subtleGlow 4s ease-in-out infinite alternate;
        }

        .hero-image:hover::before {
            opacity: 1;
        }

        @keyframes subtleGlow {
            0% {
                transform: scale(1);
                opacity: 0.3;
            }
            100% {
                transform: scale(1.02);
                opacity: 0.6;
            }
        }

        /* Pulse animation for call-to-action button */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(255, 255, 255, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
            }
        }

        .button-dark {
            animation: pulse 2s infinite;
            animation-delay: 3s;
        }

        /* Responsive animations */
        @media (max-width: 768px) {
            .hero-content {
                text-align: center;
            }

            @keyframes mobileImageFade {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        }

        /* Smooth scroll behavior for entire section */
        #hero {
            scroll-behavior: smooth;
        }


    /*========================================
    SECTION TITLES WITH ANIMATIONS
    ========================================*/
    .section-title {
        text-align: center;
        margin-bottom: 2rem;
        opacity: 0;
        transform: translateY(40px);
        animation: titleSlideUp 0.8s ease-out forwards;
    }

        @keyframes titleSlideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section-title h1 {
            font-size: clamp(2rem, 4vw, 3.5rem);
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 15px;
            overflow: hidden;
        }

        /* Animated text reveal */
        .section-title h1 span {
            color: var(--color-primary);
            font-weight: 700;
            position: relative;
            display: inline-block;
            animation: textGlow 2s ease-in-out infinite alternate;
        }

        @keyframes textGlow {
            0% {
                text-shadow: 0 0 5px rgba(13, 95, 166, 0.146);
            }
            100% {
                text-shadow: 0 0 15px rgba(13, 95, 166, 0.363);
            }
        }

        /* Animated underline */
        .underline {
            width: min(733px, 80%);
            height: 4px;
            background-color: var(--color-primary);
            margin: 0 auto;
            border-radius: 2px;
            box-shadow: var(--shadow-sm);
            position: relative;
            transform: scaleX(0);
            transform-origin: center;
            animation: underlineGrow 1s ease-out 0.5s forwards;
        }

        @keyframes underlineGrow {
            to {
                transform: scaleX(1);
            }
        }

        .underline::before,
        .underline::after {
            content: "";
            position: absolute;
            top: 50%;
            transform: translateY(-50%) scale(0);
            width: 22px;
            height: 22px;
            background-color: var(--color-primary);
            border-radius: 50%;
            animation: dotPop 0.4s ease-out 1.2s forwards;
        }

        @keyframes dotPop {
            0% {
                transform: translateY(-50%) scale(0);
            }
            50% {
                transform: translateY(-50%) scale(1.2);
            }
            100% {
                transform: translateY(-50%) scale(1);
            }
        }

        .underline::before {
            left: -10px;
            animation-delay: 1.2s;
        }

        .underline::after {
            right: -10px;
            animation-delay: 1.4s;
        }

    /*========================================
    ALASAN SECTION WITH SCROLL ANIMATIONS
    ========================================*/
    #alasan {
        padding: 80px 0;
        background-color: #fff;
    }

    .alasan-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 32px;
        padding: 20px;
        margin-top: 60px;
        max-width: 1400px;
        margin-left: auto;
        margin-right: auto;
    }

    .alasan-card {
        background-color: var(--color-light);
        border-radius: 20px;
        padding: 30px 20px 20px;
        box-shadow: var(--shadow-md);
        min-height: 350px;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        position: relative;
        margin-top: 60px;
        perspective: 1000px;
        transform-style: preserve-3d;
    }

        .alasan-card::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: radial-gradient(
                circle,
                rgba(13, 94, 166, 0.3) 0%,
                transparent 70%
            );
            transform: translate(-50%, -50%);
            transition: all 0.6s ease;
            border-radius: 50%;
            pointer-events: none;
            opacity: 0;
        }

        .alasan-card:active::after {
            opacity: 1;
            transition: all 0.3s ease;
        }

        .alasan-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
            background-color: var(--color-hover);
            transform: translateY(-15px) rotateX(5deg) rotateY(5deg);
        }

    .icon-wrapper {
        background-color: var(--color-primary);
        padding: 1rem;
        border-radius: 16px;
        width: 120px;
        height: 120px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: -70px;
        box-shadow: var(--shadow-md);
        transition: var(--transition-normal);
    }

        .alasan-card.scroll-visible .icon-wrapper {
            animation: iconFloat 3s ease-in-out infinite;
        }

        @keyframes iconFloat {
            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }
            33% {
                transform: translateY(-10px) rotate(2deg);
            }
            66% {
                transform: translateY(-5px) rotate(-2deg);
            }
        }

        .icon-wrapper:hover {
            transform: scale(1.05) rotate(3deg);
            animation: iconSpin 0.8s ease-in-out;
        }

        @keyframes iconSpin {
            0% {
                transform: rotate(0deg) scale(1);
            }
            50% {
                transform: rotate(180deg) scale(1.1);
            }
            100% {
                transform: rotate(360deg) scale(1);
            }
        }

    .icon-wrapper i {
        color: white;
        font-size: 2rem;
    }

    .alasan-title {
        font-size: 1rem;
        font-weight: 700;
        margin: 30px 0 20px;
        color: var(--color-dark);
        text-align: center;
    }

        .alasan-text {
            font-size: 1rem;
            line-height: 1.6rem;
            color: var(--color-dark);
            text-align: center;
        }

        /*========================================
        GERBANG SECTION WITH SCROLL ANIMATIONS
        ========================================*/
        #gerbang {
            background-color: var(--color-hover);
            padding: 100px 0;
        }

    .gerbang-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        align-items: start;
        margin-top: 40px;
        position: relative;
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
    }

        .gerbang-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 48%;
            transform: translateX(-50%);
            width: 3px;
            height: 0;
            background: linear-gradient(
                to bottom,
                transparent 0%,
                var(--color-primary) 10%,
                var(--color-primary) 90%,
                transparent 100%
            );
            z-index: 1;
            transition: height 1.5s ease-out 0.5s;
        }

        .gerbang-container.scroll-visible::before {
            height: 100%;
        }

        .image-section img {
            width: 90%;
            height: auto;
            border-radius: 15px;
            box-shadow: var(--shadow-lg);
            transition: var(--transition-normal);
            position: relative;
        }

        .image-section img:hover {
            transform: scale(1.02);
        }

        .content-section {
            padding: 20px 0;
        }

        .description {
            margin-bottom: 40px;
            line-height: 1.8;
            color: var(--color-dark);
            font-size: 1.1rem;
        }

        .company-name {
            color: var(--color-primary);
            font-weight: 700;
        }

        .legal-name {
            font-weight: 600;
            color: var(--color-dark);
        }

        .vision-mission {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .vision,
        .mission {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: var(--shadow-sm);
            transition: var(--transition-normal);
        }

        .vision:hover,
        .mission:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .vision h3,
        .mission h3 {
            color: var(--color-primary);
            margin-bottom: 15px;
            font-size: 1.3rem;
            font-weight: 700;
        }

        .vision p {
            color: var(--color-dark);
            line-height: 1.7;
            font-size: 0.95rem;
        }

        .mission ul {
            list-style: none;
            padding: 0;
        }

        .mission li {
            color: var(--color-dark);
            line-height: 1.7;
            margin-bottom: 12px;
            padding-left: 20px;
            position: relative;
            font-size: 0.95rem;
        }

        .mission li::before {
            content: "✓";
            color: var(--color-primary);
            font-weight: bold;
            position: absolute;
            left: 0;
            font-size: 1.1rem;
        }

    /*========================================
    LOWONGAN SECTION
    ========================================*/
    #lowongan {
                background-color: #fff;
                width: 100%;
                margin-top: 100px;
                padding: 50px 0;
                margin-bottom: 100px;
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

            .judul-section {
                font-size: 2rem;
            }
            .judul-section span {
                color: var(--color-primary);
            }

            .underline {
                width: 80px;
                height: 4px;
                background: linear-gradient(45deg, var(--color-primary), #0056b3);
                margin: 0 auto;
                border-radius: 2px;
            }

            .lowongan-container {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
                gap: 5rem;
                margin-top: 100px;
                padding: 0 20px;
            }

            .lowongan-card {
                background-color: var(--color-light);
                border-radius: 60px 60px 0 0;
                box-shadow: var(--shadow-md);
                padding: 2rem 2rem 2rem;
                text-align: center;
                transition: transform 0.4s ease, box-shadow 0.4s ease;
                position: relative;
                text-decoration: none;
                color: inherit;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: flex-start;
            }

            .lowongan-card:hover {
                transform: translateY(-10px);
                box-shadow: var(--shadow-lg);
                background-color: var(--color-hover);
            }

            .icon-wrapper {
                background-color: var(--color-primary);
                padding: 0.75rem;
                border-radius: 50%;
                width: 130px;
                height: 130px;
                margin-top: -90px;
                margin-bottom: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: var(--shadow-md);
                transition: transform 0.3s ease;
            }

            .icon-wrapper i {
                color: white;
                font-size: 1.8rem;
            }

            .icon-wrapper:hover {
                transform: scale(1.05) rotate(3deg);
            }

            .lowongan-title {
                font-size: 1.1rem;
                font-weight: 600;
                margin-bottom: 10px;
                color: var(--color-dark);
            }

            .detail-btn {
                display: inline-block;
                margin-top: 10px;
                padding: 8px 20px;
                background-color: var(--color-primary);
                color: #fff;
                font-size: 0.9rem;
                font-weight: 500;
                border-radius: 25px;
                text-decoration: none;
                transition: background-color 0.3s ease, transform 0.3s ease;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .detail-btn:hover {
                background-color: #094a87;
                transform: translateY(-2px);
            }

            

            /* HOVER EFFECTS - DESKTOP ONLY */
            @media (min-width: 769px) {
                .lowongan-card:hover .icon-wrapper {
                    transform: scale(1.05) rotate(3deg);
                }
            }


    /*========================================
    LOWONGAN DETAIL
    ========================================*/
    #lowongan-detail {
    background-color: #fff;
    padding: 80px 20px;
    }

    .section-title h2 {
    font-size: 2rem;
    text-align: center;
    font-weight: 700;
    color: var(--color-dark);
    }

    .section-title .underline {
    width: 60px;
    height: 4px;
    background-color: var(--color-primary);
    margin: 10px auto 30px;
    border-radius: 4px;
    }

    .lowongan-subtext {
    text-align: center;
    max-width: 700px;
    margin: 0 auto 40px;
    font-size: 1rem;
    line-height: 1.6;
    color: var(--color-dark);
    }

    .poster-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    justify-content: center;
    align-items: flex-start;
    }

    .poster-item {
    background-color: #f9f9f9;
    border-radius: 16px;
    padding: 20px;
    box-shadow: var(--shadow-sm);
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .poster-item:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-md);
    }

    .poster-item img {
    width: 100%;
    border-radius: 12px;
    margin-bottom: 15px;
    }

    .poster-item h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--color-primary);
    }

    /*========================================
    TESTIMONI SECTION WITH SCROLL ANIMATIONS
    ========================================*/
    #testimoni {
        background-color: var(--color-hover);
        width: 100%;
        min-height: 100vh;
        margin-top: 200px;
        padding: 50px 0;
    }

    .testimonial-container {
        position: relative;
        overflow: hidden;
        padding: 0 30px;
    }

        .testimonial-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 30px;
            transition: var(--transition-slow);
            min-height: 500px;
        }

        .testimonial-card {
            margin-top: 100px;
            border-radius: 24px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: var(--shadow-md);
            transition: var(--transition-slow);
            position: relative;
            min-width: 320px;
            max-width: 380px;
            opacity: 0.7;
            transform: scale(0.9);
        }

        .testimonial-card.active {
            background: linear-gradient(
                135deg,
                var(--color-primary) 0%,
                var(--color-primary) 100%
            );
            color: var(--color-light);
            opacity: 1;
            transform: scale(1.05);
            box-shadow: var(--shadow-xl);
            z-index: 2;
        }

        .testimonial-card:not(.active) {
            background-color: var(--color-light);
        }

        .profile-container {
            position: relative;
            margin: -70px auto 30px;
            width: 120px;
            height: 120px;
        }

        .profile-ring {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: var(--color-light);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-lg);
        }

        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--color-light);
        }

        .testimonial-card.active .profile-ring {
            background: var(--color-light);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.3);
        }

        .user-name {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--color-dark);
        }

        .testimonial-card.active .user-name {
            color: var(--color-light);
        }

        .user-title {
            font-size: 16px;
            color: var(--color-disabletxt);
            margin-bottom: 25px;
        }

        .testimonial-card.active .user-title {
            color: rgba(255, 255, 255, 0.9);
        }

        .quote-icon {
            font-size: 36px;
            color: var(--color-primary);
            margin-bottom: 20px;
            opacity: 0.8;
        }

        .testimonial-card.active .quote-icon {
            color: var(--color-light);
        }

        .testimonial-text {
            font-size: 16px;
            line-height: 1.6;
            color: var(--color-dark);
            font-style: italic;
        }

        .testimonial-card.active .testimonial-text {
            color: var(--color-light);
        }

        .testimonial-nav {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 50px;
        }

        .nav-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--color-disabletxt);
            cursor: pointer;
            transition: var(--transition-normal);
        }

        .nav-dot.active {
            background: var(--color-primary);
            transform: scale(1.2);
        }

        .nav-arrow {
            position: absolute;
            top: 60%;
            transform: translateY(-50%);
            width: 50px;
            height: 50px;
            background: var(--color-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--shadow-md);
            transition: var(--transition-normal);
            z-index: 3;
        }

        .nav-arrow:hover {
            background: var(--color-primary);
            color: var(--color-light);
            transform: translateY(-50%) scale(1.1);
        }

        .nav-arrow.prev {
            left: 10px;
        }
        .nav-arrow.next {
            right: 10px;
        }

        /* ========================================
    MOBILE RESPONSIVE FIXES - MAX WIDTH 768PX
    ======================================== */

    /* HERO SECTION - MOBILE RESPONSIVE */
    @media (max-width: 768px) {
        #hero {
            min-height: 100vh;
            padding-top: 60px;
            text-align: center;
            overflow-x: hidden;
            width: 100%;
            max-width: 100%;
        }

        #hero .container {
            padding: 0 15px;
        }

        #hero .row {
            flex-direction: column;
            gap: 2rem;
        }

        .hero-content {
            text-align: center;
            padding: 0 10px;
        }

        .hero-tagline h1 {
            font-size: clamp(1.8rem, 8vw, 2.5rem);
            line-height: 1.3;
            margin-bottom: 15px;
        }

        .span1, .span2 {
            display: block;
            margin: 8px 0;
        }

        .hero-text {
            font-size: 1rem;
            margin: 20px 0;
            max-width: 100%;
            padding: 0 10px;
        }

        .hero-buttons {
            flex-direction: column;
            gap: 15px;
            align-items: center;
            margin-top: 20px;
        }

        .button-dark {
            padding: 12px 30px;
            font-size: 1rem;
            width: auto;
            min-width: 200px;
        }

        .hero-link {
            font-size: 0.9rem;
            text-align: center;
        }

        .hero-image {
            order: -1;
            margin-top: 0;
            margin-bottom: 2rem;
        }

        .hero-image img {
            max-width: 90%;
            max-height: 50vh;
            margin-right: 0;
        }
    }

    /* SECTION TITLES - MOBILE RESPONSIVE */
    @media (max-width: 768px) {
        .section-title {
            margin-bottom: 1.5rem;
            padding: 0 15px;
        }

        .section-title h1 {
            font-size: clamp(1.5rem, 6vw, 2.2rem);
            line-height: 1.3;
        }

        .underline {
            width: min(200px, 70%);
            height: 3px;
        }

        .underline::before,
        .underline::after {
            width: 16px;
            height: 16px;
        }
    }

    /* ALASAN SECTION - MOBILE RESPONSIVE */
    @media (max-width: 768px) {
        #alasan {
            padding: 60px 0;
        }

        .alasan-container {
            grid-template-columns: 1fr;
            gap: 40px;
            padding: 15px;
            margin-top: 40px;
            justify-items: center;
        }

        .alasan-card {
            margin-top: 50px;
            width: 300px;
            padding: 25px 15px 20px;
            min-height: auto;
        }

        .alasan-card:hover {
            transform: translateY(-5px);
            transform: translateY(-8px) rotateX(0deg) rotateY(0deg);
        }

        .icon-wrapper {
            width: 100px;
            height: 100px;
            margin-top: -60px;
            padding: 0.8rem;
        }

        .icon-wrapper i {
            font-size: 1.6rem;
        }

        .alasan-title {
            font-size: 1rem;
            margin: 25px 0 15px;
        }

        .alasan-text {
            font-size: 0.8rem;
            line-height: 1.5;
            padding: 0 10px;
        }
    }

    /* GERBANG SECTION - MOBILE RESPONSIVE */
    @media (max-width: 768px) {
        #gerbang {
            padding: 60px 0;
        }

        .gerbang-container {
            grid-template-columns: 1fr;
            gap: 30px;
            margin-top: 30px;
            padding: 0 15px;
        }

        .gerbang-container::before {
            display: none;
        }

        .image-section {
            order: -1;
        }

        .image-section .bg-hover {
            padding: 20px;
        }

        .image-section img {
            width: 100%;
            max-width: 300px;
        }

        .image-section h3 {
            font-size: 1.1rem;
            margin-top: 15px;
        }

        .content-section {
            padding: 15px 0;
        }

        .description {
            margin-bottom: 30px;
            font-size: 1rem;
            line-height: 1.6;
            text-align: justify;
        }

        .vision-mission {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .vision,
        .mission {
            padding: 20px 15px;
        }

        .vision h3,
        .mission h3 {
            font-size: 1.2rem;
            margin-bottom: 12px;
            text-align: center;
        }

        .vision p,
        .mission li {
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .mission li {
            margin-bottom: 10px;
            padding-left: 18px;
        }
    }

    /* LOWONGAN SECTION - MOBILE RESPONSIVE */
    @media (max-width: 768px) {
        #lowongan {
            margin-top: 60px;
            padding: 20px 0;
            margin-bottom: 60px;
        }

        .lowongan-container {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-top: 80px;
            justify-items: center;
            padding: 0 15px;
        }

        .lowongan-card {
            width: 180px;
            height: 160px;
            padding: 1.5rem 1rem;
            border-radius: 50px 50px 0 0;
            margin-bottom: 30px;
        }

        .lowongan-card .icon-wrapper {
            width: 80px;
            height: 80px;
            margin-top: -60px;
            margin-bottom: 15px;
        }

        .lowongan-card .icon-wrapper i {
            font-size: 1.6rem;
        }

        .lowongan-title {
            font-size: 0.8rem;
            margin-bottom: 8px;
            padding: 0 10px;
        }

        .detail-btn {
            width: 60px;
            height: 20px;
            padding: 8px 18px;
            font-size: 0.6rem;
            margin-top: 10px;
        }

        /* Remove hover effects on mobile */
        .lowongan-card:hover {
            transform: none;
            box-shadow: var(--shadow-md);
            background-color: var(--color-light);
        }

        .lowongan-card .icon-wrapper:hover {
            transform: none;
        }
    }

    /* LOWONGAN DETAIL - MOBILE RESPONSIVE */
    @media (max-width: 768px) {
        #lowongan-detail {
            padding: 60px 15px;
        }

        .section-title h1 {
            font-size: 2rem;
        }

        .lowongan-subtext {
            font-size: 0.95rem;
            padding: 0 10px;
            margin-bottom: 30px;
        }

        .poster-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .poster-item {
            padding: 15px;
            border-radius: 12px;
        }

        .poster-item h4 {
            font-size: 1rem;
        }
    }

    /* TESTIMONI SECTION - MOBILE RESPONSIVE */
    @media (max-width: 768px) {
        #testimoni {
            margin-top: 100px;
            padding: 40px 0;
        }

        .testimonial-container {
            padding: 0 15px;
        }

        .testimonial-wrapper {
            flex-direction: column;
            gap: 20px;
            min-height: auto;
        }

        .testimonial-card {
            margin-top: 60px;
            min-width: 100%;
            max-width: 100%;
            padding: 30px 20px;
            transform: scale(1);
            opacity: 1;
        }

        .testimonial-card.active {
            transform: scale(1);
        }

        .profile-container {
            margin: -50px auto 25px;
            width: 100px;
            height: 100px;
        }

        .profile-ring {
            width: 100px;
            height: 100px;
        }

        .profile-image {
            width: 80px;
            height: 80px;
            border: 3px solid var(--color-light);
        }

        .user-name {
            font-size: 20px;
            margin-bottom: 6px;
        }

        .user-title {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .quote-icon {
            font-size: 28px;
            margin-bottom: 15px;
        }

        .testimonial-text {
            font-size: 15px;
            line-height: 1.5;
        }

        .nav-arrow {
            display: none;
        }

        .testimonial-nav {
            margin-top: 30px;
            gap: 10px;
        }

        .nav-dot {
            width: 10px;
            height: 10px;
        }
    }

    /* GENERAL MOBILE OPTIMIZATIONS */
    @media (max-width: 768px) {
        .container {
            padding-left: 15px;
            padding-right: 15px;
        }

        .row {
            margin-left: 0;
            margin-right: 0;
        }

        .col-lg-6 {
            padding-left: 15px;
            padding-right: 15px;
        }

        /* Disable complex animations on mobile for better performance */
        .alasan-card.scroll-visible .icon-wrapper {
            animation: none;
        }

        .hero-image::before {
            display: none;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Touch friendly buttons */
        .button-dark,
        .detail-btn,
        .nav-dot,
        .hero-link {
            min-height: 44px;
            min-width: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Reduce motion for users who prefer it */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    }

    /* EXTRA SMALL DEVICES - MAX WIDTH 480PX */
    @media (max-width: 480px) {
        .hero-tagline h1 {
            font-size: clamp(1.5rem, 7vw, 2rem);
        }

        .section-title h1,
        .section-title h2 {
            font-size: clamp(1.3rem, 5vw, 1.8rem);
        }

        .alasan-container,
        .lowongan-container {
            padding: 0 10px;
        }

        .alasan-card,
        .lowongan-card {
            padding: 20px 10px;
        }

        .button-dark {
            min-width: 180px;
            padding: 10px 25px;
        }

        .hero-text {
            font-size: 0.9rem;
        }

        .vision,
        .mission {
            padding: 15px 10px;
        }
    }

</style>
@endpush
@section('content')
    <!-- Hero Section -->
    <section id="hero" class="hero-gradient position-relative overflow-hidden" lang="{{ app()->getLocale() }}">
        <div class="container h-100">
            <div class="row align-items-center ">
                <!-- Konten Kiri -->
                <div class="col-lg-6 hero-content">
                    <div class="hero-tagline">
                        <h1>
                            {{ __('app.hero_title1')}} <br>
                            <span class="span1">{{ __('app.hero_title2')}}</span>
                            <span class="span2">{{ __('app.hero_title3')}}</span> 
                        </h1>
                        <p class="hero-text poppins-medium">
                            {{ __('app.hero_text')}}
                        </p>
                        <div class="hero-buttons">
                            <a href="daftar">
                                <button class="px-4 py-2 button-dark button-hover poppins-bold">{{ __('app.hero_button')}}</button>
                            </a>
                            <a href="about" class="hero-link poppins-regular">
                                {{ __('app.hero_about')}} <span>&gt;</span>
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
            <div class="section-title text-center judul-section">
                <h1>{{ __('app.alasan_title')}} <span>{{ __('app.alasan_subtitle')}}</span></h1>
                <div class="underline"></div>
            </div>
            
            <div class="alasan-container">
                <!-- Card 1 -->
                <div class="alasan-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-language"></i>
                    </div>
                    <h3 class="alasan-title">{{ __('app.alasan_1_title')}}</h3>
                    <p class="alasan-text">
                        {{ __('app.alasan_1_text')}}
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="alasan-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3 class="alasan-title">{{ __('app.alasan_2_title')}}</h3>
                    <p class="alasan-text">
                        {{ __('app.alasan_2_text')}}                    
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="alasan-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h3 class="alasan-title">{{ __('app.alasan_3_title')}}</h3>
                    <p class="alasan-text">
                        {{ __('app.alasan_3_text')}}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gerbang Section -->
    <section id="gerbang" class="py-5">
        <div class="container h-100">
            <div class="section-title">
                <h1>{{ __('app.gerbang_title')}}</h1>
            </div>
            
            <div class="gerbang-container">
                <!-- Image Section -->
                <div class="image-section">
                    <div class="bg-hover p-5 rounded text-center">
                        <img src="asset/img/foto-konten3.png" alt="LPK Amarta Training">
                        <h3 class="text-dark mt-3">{{ __('app.gerbang_image_caption')}}</h3>
                    </div>
                </div>
                
                <!-- Content Section -->
                <div class="content-section">
                    <div class="description">
                        <p>
                            <span class="company-name">{{ __('app.gerbang_desc')}}</span> <span class="legal-name">{{ __('app.gerbang_desc2')}}</span> {{ __('app.gerbang_text')}}
                        </p>
                    </div>
                    
                    <div class="vision-mission">
                        <div class="vision">
                            <h3>{{ __('app.vision_title')}}</h3>
                            <p>
                                {{ __('app.vision_text')}}
                            </p>
                        </div>
                        
                        <div class="mission">
                            <h3>{{ __('app.mission_title')}}</h3>
                            <ul>
                                <li>{{ __('app.mission_1')}}</li>
                                <li>{{ __('app.mission_2')}}</li>
                                <li>{{ __('app.mission_3')}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lowongan Section -->
<section id="lowongan" class="py-2">
  <div class="container h-100">
    <div class="section-title">
      <h1 class="text-center fw-bold mb-4 judul-section">
        {{__('app.lowongan_title')}} <span>{{__('app.lowongan_subtitle')}}</span>
      </h1>
      <div class="underline"></div>
    </div>

    <div class="lowongan-container">
      <!-- Card 1 -->
      <a href="/lowongan_kerja" class="lowongan-card">
        <div class="icon-wrapper">
          <i class="fas fa-cogs"></i>
        </div>
        <h3 class="lowongan-title">{{__('app.lowongan_1')}}</h3>
        <!-- <span class="detail-btn">Detail</span> -->
      </a>

      <!-- Card 2 -->
      <a href="/lowongan_kerja" class="lowongan-card">
        <div class="icon-wrapper">
          <i class="fas fa-tractor"></i>
        </div>
        <h3 class="lowongan-title">{{__('app.lowongan_2')}}</h3>
        <!-- <span class="detail-btn">Detail</span> -->
      </a>

      <!-- Card 3 -->
      <a href="/lowongan_kerja" class="lowongan-card">
        <div class="icon-wrapper">
          <i class="fas fa-utensils"></i>
        </div>
        <h3 class="lowongan-title">{{__('app.lowongan_3')}}</h3>
        <!-- <span class="detail-btn">Detail</span> -->
      </a>

      <!-- Card 4 -->
      <a href="/lowongan_kerja" class="lowongan-card">
        <div class="icon-wrapper">
          <i class="fas fa-hard-hat"></i>
        </div>
        <h3 class="lowongan-title">{{__('app.lowongan_4')}}</h3>
        <!-- <span class="detail-btn">Detail</span> -->
      </a>

      <!-- Card 5 -->
      <a href="/lowongan_kerja" class="lowongan-card">
        <div class="icon-wrapper">
          <i class="fas fa-paw"></i>
        </div>
        <h3 class="lowongan-title">{{__('app.lowongan_5')}}</h3>
        <!-- <span class="detail-btn">Detail</span> -->
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
