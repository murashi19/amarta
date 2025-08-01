<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPK PT Amarta Indonesia</title>

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <!-- Panggil CSS Swiper -->
    <link rel="stylesheet" href="{{ asset('Asset/swiper/swiper-bundle.min.css') }}">
    <!-- Custom CSS DIdalam Didalam Layout -->
    @stack('styles')
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
}

/*========================================
  FONT CLASSES
========================================*/
.poppins-regular {
    font-family: "Poppins", sans-serif;
    font-weight: 400;
}
.poppins-medium {
    font-family: "Poppins", sans-serif;
    font-weight: 500;
}
.poppins-semibold {
    font-family: "Poppins", sans-serif;
    font-weight: 600;
}
.poppins-bold {
    font-family: "Poppins", sans-serif;
    font-weight: 700;
}

/*========================================
  GLOBAL STYLES
========================================*/
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    scroll-behavior: smooth;
}

body {
    font-family: "Poppins", sans-serif;
    line-height: 1.6;
    overflow-x: hidden;
    animation: pageLoad 1s ease-in-out forwards;
}
.txt-primary {
    color: var(--color-primary);
    font-family: "Poppins", sans-serif;
}
@keyframes pageLoad {
    to {
        opacity: 1;
    }
}

.scroll-hidden {
    opacity: 0;
    transform: translateY(50px);
    transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.scroll-hidden.from-left {
    transform: translateX(-50px) translateY(0);
}

.scroll-hidden.from-right {
    transform: translateX(50px) translateY(0);
}

.scroll-hidden.scale-up {
    transform: scale(0.8) translateY(20px);
}

.scroll-hidden.rotate-in {
    transform: rotate(-10deg) scale(0.9) translateY(30px);
}

/* State ketika elemen sudah visible */
.scroll-visible {
    opacity: 1;
    transform: translateY(0) translateX(0) scale(1) rotate(0);
}

/* Staggered animation untuk multiple elements */
.scroll-stagger-1 {
    transition-delay: 0.1s;
}
.scroll-stagger-2 {
    transition-delay: 0.2s;
}
.scroll-stagger-3 {
    transition-delay: 0.3s;
}
.scroll-stagger-4 {
    transition-delay: 0.4s;
}

/*========================================
  UTILITY CLASSES - BUTTONS
========================================*/
.button-primary {
    background-color: var(--color-primary);
    color: var(--color-light);
    border-radius: 8px;
    border: 2px solid var(--color-primary);
    transition: var(--transition-normal);
    font-weight: 500;
    text-decoration: none;
}

.button-dark {
    background-color: var(--color-dark);
    color: var(--color-light);
    border-radius: 8px;
    border: 2px solid var(--color-dark);
    height: 48px;
    min-width: 140px;
    transition: var(--transition-normal);
    font-weight: 500;
}

.button-secondary {
    display: inline-flex;
    align-items: center;
    background-color: var(--color-light);
    color: var(--color-primary);
    border-radius: 8px;
    border: 2px solid var(--color-primary);
    transition: var(--transition-normal);
    font-weight: 500;
    text-decoration: none;
}

.button-hover:hover {
    background-color: var(--color-light);
    color: var(--color-dark);
    border-color: var(--color-light);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.button-hoversecondary:hover {
    background-color: var(--color-primary);
    color: var(--color-light);
    border-color: var(--color-primary);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/*========================================
  NAVIGATION BAR
========================================*/
.navbar {
    z-index: 1000;
    position: fixed;
    top: 0;
    width: 100%;
    transition: var(--transition-normal);
    backdrop-filter: blur(10px);
    background-color: rgba(239, 242, 246, 0.95) !important;
    box-shadow: var(--shadow-sm);
    min-height: 80px;
    padding: 0.5rem 1rem;
}

.navbar-brand {
    font-weight: 700;
    font-size: 1.5rem;
    color: var(--color-primary) !important;
}

.nav-link {
    color: var(--color-disabletxt) !important;
    font-weight: 600;
    font-size: 18px;
    position: relative;
    transition: var(--transition-normal);
}

.nav-link:hover,
.nav-link.active {
    color: var(--color-primary) !important;
}

.nav-link.active::after,
.nav-link:hover::after {
    content: "";
    position: absolute;
    bottom: -5px;
    left: 50%;
    transform: translateX(-50%);
    width: 30px;
    height: 3px;
    background-color: var(--color-primary);
    border-radius: 2px;
}

@media (max-width: 768px) {
    .nav-link.active::after,
    .nav-link:hover::after {
    content: "";
    position: absolute;
    bottom: -5px;
    left: 10%;
    transform: translateX(-50%);
    width: 30px;
    height: 3px;
    background-color: var(--color-primary);
    border-radius: 2px;
}
}

.language {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0 20px;
    margin-right: 50px;
}

.language button {
    border: none;
    background: transparent;
    padding: 5px;
    border-radius: 4px;
    transition: var(--transition-normal);
}

.language button:hover {
    background-color: var(--color-hover);
}

.language button img {
    width: 24px;
    height: auto;
}

.button-nav {
    display: flex;
    gap: 10px;
    transition: var(--transition-normal);
}

.content {
    margin-top: 80px;
}

/*========================================
  HERO SECTION WITH ANIMATIONS
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

    .hero-image {
        margin-top: 2rem;
        transform: translateY(20px);
        animation: mobileImageFade 0.8s ease-out 0.4s forwards;
    }

    @keyframes mobileImageFade {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .hero-image img {
        margin-right: 0;
        max-height: 60vh;
    }

    .hero-image::before {
        display: none;
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
    margin-bottom: 4rem;
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
    padding: 100px 0;
    background-color: #fff;
}

.alasan-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
    padding: 20px;
    margin-top: 100px;
    max-width: 1400px;
    margin-left: auto;
    margin-right: auto;
}

.alasan-card {
    background-color: var(--color-light);
    border-radius: 20px;
    padding: 30px 20px 20px;
    box-shadow: var(--shadow-md);
    min-height: 420px;
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
    margin-top: -90px;
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
    font-size: 2.5rem;
}

.alasan-title {
    font-size: 1.2rem;
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
    gap: 50px;
    align-items: start;
    margin-top: 50px;
    position: relative;
    max-width: 1400px;
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
  LOWONGAN SECTION WITH SCROLL ANIMATIONS
========================================*/
#lowongan {
    background-color: #fff;
    width: 100%;
    margin-top: 100px;
    padding: 50px 0;
    margin-bottom: 100px;
}

.lowongan-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 2rem;
    margin-top: 170px;
    padding: 20px;
}

.lowongan-card {
    background-color: var(--color-light);
    border-radius: 60px 60px 0 0;
    box-shadow: var(--shadow-md);
    min-height: 160px;
    padding: 1.5rem 1rem;
    text-align: center;
    transition: transform 0.4s ease, box-shadow 0.4s ease;
    position: relative;
}

.lowongan-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-lg);
    background-color: var(--color-hover);
}

.lowongan-card .icon-wrapper {
    background-color: var(--color-primary);
    padding: 0.75rem;
    border-radius: 50%;
    width: 130px;
    height: 130px;
    margin: 0 auto -20px auto;
    margin-top: -90px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: var(--shadow-md);
    transition: var(--transition-normal);
}

.lowongan-card .icon-wrapper:hover {
    transform: scale(1.05) rotate(3deg);
}

.lowongan-card .icon-wrapper i {
    color: white;
    font-size: 1.8rem;
}

.lowongan-title {
    font-size: 1rem;
    font-weight: 600;
    margin-top: 2.5rem;
    color: var(--color-dark);
}

/*========================================
  TESTIMONI SECTION WITH SCROLL ANIMATIONS
========================================*/
#testimoni {
    background-color: var(--color-hover);
    width: 100%;
    height: 100vh;
    margin-top: 200px;
    padding: 100px 0;
}

.testimonial-container {
    position: relative;
    overflow: hidden;
    padding: 0 50px;
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

/*========================================
  SECTION DIVIDER WITH ANIMATIONS
========================================*/
.section-divider {
    height: 100px;
    position: relative;
    overflow: hidden;
}

.section-divider::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 2px;
    background: linear-gradient(
        90deg,
        transparent,
        var(--color-primary),
        transparent
    );
    top: 50%;
    transform: translateY(-50%);
    transition: left 1.5s ease-out;
}

.section-divider.scroll-visible::before {
    left: 100%;
}
/*========================================
  RESPONSIVE DESIGN
========================================*/
@media (max-width: 1200px) {
    .hero-image img {
        margin-right: -200px;
    }

    .button-nav {
        margin-right: -150px;
    }
}

@media (max-width: 992px) {
    .navbar {
        padding: 0.5rem 1rem;
        min-height: 70px;
    }

    .content {
        margin-top: 70px;
    }

    .hero-image img {
        margin-right: 0;
        max-height: 60vh;
    }

    .button-nav {
        margin-right: 0;
        gap: 8px;
    }

    .gerbang-container {
        grid-template-columns: 1fr;
        gap: 30px;
    }

    .gerbang-container::before {
        display: none;
    }

    .vision-mission {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .footer-content {
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }

    .carousel-section2 {
        flex-direction: column;
        gap: 20px;
    }

    .nav-button2 {
        position: relative;
    }

    .nav-prev2,
    .nav-next2 {
        order: unset;
    }

    .carousel-container2 {
        order: unset;
    }
}

@media (max-width: 768px) {
    .language {
        display: none;
    }

    .hero-buttons {
        flex-direction: column;
        align-items: flex-start;
    }

    .alasan-container {
        grid-template-columns: 1fr;
        gap: 20px;
        padding: 10px;
    }

    .lowongan-container {
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1.5rem;
    }

    .testimonial-wrapper {
        flex-direction: column;
        gap: 20px;
        padding: 0 20px;
    }

    .testimonial-card {
        min-width: 280px;
        max-width: 320px;
        margin-top: 80px;
    }

    .nav-arrow {
        display: none;
    }

    .carousel-item2 {
        flex: 0 0 calc(50% - 10px);
    }

    .footer-content {
        grid-template-columns: 1fr;
        gap: 25px;
        text-align: center;
    }

    .social-media {
        justify-content: center;
    }

    #testimoni {
        height: auto;
        min-height: 100vh;
    }

    #program-unggulan,
    #kegiatan-kami {
        height: auto;
    }
}

@media (max-width: 576px) {
    .section-title h1 {
        font-size: 2rem;
    }

    .underline {
        width: 200px;
    }

    .hero-text {
        font-size: 1rem;
    }

    .testimonial-card {
        min-width: 260px;
        max-width: 280px;
        padding: 30px 20px;
    }

    .carousel-item2 {
        flex: 0 0 calc(100% - 0px);
    }

    .carousel-section2 {
        padding: 0 10px;
    }

    .swiper-button-next,
    .swiper-button-prev {
        width: 45px !important;
        height: 45px !important;
    }
}

/*========================================
  ANIMATIONS AND EFFECTS
========================================*/
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

@keyframes fadeInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes pulse {
    0%,
    100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

.animate-fadeInUp {
    animation: fadeInUp 0.8s ease forwards;
}

.animate-fadeInLeft {
    animation: fadeInLeft 0.8s ease forwards;
}

.animate-fadeInRight {
    animation: fadeInRight 0.8s ease forwards;
}

.animate-pulse {
    animation: pulse 2s infinite;
}

/* Scroll animations */
.scroll-reveal {
    opacity: 0;
    transform: translateY(50px);
    transition: all 0.8s ease;
}

.scroll-reveal.revealed {
    opacity: 1;
    transform: translateY(0);
}

/*========================================
  ADDITIONAL UTILITY CLASSES
========================================*/
.text-gradient {
    background: linear-gradient(
        135deg,
        var(--color-primary),
        var(--color-info)
    );
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.backdrop-blur {
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}

.glass-effect {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.hover-lift {
    transition: var(--transition-normal);
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.gradient-border {
    position: relative;
    background: linear-gradient(
        135deg,
        var(--color-primary),
        var(--color-info)
    );
    border-radius: 12px;
    padding: 2px;
}

.gradient-border::before {
    content: "";
    position: absolute;
    inset: 2px;
    background: var(--color-light);
    border-radius: 10px;
    z-index: -1;
}

/*========================================
  PRINT STYLES
========================================*/
@media print {
    .navbar,
    .hero-buttons,
    .testimonial-nav,
    .nav-arrow,
    .carousel-control-prev,
    .carousel-control-next,
    .swiper-button-next,
    .swiper-button-prev,
    .footer-section:last-child {
        display: none !important;
    }

    body {
        font-size: 12pt;
        line-height: 1.4;
    }

    .section-title h1 {
        font-size: 18pt;
        margin-bottom: 20pt;
    }

    .alasan-card,
    .testimonial-card {
        break-inside: avoid;
        box-shadow: none;
        border: 1px solid #ddd;
    }
}

/*========================================
  ACCESSIBILITY IMPROVEMENTS
========================================*/
@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }

    .scroll-reveal {
        opacity: 1;
        transform: none;
    }
}

/* High contrast mode support */
@media (prefers-contrast: high) {
    :root {
        --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.3);
        --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.4);
        --shadow-lg: 0 8px 25px rgba(0, 0, 0, 0.5);
    }

    .testimonial-card:not(.active) {
        border: 2px solid var(--color-dark);
    }

    .gallery-overlay {
        background: rgba(0, 0, 0, 0.8);
    }
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

.gallery-subtitle {
    font-size: 1.2rem;
    color: var(--color-disabletxt);
    margin-bottom: 50px;
    font-weight: 400;
}

/*========================================
  FOOTER SECTION
========================================*/

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
/* Footer Container */
.footer {
    background: linear-gradient(
        135deg,
        var(--color-primary) 0%,
        var(--color-info) 100%
    );
    position: relative;
    overflow: hidden;
    padding: 80px 0 40px;
    color: white;
}

/* Wave Background */
.wave-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 400'%3E%3Cpath d='M0,100 C150,200 350,0 500,100 C650,200 850,0 1000,100 C1100,150 1150,100 1200,120 L1200,400 L0,400 Z' fill='%23ffffff' fill-opacity='0.1'/%3E%3Cpath d='M0,200 C200,300 400,100 600,200 C800,300 1000,100 1200,200 L1200,400 L0,400 Z' fill='%23ffffff' fill-opacity='0.05'/%3E%3Cpath d='M0,300 C300,350 600,250 900,300 C1050,325 1150,275 1200,300 L1200,400 L0,400 Z' fill='%23ffffff' fill-opacity='0.08'/%3E%3C/svg%3E");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: bottom;
    opacity: 0.6;
}

.footer-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
    position: relative;
    z-index: 2;
}

.footer-content {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 60px;
    margin-bottom: 40px;
}

/* Logo Section */
.footer-logo-section {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.logo-container {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 30px;
}

.logo-text {
    font-size: 18px;
    font-weight: 700;
    color: var(--color-dark);
    text-align: center;
}

/* Column Headers */
.footer-column h3 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 20px;
    color: white;
}

.footer-column p {
    font-size: 16px;
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 20px;
}

/* Location Button */
.location-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 12px 20px;
    border-radius: 25px;
    text-decoration: none;
    font-size: 16px;
    font-weight: 500;
    transition: all 0.3s ease;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.location-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
}

.location-icon {
    width: 16px;
    height: 16px;
    fill: currentColor;
}

/* Contact Section */
.contact-section {
    text-align: left;
}

.contact-highlight {
    color: var(--color-warning);
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 15px;
    display: block;
}

.consultation-text {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 20px;
    color: rgba(255, 255, 255, 0.95);
}

.social-links {
    display: flex;
    gap: 15px;
    margin-bottom: 25px;
}

.social-link {
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.social-link:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-3px);
}

.whatsapp {
    background: rgba(37, 211, 102, 0.3);
    border-color: rgba(37, 211, 102, 0.5);
}

.instagram {
    background: rgba(225, 48, 108, 0.3);
    border-color: rgba(225, 48, 108, 0.5);
}

.social-icon {
    width: 20px;
    height: 20px;
    fill: white;
}

.email-info {
    font-size: 16px;
    color: rgba(255, 255, 255, 0.9);
}

/* Copyright */
.footer-bottom {
    text-align: center;
    padding-top: 30px;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

.copyright {
    font-size: 16px;
    color: rgba(255, 255, 255, 0.8);
    font-weight: 400;
}

/* Responsive Design */
@media (max-width: 768px) {
    .footer-content {
        grid-template-columns: 1fr;
        gap: 40px;
        text-align: center;
    }

    .footer-logo-section {
        align-items: center;
    }

    .contact-section {
        text-align: center;
    }

    .social-links {
        justify-content: center;
    }

    .footer-column h3 {
        font-size: 20px;
    }

    .logo-container {
        width: 100px;
        height: 100px;
    }

    .footer {
        padding: 60px 0 30px;
    }
}

@media (max-width: 480px) {
    .footer-container {
        padding: 0 15px;
    }

    .footer-content {
        gap: 30px;
    }

    .footer-column h3 {
        font-size: 18px;
    }

    .footer-column p {
        font-size: 14px;
    }

    .logo-container {
        width: 80px;
        height: 80px;
    }

    .logo-text {
        font-size: 14px;
    }
}

/* Animation */
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

.footer-column {
    animation: fadeInUp 0.6s ease forwards;
}

.footer-column:nth-child(1) {
    animation-delay: 0.1s;
}
.footer-column:nth-child(2) {
    animation-delay: 0.2s;
}
.footer-column:nth-child(3) {
    animation-delay: 0.3s;
}
    </style>

    
    @stack('styles')
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-graduation-cap me-2"></i>
                Amarta
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item mx-2">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">Home</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link {{ Request::is('program') ? 'active' : '' }}" href="{{ url('program') }}">Program</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link {{ Request::is('about') ? 'active' : '' }}" href="{{ url('about') }}">About Us</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link {{ Request::is('contact') ? 'active' : '' }}" href="{{ url('contact') }}">Contact</a>
                    </li>
                </ul>


                <div class="language">
                    <button><img src="{{ asset('Asset/img/indo.png') }}" alt="Indonesia"></button>
                    <span>|</span>
                    <button><img src="{{ asset('Asset/img/jap.png') }}" alt="Jepang"></button>
                </div>

                <div class="button-nav">
                    <a class="px-4 py-2 button-secondary button-hoversecondary poppins-medium" href="{{ url('daftar') }}">Register</a>
                    <a class="px-4 py-2 button-primary button-hover poppins-medium" href="{{ url('login') }}">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
     <div class="content">
        @yield('content')
     </div>
        
    <!-- Footer -->
    <footer class="footer">
        <div class="wave-background"></div>
        <div class="footer-container">
            <div class="footer-content">
                <!-- Logo Section -->
                <div class="footer-column footer-logo-section">
                    <div class="logo-container">
                        <img src="{{ asset('Asset/img/Amarta-Logo.png') }}" alt="">
                    </div>
                    <h3>LPK Amartha Indonesia</h3>
                    <p>AMARTA BANGUN INDONESIA adalah Perusahaan Swasta yang bergerak sebagai Penyedia Jasa recruitment semua level yang berdiri pada tanggal 10 juli 2020.</p>
                </div>

                <!-- Location Section -->
                <div class="footer-column">
                    <h3>Lokasi Kantor</h3>
                    <p>Sukajaya, Kec. Cibitung, Kabupaten Bekasi, Jawa Barat</p>
                    <a href="https://maps.app.goo.gl/FSzUzLi9fZwsgTdt9" class="location-btn">
                        <svg class="location-icon" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                        Lihat Maps
                    </a>
                </div>

                <!-- Contact Section -->
                <div class="footer-column contact-section">
                    <h3>Kontak Kami</h3>
                    <span class="contact-highlight">Tanya - Tanya Klik Disini !</span>
                    <p class="consultation-text">Konsultasi Gratis !!</p>
                    
                    <div class="social-links">
                        <a href="#" class="social-link whatsapp">
                            <svg class="social-icon" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.488"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link instagram">
                            <svg class="social-icon" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                    </div>

                    <div class="email-info">
                        <strong>Email :</strong> example@gmail.com
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="footer-bottom">
                <p class="copyright">© 2025 LPK Amartha - All Rights Reserved</p>
            </div>
        </div>
    </footer>
    
    <!-- Custom Scripts -->
    @stack('scripts')
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
     <!-- Local Swiper JS -->
    <script src="{{ Asset('/asset/swiper/swiper-bundle.min.js') }}"></script>
    <script>
        // ================================= TESTIMONIAL CAROUSEL =================================
const TestimonialCarousel = {
    currentSlide: 0,

    showSlide(index) {
        const slides = document.querySelectorAll('.testimonial-card');
        const dots = document.querySelectorAll('.nav-dot');

        if (index >= slides.length) {
            this.currentSlide = 0;
        } else if (index < 0) {
            this.currentSlide = slides.length - 1;
        } else {
            this.currentSlide = index;
        }

        // Reset semua card dan dot
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));

        // Aktifkan slide & dot saat ini
        if (slides[this.currentSlide]) {
            slides[this.currentSlide].classList.add('active');
        }
        if (dots[this.currentSlide]) {
            dots[this.currentSlide].classList.add('active');
        }
    },

    changeTestimonial(direction) {
        this.showSlide(this.currentSlide + direction);
    },

    goToSlide(index) {
        this.showSlide(index);
    },

    init() {
        this.showSlide(this.currentSlide);
    }
};

// ================================= PROGRAM CAROUSEL =================================
const ProgramCarousel = {
    currentSlide: 0,
    itemsPerPage: 3,
    totalItems: 6,

    get totalSlides() {
        return Math.ceil(this.totalItems / this.itemsPerPage);
    },

    generateIndicators() {
        const indicatorsContainer = document.getElementById('indicators');
        if (!indicatorsContainer) return;

        indicatorsContainer.innerHTML = '';

        for (let i = 0; i < this.totalSlides; i++) {
            const indicator = document.createElement('button');
            indicator.className = 'indicator';
            if (i === 0) indicator.classList.add('active');
            indicator.addEventListener('click', () => this.goToSlide(i));
            indicatorsContainer.appendChild(indicator);
        }
    },

    updateCarousel() {
        const wrapper = document.getElementById('carouselWrapper');
        if (!wrapper) return;

        const itemWidth = 100 / this.itemsPerPage;
        const translateX = -this.currentSlide * itemWidth;
        wrapper.style.transform = `translateX(${translateX}%)`;

        // Update indicators
        document.querySelectorAll('.indicator').forEach((indicator, index) => {
            indicator.classList.toggle('active', index === this.currentSlide);
        });
    },

    goToSlide(slideIndex) {
        this.currentSlide = slideIndex;
        this.updateCarousel();
    },

    previousSlide() {
        if (this.currentSlide > 0) {
            this.currentSlide--;
        } else {
            this.currentSlide = this.totalSlides - 1;
        }
        this.updateCarousel();
    },

    nextSlide() {
        if (this.currentSlide < this.totalSlides - 1) {
            this.currentSlide++;
        } else {
            this.currentSlide = 0;
        }
        this.updateCarousel();
    },

    updateResponsive() {
        const width = window.innerWidth;
        let newItemsPerPage;

        if (width <= 768) {
            newItemsPerPage = 1;
        } else if (width <= 992) {
            newItemsPerPage = 2;
        } else {
            newItemsPerPage = 3;
        }

        if (newItemsPerPage !== this.itemsPerPage) {
            this.itemsPerPage = newItemsPerPage;
            this.currentSlide = Math.min(this.currentSlide, this.totalSlides - 1);
            this.generateIndicators();
            this.updateCarousel();
        }
    },

    init() {
        this.updateResponsive();
        this.generateIndicators();
        this.updateCarousel();
    }
};



// ================================= LEGALITAS CAROUSEL =================================
const LegalitasCarousel = {
    currentIndex: 0,
    realIndex: 0,
    slideWidth: 0,
    visibleSlides: 4,
    totalSlides: 0,
    wrapper: null,
    slides: [],
    indicators: [],

    setupClones() {
        const container = document.getElementById('sliderWrapper');
        if (!container) return;

        this.slides = Array.from(container.children);
        this.totalSlides = this.slides.length;

        // Clone depan & belakang
        const clonesBefore = this.slides.slice(-this.visibleSlides).map(slide => slide.cloneNode(true));
        const clonesAfter = this.slides.slice(0, this.visibleSlides).map(slide => slide.cloneNode(true));

        // Sisipkan clone
        clonesBefore.forEach(clone => container.insertBefore(clone, container.firstChild));
        clonesAfter.forEach(clone => container.appendChild(clone));

        // Update slides
        this.slides = Array.from(container.children);
    },

    updateIndicators() {
        this.indicators.forEach((dot, idx) => {
            dot.classList.toggle('active', idx === this.realIndex);
        });
    },

    updatePosition(animate = true) {
        if (!this.wrapper) return;
        this.wrapper.style.transition = animate ? 'transform 0.5s ease-in-out' : 'none';
        const offset = (this.currentIndex + this.visibleSlides) * this.slideWidth;
        this.wrapper.style.transform = `translateX(-${offset}px)`;
        this.updateIndicators();
    },

    nextSlide() {
        this.currentIndex++;
        this.realIndex = (this.realIndex + 1) % this.totalSlides;
        this.updatePosition();

        // Reset posisi kalau sudah di clone belakang
        if (this.currentIndex >= this.totalSlides) {
            setTimeout(() => {
                this.currentIndex = 0;
                this.updatePosition(false);
            }, 500);
        }
    },

    goToSlide(index) {
        this.currentIndex = index;
        this.realIndex = index % this.totalSlides;
        this.updatePosition();
    },

    init() {
        this.wrapper = document.getElementById('sliderWrapper');
        if (!this.wrapper) return;

        this.setupClones();

        // Hitung lebar slide
        const slide = this.wrapper.querySelector('.certificate-card');
        this.slideWidth = slide.offsetWidth + 20; // termasuk margin

        // Ambil indikator
        this.indicators = document.querySelectorAll('#sliderIndicators span');

        // Tombol Next
        const nextBtn = document.getElementById('nextBtn');
        if (nextBtn) {
            nextBtn.addEventListener('click', () => this.nextSlide());
        }

        // Indikator klik
        this.indicators.forEach((dot, idx) => {
            dot.addEventListener('click', () => {
                this.currentIndex = idx;
                this.realIndex = idx;
                this.updatePosition();
            });
        });

        // Set posisi awal
        this.updatePosition(false);

        // Enable drag
        this.enableDrag();
    },
    enableDrag() {
        let isDragging = false;
        let startX = 0;
        let currentTranslate = 0;
        let prevTranslate = 0;
        let animationID = 0;

        const slider = this.wrapper;

        const setSliderPosition = () => {
            slider.style.transform = `translateX(${currentTranslate}px)`;
        };

        const animation = () => {
            setSliderPosition();
            if (isDragging) requestAnimationFrame(animation);
        };

        const touchStart = (index) => (event) => {
            isDragging = true;
            startX = event.type.includes('mouse') ? event.pageX : event.touches[0].clientX;
            prevTranslate = -((this.currentIndex + this.visibleSlides) * this.slideWidth);
            animationID = requestAnimationFrame(animation);
            slider.style.transition = 'none';
        };

        const touchMove = (event) => {
            if (!isDragging) return;
            const currentX = event.type.includes('mouse') ? event.pageX : event.touches[0].clientX;
            const diff = currentX - startX;
            currentTranslate = prevTranslate + diff;
        };

        const touchEnd = () => {
            cancelAnimationFrame(animationID);
            isDragging = false;

            const movedBy = currentTranslate - prevTranslate;

            if (movedBy < -100) {
                this.nextSlide(); // geser ke kanan
            } else if (movedBy > 100) {
                this.currentIndex = (this.currentIndex - 1 + this.totalSlides) % this.totalSlides;
                this.realIndex = (this.realIndex - 1 + this.totalSlides) % this.totalSlides;
                this.updatePosition();
            } else {
                this.updatePosition(); // balik ke posisi awal
            }
        };

        // Mouse events
        slider.addEventListener('mousedown', touchStart());
        slider.addEventListener('mousemove', touchMove);
        slider.addEventListener('mouseup', touchEnd);
        slider.addEventListener('mouseleave', () => { if (isDragging) touchEnd(); });

        // Touch events
        slider.addEventListener('touchstart', touchStart());
        slider.addEventListener('touchmove', touchMove);
        slider.addEventListener('touchend', touchEnd);
    }
};



// ========================================
// COMPANY SECTION ANIMATIONS
// ========================================

document.addEventListener('DOMContentLoaded', function () {
    // Intersection Observer untuk animasi scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -10px 0px'
    };

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
            }
        });
    }, observerOptions);

    // Observe semua elemen yang perlu dianimasi
    const elementsToAnimate = [
        '.company-content',
        '.company-image',
        '.vision-mission-card',
        '.mission-list'
    ];

    elementsToAnimate.forEach(selector => {
        const elements = document.querySelectorAll(selector);
        elements.forEach(element => {
            observer.observe(element);
        });
    });

    // Animasi khusus untuk text elements
    const textElements = [
        '.company-title',
        '.company-subtitle',
        '.company-description'
    ];

    textElements.forEach(selector => {
        const elements = document.querySelectorAll(selector);
        elements.forEach(element => {
            observer.observe(element);
        });
    });

    // Enhanced hover effects untuk cards
    const visionMissionCards = document.querySelectorAll('.vision-mission-card');

    visionMissionCards.forEach(card => {
        card.addEventListener('mouseenter', function () {
            this.style.transform = 'translateY(-10px) scale(1.02)';
            this.style.boxShadow = 'var(--shadow-hover)';
        });

        card.addEventListener('mouseleave', function () {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = 'var(--shadow-soft)';
        });
    });

    // Smooth scroll ke section jika dipanggil dari link
    const companySection = document.getElementById('company');
    if (window.location.hash === '#company') {
        setTimeout(() => {
            companySection.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }, 100);
    }

    // Counter animation untuk angka (jika ada)
    function animateCounter(element, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const current = Math.floor(progress * (end - start) + start);
            element.textContent = current;
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    // Parallax effect ringan untuk background (opsional)
    window.addEventListener('scroll', function () {
        const scrolled = window.pageYOffset;
        const companySection = document.getElementById('company');

        if (companySection) {
            const rate = scrolled * -0.1;
            companySection.style.transform = `translateY(${rate}px)`;
        }
    });

    // Typing effect untuk title (opsional)
    function typeWriter(element, text, speed = 100) {
        let i = 0;
        element.textContent = '';

        function type() {
            if (i < text.length) {
                element.textContent += text.charAt(i);
                i++;
                setTimeout(type, speed);
            }
        }
        type();
    }

    // Loading animation untuk gambar
    const companyImage = document.querySelector('.company-image img');
    if (companyImage) {
        companyImage.addEventListener('load', function () {
            this.style.opacity = '1';
            this.style.transform = 'scale(1)';
        });
    }

    // Lazy loading untuk performa
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // Smooth reveal untuk mobile
    if (window.innerWidth <= 768) {
        const mobileElements = document.querySelectorAll('.vision-mission-card');
        mobileElements.forEach((element, index) => {
            element.style.transitionDelay = `${index * 0.2}s`;
        });
    }

    console.log('Company section animations initialized');
});



// ========================================
// PENDIRI SECTION ANIMATIONS
// ========================================

document.addEventListener('DOMContentLoaded', function () {
    // Intersection Observer untuk animasi scroll
    const observerOptions = {
        threshold: 0.2,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');

                // Special handling untuk text elements
                if (entry.target.classList.contains('text-reveal')) {
                    setTimeout(() => {
                        entry.target.classList.add('animate');
                    }, 200);
                }
            }
        });
    }, observerOptions);

    // Elements yang akan diobserve
    const elementsToObserve = [
        '.pendiri-image2',
        '.pendiri-content',
        '.judul-h3',
        '.judul-h1',
        '.text-body'
    ];

    elementsToObserve.forEach(selector => {
        const elements = document.querySelectorAll(selector);
        elements.forEach(element => {
            observer.observe(element);
        });
    });

    // Text reveal animation
    const textRevealElements = document.querySelectorAll('.text-reveal');
    textRevealElements.forEach(element => {
        observer.observe(element);
    });

    // Enhanced image hover effects
    const pendiriImage = document.querySelector('.pendiri-image2 img');
    if (pendiriImage) {
        pendiriImage.addEventListener('mouseenter', function () {
            this.style.transform = 'scale(1.05) rotate(1deg)';
            this.style.boxShadow = '0 15px 40px rgba(0, 0, 0, 0.15)';
        });

        pendiriImage.addEventListener('mouseleave', function () {
            this.style.transform = 'scale(1) rotate(0deg)';
            this.style.boxShadow = '0 10px 30px rgba(0, 0, 0, 0.1)';
        });

        // Loading animation
        pendiriImage.addEventListener('load', function () {
            this.style.opacity = '1';
        });

        // Error handling
        pendiriImage.addEventListener('error', function () {
            this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxOCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkltYWdlIG5vdCBmb3VuZDwvdGV4dD48L3N2Zz4=';
        });
    }

    // Parallax effect untuk background circles
    window.addEventListener('scroll', function () {
        const scrolled = window.pageYOffset;
        const pendiriSection = document.getElementById('pendiri');

        if (pendiriSection) {
            const rect = pendiriSection.getBoundingClientRect();
            const isInView = rect.top < window.innerHeight && rect.bottom > 0;

            if (isInView) {
                const circles = document.querySelectorAll('.bg-circle');
                circles.forEach((circle, index) => {
                    const speed = 0.5 + (index * 0.2);
                    const yPos = -(scrolled * speed);
                    circle.style.transform = `translateY(${yPos}px)`;
                });
            }
        }
    });

    // Typing effect untuk judul
    function typeWriter(element, text, speed = 80) {
        const originalText = element.textContent;
        element.textContent = '';
        let i = 0;

        function type() {
            if (i < text.length) {
                element.textContent += text.charAt(i);
                i++;
                setTimeout(type, speed);
            }
        }

        // Start typing when element is animated
        const checkAnimate = setInterval(() => {
            if (element.classList.contains('animate')) {
                clearInterval(checkAnimate);
                setTimeout(type, 500);
            }
        }, 100);
    }

    // Apply typing effect to titles
    const h3Element = document.querySelector('.judul-h3');
    const h1Element = document.querySelector('.judul-h1');

    if (h3Element) {
        const h3Text = h3Element.textContent;
        typeWriter(h3Element, h3Text, 60);
    }

    if (h1Element) {
        const h1Text = h1Element.textContent;
        setTimeout(() => {
            typeWriter(h1Element, h1Text, 80);
        }, 1000);
    }

    // Smooth scroll ke section jika dipanggil dari link
    if (window.location.hash === '#pendiri') {
        setTimeout(() => {
            document.getElementById('pendiri').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }, 100);
    }

    // Progressive text loading untuk paragraph
    const textBody = document.querySelector('.text-body');
    if (textBody) {
        const originalText = textBody.textContent;
        textBody.textContent = '';

        const checkTextAnimate = setInterval(() => {
            if (textBody.classList.contains('animate')) {
                clearInterval(checkTextAnimate);

                // Reveal text word by word
                const words = originalText.split(' ');
                let wordIndex = 0;

                const revealWords = setInterval(() => {
                    if (wordIndex < words.length) {
                        textBody.textContent += (wordIndex > 0 ? ' ' : '') + words[wordIndex];
                        wordIndex++;
                    } else {
                        clearInterval(revealWords);
                    }
                }, 50);
            }
        }, 100);
    }

    // Lazy loading optimization
    if ('IntersectionObserver' in window) {
        const lazyImageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        lazyImageObserver.unobserve(img);
                    }
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            lazyImageObserver.observe(img);
        });
    }

    // Mobile touch interactions
    if ('ontouchstart' in window) {
        const pendiriCard = document.querySelector('.pendiri-content');
        if (pendiriCard) {
            pendiriCard.addEventListener('touchstart', function () {
                this.style.transform = 'scale(0.98)';
            });

            pendiriCard.addEventListener('touchend', function () {
                this.style.transform = 'scale(1)';
            });
        }
    }

    // Performance monitoring
    const performanceObserver = new PerformanceObserver((list) => {
        for (const entry of list.getEntries()) {
            if (entry.entryType === 'measure') {
                console.log(`Animation ${entry.name}: ${entry.duration}ms`);
            }
        }
    });

    if (typeof PerformanceObserver !== 'undefined') {
        performanceObserver.observe({ entryTypes: ['measure'] });
    }

    console.log('Pendiri section animations initialized');
});



// ================================= GLOBAL FUNCTIONS =================================
// Global functions untuk testimonial carousel
window.changeTestimonial = function (direction) {
    TestimonialCarousel.changeTestimonial(direction);
};

window.goToTestimonialSlide = function (index) {
    TestimonialCarousel.goToSlide(index);
};

// Global functions untuk program carousel
window.previousSlide = function () {
    ProgramCarousel.previousSlide();
};

window.nextSlide = function () {
    ProgramCarousel.nextSlide();
};

window.goToSlide = function (index) {
    ProgramCarousel.goToSlide(index);
};

// Enhanced debugging functions
window.debugSwiper = function () {
    GallerySwiper.checkStatus();
};

window.testSwiper = function (direction = 'next') {
    GallerySwiper.testSlide(direction);
};

window.reinitSwiper = function () {
    GallerySwiper.reinit();
};

// ================================= INITIALIZATION =================================
document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM Content Loaded');

    // Initialize carousels
    TestimonialCarousel.init();
    ProgramCarousel.init();
    LegalitasCarousel.init();

    // Initialize Gallery Swiper with longer delay for mobile
    const initDelay = window.innerWidth <= 768 ? 300 : 100;
    setTimeout(() => {
        GallerySwiper.init();
    }, initDelay);
});

// Handle window resize
window.addEventListener('resize', function () {
    ProgramCarousel.updateResponsive();
});

// Handle page visibility change
document.addEventListener('visibilitychange', function () {
    if (GallerySwiper.swiper) {
        if (document.hidden) {
            GallerySwiper.swiper.autoplay?.stop();
        } else {
            GallerySwiper.swiper.autoplay?.start();
        }
    }
});

// Handle orientation change (mobile)
window.addEventListener('orientationchange', function () {
    setTimeout(() => {
        if (GallerySwiper.swiper) {
            GallerySwiper.swiper.update();
            console.log('Swiper updated after orientation change');
        }
    }, 500);
});

// Handle window resize
let resizeTimeout;
window.addEventListener('resize', function () {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
        const wasMobile = GallerySwiper.isMobile;
        const isMobile = window.innerWidth <= 768;
        
        if (wasMobile !== isMobile) {
            console.log('Device type changed, reinitializing swiper');
            GallerySwiper.reinit();
        } else if (GallerySwiper.swiper) {
            GallerySwiper.swiper.update();
        }
    }, 250);
});


/*========================================
  WEBSITE SCROLL ANIMATION CONTROLLER
========================================*/

class ScrollAnimationController {
    constructor() {
        this.init();
        this.setupTestimonialSlider();
        this.currentTestimonialIndex = 0;
        this.testimonialInterval = null;
    }

    init() {
        // Setup intersection observers
        this.setupScrollObserver();
        this.setupSectionObserver();

        // Setup testimonial functionality
        this.initTestimonials();

        // Setup smooth scrolling
        this.setupSmoothScrolling();

        // Setup staggered animations
        this.setupStaggeredAnimations();

        // Setup page load animations
        this.setupPageLoadAnimations();
    }

    /*========================================
      SCROLL OBSERVERS SETUP
    ========================================*/
    setupScrollObserver() {
        const observerOptions = {
            root: null,
            rootMargin: '-5% 0px -5% 0px', // Reduced margin for earlier trigger
            threshold: [0, 0.1, 0.2, 0.3, 0.5, 0.7, 1]
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && entry.intersectionRatio > 0.1) {
                    // Add visible class for scroll animations
                    entry.target.classList.add('scroll-visible');
                    entry.target.classList.remove('scroll-hidden');

                    // Trigger specific section animations
                    this.triggerSectionAnimation(entry.target);

                    // Special handling for section titles
                    if (entry.target.classList.contains('section-title')) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                } else if (entry.intersectionRatio < 0.1) {
                    // Remove visible class when element is out of view
                    entry.target.classList.remove('scroll-visible');
                    if (!entry.target.classList.contains('section-title')) {
                        // Don't re-hide section titles once they're shown
                        entry.target.classList.add('scroll-hidden');
                    }
                }
            });
        }, observerOptions);

        // Observe all sections and animated elements
        this.observeElements(observer);
    }

    setupSectionObserver() {
        const sectionObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && entry.intersectionRatio > 0.5) {
                    // Update active section
                    this.updateActiveSection(entry.target);
                }
            });
        }, {
            threshold: 0.5
        });

        // Observe all main sections
        document.querySelectorAll('section, #hero, #alasan, #gerbang, #lowongan, #testimoni').forEach(section => {
            sectionObserver.observe(section);
        });
    }

    observeElements(observer) {
        // Section titles with specific animations
        document.querySelectorAll('.section-title').forEach((el, index) => {
            el.classList.add('scroll-hidden', 'from-bottom');
            observer.observe(el);

            // Also observe the title components separately
            const titleH1 = el.querySelector('h1');
            const underline = el.querySelector('.underline');

            if (titleH1) {
                titleH1.classList.add('scroll-hidden');
                observer.observe(titleH1);
            }

            if (underline) {
                underline.classList.add('scroll-hidden');
                observer.observe(underline);
            }
        });

        // Alasan cards
        document.querySelectorAll('.alasan-card').forEach((card, index) => {
            card.classList.add('scroll-hidden', 'from-bottom', `scroll-stagger-${(index % 4) + 1}`);
            observer.observe(card);
        });

        // Gerbang container
        document.querySelectorAll('.gerbang-container').forEach(el => {
            el.classList.add('scroll-hidden');
            observer.observe(el);
        });

        // Lowongan cards
        document.querySelectorAll('.lowongan-card').forEach((card, index) => {
            card.classList.add('scroll-hidden', 'scale-up', `scroll-stagger-${(index % 4) + 1}`);
            observer.observe(card);
        });

        // Vision mission boxes
        document.querySelectorAll('.vision, .mission').forEach((box, index) => {
            box.classList.add('scroll-hidden', index === 0 ? 'from-left' : 'from-right');
            observer.observe(box);
        });

        // Section dividers
        document.querySelectorAll('.section-divider').forEach(el => {
            observer.observe(el);
        });

        // Images
        document.querySelectorAll('.image-section img').forEach(img => {
            img.classList.add('scroll-hidden', 'scale-up');
            observer.observe(img);
        });

        // Content sections
        document.querySelectorAll('.content-section').forEach(content => {
            content.classList.add('scroll-hidden', 'from-right');
            observer.observe(content);
        });
    }

    /*========================================
      SECTION SPECIFIC ANIMATIONS
    ========================================*/
    triggerSectionAnimation(element) {
        const sectionId = element.id || element.closest('section')?.id;

        // Handle section title animations specifically
        if (element.classList.contains('section-title')) {
            this.animateSectionTitle(element);
            return;
        }

        switch (sectionId) {
            case 'hero':
                this.animateHeroSection();
                break;
            case 'alasan':
                this.animateAlasanCards();
                break;
            case 'gerbang':
                this.animateGerbangSection();
                break;
            case 'lowongan':
                this.animateLowonganCards();
                break;
            case 'testimoni':
                this.animateTestimoniSection();
                break;
        }
    }

    animateSectionTitle(titleElement) {
        // Animate the section title container
        titleElement.classList.add('scroll-visible');

        // Animate title text with delay
        const titleH1 = titleElement.querySelector('h1');
        if (titleH1) {
            setTimeout(() => {
                titleH1.classList.add('scroll-visible');

                // Animate span elements inside h1
                const spans = titleH1.querySelectorAll('span');
                spans.forEach((span, index) => {
                    setTimeout(() => {
                        span.style.opacity = '1';
                        span.style.transform = 'translateY(0)';
                        span.style.transition = 'all 0.6s ease-out';
                    }, index * 200);
                });
            }, 200);
        }

        // Animate underline with delay
        const underline = titleElement.querySelector('.underline');
        if (underline) {
            setTimeout(() => {
                underline.classList.add('scroll-visible');

                // Trigger dot animations
                setTimeout(() => {
                    underline.style.transform = 'scaleX(1)';
                }, 300);
            }, 400);
        }

        console.log('Section title animated:', titleElement);
    }

    animateHeroSection() {
        // Hero section animations are handled by CSS
        // Additional JS enhancements can be added here
        console.log('Hero section animated');
    }

    animateAlasanCards() {
        const cards = document.querySelectorAll('.alasan-card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('scroll-visible');

                // Add floating animation to icon
                const icon = card.querySelector('.icon-wrapper');
                if (icon) {
                    icon.style.animationDelay = `${index * 0.2}s`;
                }
            }, index * 100);
        });
    }

    animateGerbangSection() {
        const container = document.querySelector('.gerbang-container');
        if (container) {
            container.classList.add('scroll-visible');

            // Animate vision and mission boxes
            setTimeout(() => {
                document.querySelectorAll('.vision, .mission').forEach((box, index) => {
                    setTimeout(() => {
                        box.classList.add('scroll-visible');
                    }, index * 200);
                });
            }, 300);
        }
    }

    animateLowonganCards() {
        const cards = document.querySelectorAll('.lowongan-card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('scroll-visible');
            }, index * 150);
        });
    }

    animateTestimoniSection() {
        const testimonialSection = document.querySelector('#testimoni');
        if (testimonialSection && !testimonialSection.classList.contains('animated')) {
            testimonialSection.classList.add('animated');
            this.startTestimonialSlider();
        }
    }

    /*========================================
      TESTIMONIAL SLIDER FUNCTIONALITY
    ========================================*/
    setupTestimonialSlider() {
        // Create testimonial navigation if not exists
        this.createTestimonialNavigation();

        // Setup event listeners
        this.setupTestimonialEvents();
    }

    initTestimonials() {
        const cards = document.querySelectorAll('.testimonial-card');
        const dots = document.querySelectorAll('.nav-dot');

        if (cards.length > 0) {
            // Set first testimonial as active
            cards[0].classList.add('active');
            if (dots.length > 0) {
                dots[0].classList.add('active');
            }
        }
    }

    createTestimonialNavigation() {
        const testimonialSection = document.querySelector('#testimoni');
        if (!testimonialSection) return;

        const testimonialCards = testimonialSection.querySelectorAll('.testimonial-card');

        // Create navigation dots if they don't exist
        if (!testimonialSection.querySelector('.testimonial-nav')) {
            const nav = document.createElement('div');
            nav.className = 'testimonial-nav';

            testimonialCards.forEach((_, index) => {
                const dot = document.createElement('div');
                dot.className = 'nav-dot';
                dot.addEventListener('click', () => this.goToTestimonial(index));
                nav.appendChild(dot);
            });

            testimonialSection.appendChild(nav);
        }

        // Create navigation arrows if they don't exist
        if (!testimonialSection.querySelector('.nav-arrow')) {
            const prevArrow = document.createElement('div');
            prevArrow.className = 'nav-arrow prev';
            prevArrow.innerHTML = '<i class="fas fa-chevron-left"></i>';
            prevArrow.addEventListener('click', () => this.previousTestimonial());

            const nextArrow = document.createElement('div');
            nextArrow.className = 'nav-arrow next';
            nextArrow.innerHTML = '<i class="fas fa-chevron-right"></i>';
            nextArrow.addEventListener('click', () => this.nextTestimonial());

            const container = testimonialSection.querySelector('.testimonial-container');
            if (container) {
                container.appendChild(prevArrow);
                container.appendChild(nextArrow);
            }
        }
    }

    setupTestimonialEvents() {
        // Touch/swipe support for mobile
        let startX = null;
        const testimonialContainer = document.querySelector('.testimonial-container');

        if (testimonialContainer) {
            testimonialContainer.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
            });

            testimonialContainer.addEventListener('touchend', (e) => {
                if (startX === null) return;

                const endX = e.changedTouches[0].clientX;
                const diff = startX - endX;

                if (Math.abs(diff) > 50) {
                    if (diff > 0) {
                        this.nextTestimonial();
                    } else {
                        this.previousTestimonial();
                    }
                }

                startX = null;
            });
        }
    }

    goToTestimonial(index) {
        const cards = document.querySelectorAll('.testimonial-card');
        const dots = document.querySelectorAll('.nav-dot');

        if (index < 0 || index >= cards.length) return;

        // Remove active class from all
        cards.forEach(card => card.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));

        // Add active class to current
        cards[index].classList.add('active');
        if (dots[index]) {
            dots[index].classList.add('active');
        }

        this.currentTestimonialIndex = index;

        // Reset auto-slide timer
        this.resetTestimonialTimer();
    }

    nextTestimonial() {
        const cards = document.querySelectorAll('.testimonial-card');
        const nextIndex = (this.currentTestimonialIndex + 1) % cards.length;
        this.goToTestimonial(nextIndex);
    }

    previousTestimonial() {
        const cards = document.querySelectorAll('.testimonial-card');
        const prevIndex = (this.currentTestimonialIndex - 1 + cards.length) % cards.length;
        this.goToTestimonial(prevIndex);
    }

    startTestimonialSlider() {
        this.testimonialInterval = setInterval(() => {
            this.nextTestimonial();
        }, 3000); // Change every 3 seconds
    }

    resetTestimonialTimer() {
        if (this.testimonialInterval) {
            clearInterval(this.testimonialInterval);
            this.startTestimonialSlider();
        }
    }

    /*========================================
      STAGGERED ANIMATIONS
    ========================================*/
    setupStaggeredAnimations() {
        // Handle staggered animations for grouped elements
        const staggerGroups = {
            '.alasan-card': 100,
            '.lowongan-card': 80,
            '.testimonial-card': 200
        };

        Object.entries(staggerGroups).forEach(([selector, delay]) => {
            document.querySelectorAll(selector).forEach((element, index) => {
                element.style.transitionDelay = `${index * delay}ms`;
            });
        });
    }

    /*========================================
      SMOOTH SCROLLING
    ========================================*/
    setupSmoothScrolling() {
        // Handle anchor links for smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                e.preventDefault();

                const targetId = anchor.getAttribute('href');
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    const offsetTop = targetElement.offsetTop - 80; // Account for fixed header

                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    /*========================================
      PAGE LOAD ANIMATIONS
    ========================================*/
    setupPageLoadAnimations() {
        // Add CSS for section title animations
        const style = document.createElement('style');
        style.textContent = `
            .section-title.scroll-hidden {
                opacity: 0;
                transform: translateY(30px);
                transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            }
            
            .section-title.scroll-visible {
                opacity: 1;
                transform: translateY(0);
            }
            
            .section-title h1 span {
                opacity: 0;
                transform: translateY(20px);
                display: inline-block;
                transition: all 0.6s ease-out;
            }
            
            .section-title.scroll-visible h1 span {
                opacity: 1;
                transform: translateY(0);
            }
        `;
        document.head.appendChild(style);

        // Trigger hero animations on page load
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.body.classList.add('loaded');

                // Trigger hero section if it's in viewport
                const heroSection = document.querySelector('#hero');
                if (heroSection) {
                    const rect = heroSection.getBoundingClientRect();
                    if (rect.top < window.innerHeight && rect.bottom > 0) {
                        heroSection.classList.add('scroll-visible');
                    }
                }

                // Force check all section titles in viewport
                document.querySelectorAll('.section-title').forEach(title => {
                    const rect = title.getBoundingClientRect();
                    if (rect.top < window.innerHeight && rect.bottom > 0) {
                        title.classList.add('scroll-visible');
                        this.animateSectionTitle(title);
                    }
                });
            }, 100);
        });

        // Handle page visibility changes
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                // Pause animations when page is not visible
                if (this.testimonialInterval) {
                    clearInterval(this.testimonialInterval);
                }
            } else {
                // Resume animations when page becomes visible
                const testimonialSection = document.querySelector('#testimoni');
                if (testimonialSection && testimonialSection.classList.contains('animated')) {
                    this.startTestimonialSlider();
                }
            }
        });
    }

    /*========================================
      PERFORMANCE OPTIMIZATIONS
    ========================================*/
    throttle(func, limit) {
        let inThrottle;
        return function () {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        }
    }

    debounce(func, wait, immediate) {
        let timeout;
        return function () {
            const context = this, args = arguments;
            const later = function () {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }
}

/*========================================
  ENHANCED SCROLL EFFECTS
========================================*/
class EnhancedScrollEffects {
    constructor() {
        this.init();
    }

    init() {
        this.setupParallaxEffects();
        this.setupScrollProgress();
        this.setupScrollDirectionDetection();
    }

    setupParallaxEffects() {
        const parallaxElements = document.querySelectorAll('.hero-image img');

        window.addEventListener('scroll', this.throttle(() => {
            const scrollTop = window.pageYOffset;

            parallaxElements.forEach(element => {
                const rect = element.getBoundingClientRect();
                if (rect.bottom >= 0 && rect.top <= window.innerHeight) {
                    const speed = 0.5;
                    const yPos = -(scrollTop * speed);
                    element.style.transform = `translateY(${yPos}px)`;
                }
            });
        }, 16)); // ~60fps
    }

    setupScrollProgress() {
        // Create scroll progress bar
        const progressBar = document.createElement('div');
        progressBar.id = 'scroll-progress';
        progressBar.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: var(--color-primary);
            z-index: 9999;
            transition: width 0.1s ease;
        `;
        document.body.appendChild(progressBar);

        window.addEventListener('scroll', () => {
            const scrollTop = window.pageYOffset;
            const docHeight = document.body.scrollHeight - window.innerHeight;
            const scrollPercent = (scrollTop / docHeight) * 100;
            progressBar.style.width = scrollPercent + '%';
        });
    }

    setupScrollDirectionDetection() {
        let lastScrollTop = 0;

        window.addEventListener('scroll', () => {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > lastScrollTop) {
                document.body.classList.add('scrolling-down');
                document.body.classList.remove('scrolling-up');
            } else {
                document.body.classList.add('scrolling-up');
                document.body.classList.remove('scrolling-down');
            }

            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        });
    }

    throttle(func, limit) {
        let inThrottle;
        return function () {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        }
    }
}

/*========================================
  INITIALIZATION
========================================*/
document.addEventListener('DOMContentLoaded', () => {
    // Initialize scroll animation controller
    const scrollController = new ScrollAnimationController();

    // Initialize enhanced scroll effects
    const scrollEffects = new EnhancedScrollEffects();

    // Add loading class to body
    document.body.classList.add('loading');

    // Remove loading class after page load
    window.addEventListener('load', () => {
        setTimeout(() => {
            document.body.classList.remove('loading');
            document.body.classList.add('loaded');
        }, 500);
    });

    console.log('Website scroll animations initialized successfully!');
});

/*========================================
  EXPORT FOR MODULE USAGE (OPTIONAL)
========================================*/
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { ScrollAnimationController, EnhancedScrollEffects };
}
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>